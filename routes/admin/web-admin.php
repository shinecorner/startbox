<?php

/*
|--------------------------------------------------------------------------
| Web Admin Routes
|--------------------------------------------------------------------------
*/



Route::get('/login', function () {
    return view('admin.auth.login');
})->name('login');

Route::get('/register', function () {
    return view('admin.auth.register');
})->name('register');

Route::get('/recover-password', function () {
    return view('admin.auth.recover_password');
})->name('recover-password');

Route::get('/password/reset', 'AdminResetPasswordController@showResetForm')->name('recover-password');

Route::middleware([/* 'auth' */])->group(function () {
   /*  Route::get('/', function () {
        return redirect('/admin/dashboard');
    }); */
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/users/{path?}/{path1?}/{path2?}/{path3?}/{path4?}', 'UserController@index');
    Route::get('/organizations/{path?}/{path1?}/{path2?}/{path3?}/{path4?}', 'OrganizationController@index');
});
