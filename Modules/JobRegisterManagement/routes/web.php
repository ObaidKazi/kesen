<?php

use Illuminate\Support\Facades\Route;
use Modules\JobRegisterManagement\App\Http\Controllers\JobRegisterManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::resource('job-register-management', JobRegisterManagementController::class)->names('jobregistermanagement');
});
