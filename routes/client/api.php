<?php

Route::get('status', function() {
    return \App\Helpers\Responder::success(null, 'Ok!');
});

Route::get('check-email-confirmed', 'ConfirmEmailController@checkStatus');
Route::get('user', 'AuthController@user')->name('user');

// Patients
Route::get('patients', 'API\PatientController@list');
Route::get('patients/{patient}', 'API\PatientController@get');
Route::post('patients', 'API\PatientController@create');
Route::put('patients/{patient}', 'API\PatientController@update');
Route::delete('patients/{patient}', 'API\PatientController@delete');

// Providers
Route::get('patients/{patient}/providers', 'API\ProviderController@listByPatient');
Route::get('providers', 'API\ProviderController@list');
Route::get('providers/{provider}', 'API\ProviderController@get');
Route::post('providers', 'API\ProviderController@create');
Route::put('providers/{provider}', 'API\ProviderController@update');
Route::delete('providers/{provider}', 'API\ProviderController@delete');

