<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/




Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1', 'as' => 'v1.'], function () {

    Route::group(['prefix' => 'auth', 'middleware' => ['guest']], function () {
        Route::post('register', 'RegisterController@register');
        Route::post('login', 'AuthController@login');
        Route::post('login/facebook', 'RegisterController@facebook_register');
        Route::post('login/facebook', 'RegisterController@facebook_register');
        Route::get('photo-events/{id}/{userid}', 'PhotoEventsController@index');
        Route::post('event-images-store', 'EventImageController@store');
        Route::get('event-images/{id}/{userid}', 'EventImageController@show');
        Route::get('visitedEventByUser/{userid}', 'PhotoEventsController@visitedEventByUser');

        /*Event Detail*/

        Route::get('event-images-detail/{event_id}/{user_id}', 'EventImageController@index');
        Route::get('event-single-image-detail/{image_id}/{user_id}', 'EventImageController@event_single_image_detail');

        /*For Comment*/

        Route::post('add-event-images-comment', 'EventImageController@comment_store');
        Route::post('edit-event-images-comment/{id}', 'EventImageController@comment_update');
        Route::get('delete-event-images-comment/{id}', 'EventImageController@comment_delete');

        /*Like*/

        Route::post('add-event-images-like', 'EventImageController@like_store');
        Route::get('delete-event-images-like/{event_image_id}/{userid}', 'EventImageController@like_delete');

        /*Comment Like*/

        Route::post('add-event-images-comment-like', 'EventImageController@comment_like_store');




        // Password Reset
         Route::post('forgot-password', 'AuthController@forgot_password');
    });

    Route::group(['prefix' => 'apivalidator','middleware' => 'apiValidator'], function () {

            Route::post('logout', 'AuthController@logout');
            Route::get('me', 'AuthController@me');
            //Route::get('photo-events/{id}', 'PhotoEventsController@index');
    });


    Route::group(['middleware' => ['auth:api']], function () {

        // Page
        Route::apiResource('pages', 'PagesController');

        // Faqs
        Route::apiResource('faqs', 'FaqsController');

        // Blog Categories
        Route::apiResource('blog-categories', 'BlogCategoriesController');

        // Blog Tags
        Route::apiResource('blog-tags', 'BlogTagsController');

        // Blogs
        Route::apiResource('blogs', 'BlogsController');

        // PhotoEvent
        //Route::apiResource('photo-events', 'PhotoEventsController');
        
    });
});
