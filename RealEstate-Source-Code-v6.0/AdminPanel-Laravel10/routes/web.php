<?php

use App\Http\Controllers\CitiesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsCategoriesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\PropertyCategoriesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

// Admin & Agent
Route::group(['middleware' => ['auth', 'role:admin,agent']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('/properties', PropertiesController::class)->except(['show']);

    // Uploads
    Route::get('/upload/image', [UploadController::class, 'image_get'])->name('upload.image');
    Route::post('/upload/image', [UploadController::class, 'image_create']);
    Route::delete('/upload/image', [UploadController::class, 'image_delete']);

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update']);
});

// Only Admin
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('/users', UsersController::class)->except(['show', 'create', 'store', 'destroy']);
    Route::post('/users/update_role', [UsersController::class, 'updateRole']);

    Route::resource('/cities', CitiesController::class)->except(['show']);
    Route::resource('/property_categories', PropertyCategoriesController::class)->except(['show']);
    Route::resource('/news', NewsController::class)->except(['show']);
    Route::resource('/news_categories', NewsCategoriesController::class)->except(['show']);
});