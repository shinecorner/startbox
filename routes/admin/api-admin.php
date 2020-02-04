<?php
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

//Auth
Route::middleware('api-guest')->prefix('auth')->group(function () {
    Route::post('login', 'Api\AdminLoginController@login');
    /* Route::post('register', 'Api\AdminRegisterController@register'); */
    /* Route::post('/oauth/token', 'Api\AdminLoginController@get_token'); */
    Route::post('reset/password', 'AdminResetPasswordController@reset');
    Route::post('password/email', 'AdminForgotPasswordController@sendResetLinkEmail');
});

Route::middleware('api-admin')->group(function () {
    //Auth
    Route::prefix('auth')->group(function () {
        Route::get('/logout', 'Api\AdminLoginController@logout');
    });

    //Organizations non resource routes
    Route::prefix('organizations')->group(function () {
        Route::get('{organization_id}/facilities', 'Api\OrganizationController@organization_facilities');
        Route::get('{organization_id}/facilities/{facility_id}', 'Api\OrganizationController@show_organization_facility');
        Route::get('{organization_id}/facilities/{facility_id}/locations', 'Api\OrganizationController@organization_facility_locations');
        Route::get('{organization_id}/facilities/{facility_id}/locations/{location_id}', 'Api\OrganizationController@organization_facility_location');
        Route::post('{organization_id}/domain-settings', 'Api\OrganizationController@domain_settings');
    });
    //Organizations resourse routes
    Route::apiResource('organizations', 'Api\OrganizationController');

    //Facilities non resource routes
    Route::prefix('facilities')->group(function () {
        Route::get('{facility_id}/locations', 'Api\FacilityController@facility_locations');
        Route::get('{facility_id}/locations/{location_id}', 'Api\ApiFacilityController@show_facility_location');
        Route::post('{facility_id}/settings', 'Api\ApiFacilityController@settings');
    });
    //Facilities resourse routes
    Route::apiResource('facilities', 'Api\FacilityController');

    //Locations non resource routes
    Route::prefix('locations')->group(function () {
        Route::post('{location_id}/settings', 'Api\LocationController@settings');
    });
    //Locations resourse routes
    Route::apiResource('locations', 'Api\LocationController');


    //Users non resource routes
    Route::prefix('users')->group(function () {
        Route::get('{id}/roles', 'Api\UserController@get_user_roles');
        Route::get('{id}/permissions', 'Api\UserController@get_user_permissions');
        Route::post('{id}/roles/assign/{role_id}', 'Api\UserController@assign_role');
        Route::post('{id}/permissions/assign/{permission_id}', 'Api\UserController@assign_permission');
        Route::delete('{id}/roles/remove/{role_id}', 'Api\UserController@remove_role');
        Route::delete('{id}/permissions/remove/{permission_id}', 'Api\UserController@remove_permission');
    });
    //Users resourse routes
    Route::apiResource('users', 'Api\UserController');

    //Permissions non resource routes
    Route::prefix('permissions')->group(function () {
        //TODO
    });
    //Permissions resourse routes
    Route::apiResource('permissions', 'Api\PermissionController');

    //Roles non resource routes
    Route::prefix('roles')->group(function () {
        //TODO
    });
    //Roles resourse routes
    Route::apiResource('roles', 'Api\RoleController');

    //Patients non resource routes
    Route::prefix('patients')->group(function () {
        //TODO
    });
    //Patients resourse routes
    Route::apiResource('patients', 'Api\PatientController');

    //Procedures non resource routes
    Route::prefix('procedures')->group(function () {
        //TODO
    });
    //Procedures resourse routes
    Route::apiResource('procedures', 'Api\ProcedureController');

    //Trainings non resource routes
    Route::prefix('trainings')->group(function () {
        //TODO
    });
    //Trainings resourse routes
    Route::apiResource('trainings', 'Api\TrainingController');
});
