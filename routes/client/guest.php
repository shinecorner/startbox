<?php

/***************************************************************************************
 ** AUTH
 ***************************************************************************************/

Route::post('auth/register', 'RegisterController@newUser');
Route::post('auth/refresh', 'AuthController@refresh');
Route::post('auth/login', 'AuthController@login');
Route::post('auth/logout', 'AuthController@logout');

Route::get('auth/email-is-unique', 'AuthController@emailIsUnique');
Route::get('auth/password-is-valid', 'AuthController@passwordIsValid');
Route::get('auth/username-is-unique', 'AuthController@usernameIsUnique');
Route::get('auth/password/validate-token', 'ResetPasswordController@validateToken');

Route::post('auth/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('auth/password/reset', 'ResetPasswordController@reset');

Route::post('confirm-email', 'ConfirmEmailController@confirm');
Route::post('resend-confirm-email', 'ConfirmEmailController@create');