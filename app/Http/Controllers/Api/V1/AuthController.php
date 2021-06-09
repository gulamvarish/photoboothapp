<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Auth\User;
use App\Http\Controllers\Api\V1\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

/**
 * @group Authentication
 *
 * Class AuthController
 *
 * Fullfills all aspects related to authenticate a user.
 */
class AuthController extends APIController
{
    /**
     * Attempt to login the user.
     *
     * If login is successfull, you get an api_token in response. Use that api_token to authenticate yourself for further api calls.
     *
     * @bodyParam email string required Your email id. Example: "user@test.com"
     * @bodyParam password string required Your Password. Example: "abc@123_4"
     *
     * @responseFile status=401 scenario="api_key not provided" responses/unauthenticated.json
     * @responseFile responses/auth/login.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $credentials = $request->only(['email', 'password']);

        try {
            if (! Auth::attempt($credentials)) {
                return $this->throwValidation(trans('api.messages.login.failed'));
            }

            $user = $request->user();

            $passportToken = $user->createToken('API Access Token');

            // Save generated token
            $passportToken->token->save();

            $token = $passportToken->accessToken;

            $user = User::find($user->id);            
            $user->api_token = $token;
            $user->save();

        } catch (\Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'user_id' => $user->id,
            'message' => trans('api.messages.login.success'),
            'token'   => $token,
        ]);
    }


    /**
     * Get the authenticated User.
     *
     * @responseFile status=401 scenario="api_key not provided" responses/unauthenticated.json
     * @responseFile responses/auth/me.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard()->user());
    }

    /**
     * Attempt to logout the user.
     *
     * After successfull logut the token get invalidated and can not be used further.
     *
     * @responseFile status=401 scenario="api_key not provided" responses/unauthenticated.json
     * @responseFile responses/auth/logout.json
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
        } catch (\Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'message' => trans('api.messages.logout.success'),
        ]);
    }


    public function forgot_password(Request $request)
        {
            $input = $request->all();
            $rules = array(
                'email' => "required|email",
            );
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
            } else {
                try {
                    $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                        $message->subject($this->getEmailSubject());
                    });
                    switch ($response) {
                        case Password::RESET_LINK_SENT:
                            return \Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
                        case Password::INVALID_USER:
                            return \Response::json(array("status" => 400, "message" => trans($response), "data" => array()));
                    }
                } catch (\Swift_TransportException $ex) {
                    $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
                } catch (Exception $ex) {
                    $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
                }
            }
            return \Response::json($arr);
        }

    
}
