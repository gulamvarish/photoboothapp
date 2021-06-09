<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @group Authentication
 *
 * Class AuthController
 *
 * Fullfills all aspects related to authenticate a user.
 */
class RegisterController extends Controller
{
  
    public function register(Request $request)
    {
       

        /*For user Registration Validation*/


        $this->validate($request, [
            'first_name' => 'required',
            'email'      => 'required|email|max:255|unique:users,email',
            'password'   => 'required|min:4',
            'device_id'  => 'required',
        ]);  

        $response = array(); 

        /*For user Registration*/
        try {


            
            $user                    = new User;
            $user->first_name        = $request['first_name'];            
            $user->email             = $request['email'];
            $user->device_id         = $request['device_id'];
            $user->password          = bcrypt($request['password']);
            $user->confirmation_code = md5(uniqid(mt_rand(), true));
            $user->confirmed         = 1;
            $user->save();
            

             $roleinsert = DB::table('role_user')->insert([
                    'user_id' => $user->id,
                    'role_id' => 6
                ]);
         
            //$user = User::create(request(['first_name', 'email', 'password', 'device_id']));


        
           auth()->login($user);

           $response['success']     = true;
           $response['message']     = 'User Created Successfully';

        } catch (UserNotFoundException $e) {
            $response['success']     = false;
            $response['message']     = 'User Not Created Successfully';
        }
        return $response;

         

      
    }

    public function facebook_register(Request $request)
    {
       
        /*For user Login Validation*/

        $this->validate($request, [
            'first_name'   => 'required',            
            'facebook_id'  => 'required',

        ]); 

          $facebook = substr($request['facebook_id'], 0, 8);

          /*For Email Check blank*/

          if(!empty($request['email'])){
                  $email    = $request['email'];
           }else{
                 $email    = $facebook.'@facebook.com';
           }

          $password = $facebook;          
         //echo $userscheck     = User::find($request['facebook_id']);

          $userscheck    = DB::table('users')
                         ->where('facebook_id', '=', $request['facebook_id'])->first();            
            

        $response = array(); 
      if(count((array)$userscheck)>0){
             
           $credentials = Auth::attempt(['email' => $email, 'password' => $password]);
             try {             

                 //auth()->login($userscheck);

                   $response['success']     = true;
                   $response['message']     = 'User Login Successfully';

                } catch (UserNotFoundException $e) {
                    $response['success']     = false;
                    $response['message']     = 'User Not Login Successfully';
                }

                return $response;


        }else{  

        /*For user Registration*/
        try {  
            
                    $user                    = new User;
                    $user->first_name        = $request['first_name'];            
                    $user->email             = $email;
                    $user->facebook_id       = $request['facebook_id'];
                    $user->password          = bcrypt($password);
                    $user->confirmation_code = md5(uniqid(mt_rand(), true));
                    $user->confirmed         = 1;
                    $user->save();
            

               $roleinsert = DB::table('role_user')->insert([
                    'user_id' => $user->id,
                    'role_id' => 6
                ]);      
                    
                auth()->login($user);

                   $response['success']     = true;
                   $response['message']     = 'User Login Successfully';

                } catch (UserNotFoundException $e) {
                    $response['success']     = false;
                    $response['message']     = 'User Not Login Successfully';
                }
                return $response;

            }

      
    }

    





}
