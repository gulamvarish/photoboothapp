<?php

// Layouts Management
Route::group(['namespace' => 'LayoutsPages'], function () {
    Route::resource('layoutspages', 'LayoutsController', ['except' => ['show']]);


    //For DataTables
    Route::post('layoutspages/get', 'LayoutsTableController')->name('layoutspages.get');

});
