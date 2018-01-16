<?php

Route::group([
    'middleware' => 'admin'
], function () {
    /**
     * All route names are prefixed with 'admin.'.
     */
    Route::redirect('/', '/admin/dashboard', 301);
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');


    /**
     * Routes for CactusAdmin
     */

    Route::group([
        'prefix'     => 'cactus',
        'as'         => 'cactus.',
        'namespace'  => 'CactusAdmin',
    ], function () {
        Route::group([
            'middleware' => 'role:administrator',
        ], function () {
            Route::group([
                'prefix'     => 'apps',
                'as'         => 'apps.'
            ], function(){
                Route::get('/', 'AppsAdminController@index')->name('index');
                Route::get('/add', 'AppsAdminController@add')->name('add');
                Route::post('/add', 'AppsAdminController@create')->name('create');
                Route::get('{id}/edit', 'AppsAdminController@edit')->name('edit');
                Route::post('{id}/edit', 'AppsAdminController@update')->name('update');
            });
        });
    });

});

/**
 * Admin Login
 */
Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function () {

    /*
    * These routes require the user to be logged in
    */
    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', 'LoginController@logout')->name('logout');

        //For when admin is logged in as user from backend
        Route::get('logout-as', 'LoginController@logoutAs')->name('logout-as');

        // These routes can not be hit if the password is expired
        Route::group(['middleware' => 'password_expires'], function () {
            // Change Password Routes
            Route::patch('password/update', 'UpdatePasswordController@update')->name('password.update');
        });

        // Password expired routes
        if (is_numeric(config('access.users.password_expires_days'))) {
            Route::get('password/expired', 'PasswordExpiredController@expired')->name('password.expired');
            Route::patch('password/expired', 'PasswordExpiredController@update')->name('password.expired.update');
        }
    });

    /*
     * These routes require no user to be logged in
     */
    Route::group(['middleware' => 'guest'], function () {
        // Authentication Routes
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login.post');

        // Password Reset Routes
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.email');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email.post');

        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
    });
});
