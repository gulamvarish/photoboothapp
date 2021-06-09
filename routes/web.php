<?php

use App\Http\Controllers\LanguageController;

/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
     
        
});


/*For facebook Login*/

/*Route::get('/facebooklogin', function () {
    return view('frontend.facebooklogin');
});
Route::get('auth/facebook', 'Frontend\Auth\FacebookLoginController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Frontend\Auth\FacebookLoginController@handleFacebookCallback');
*/

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */

    include_route_files(__DIR__.'/backend/');
  
    /* For LayoutsPages Controller*/

    Route::get('layoutspages/edit/{id}', 'LayoutsPages\LayoutsController@edit');
    Route::put('layoutspages/update/{id}', 'LayoutsPages\LayoutsController@update');
    Route::post('layoutspages/delete/{id}', 'LayoutsPages\LayoutsController@destroy');

    /* For LayoutsPages Controller*/

    Route::get('photo-events/edit/{id}', 'PhotoEvents\PhotoEventsController@edit');
    Route::put('photo-events/update/{id}', 'PhotoEvents\PhotoEventsController@update');
    Route::post('photo-events/delete/{id}', 'PhotoEvents\PhotoEventsController@destroy');

    Route::post('photo-events/deletenolayoutajax', 'PhotoEvents\PhotoEventsController@destroy_nolayout');
    Route::get('photo-events/qrcodegenrate/{id}', 'PhotoEvents\PhotoEventsController@qrcode');


   


 



});



      


