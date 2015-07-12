<?php

Route::group(['prefix' => 'invite'], function () {
    Route::get('/', function () {
        if (Auth::check()) {
            return view('home');
        }
        // return 'Hi guest. ' . link_to('invite/login', 'Login with Google');
        return view('login');
    });

    Route::get('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');

    Route::get('get_contacts', [
        'as'=>'google.import',
        'uses'=>'ContactController@getContacts'
    ]);

    Route::get('contacts/', [
        'as' => 'contacts',
        'uses' => 'ContactController@viewContacts'
    ]);

    Route::get('invite/{email}', 'ContactController@invite');
});
