<?php

use Illuminate\Support\Facades\Route;
use Modules\JobCardManagement\App\Http\Controllers\JobCardManagementController;

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
Route::resource('jobcard-management', JobCardManagementController::class)->names('jobcard-management');
});