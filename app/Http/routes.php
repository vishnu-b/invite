<?php

Route::group(['prefix' => 'invite'], function () {
    Route::get('/', function () {
        if (Auth::check()) {
            // return 'Welcome back ' . Auth::user()->name;
            return view('welcome');
        }
        return 'Hi guest. ' . link_to('invite/login', 'Login with Google');
    });

    Route::get('login', 'AuthController@login');

    Route::get('get_contacts', [
        'as'=>'google.import',
        'uses'=>'ContactController@getContacts'
    ]);

    Route::get('contacts/', [
        'as' => 'contacts',
        'uses' => 'ContactController@viewContacts'
    ]);
});
