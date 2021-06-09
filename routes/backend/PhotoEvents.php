<?php

// PhotoEvents Management
Route::group(['namespace' => 'PhotoEvents'], function () {
    Route::resource('photo-events', 'PhotoEventsController', ['except' => ['show']]);

    //For DataTables
    Route::post('photo-events/get', 'PhotoEventsTableController')->name('photoEvents.get');
});
