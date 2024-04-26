<?php

use Illuminate\Support\Facades\Route;
use Modules\Language\App\Http\Controllers\LanguageController;

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


Route::resource('language-management', LanguageController::class)->names('language-management');
Route::get('language-management/disable-enable-language/{id}', [LanguageController::class, 'disableEnableClient'])->name('language-management.disableEnableClient');

