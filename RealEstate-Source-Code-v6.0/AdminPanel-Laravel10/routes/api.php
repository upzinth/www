<?php

use App\Http\Controllers\api\v1\AppSettingsController;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\DashboardController;
use App\Http\Controllers\api\v1\NewsController;
use App\Http\Controllers\api\v1\ProfileController;
use App\Http\Controllers\api\v1\PropertiesController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'get']);

// Properties
Route::post('/properties/search', [PropertiesController::class, 'searchProperties']);
Route::get('/properties/search/constants', [PropertiesController::class, 'searchConstants']);

// App settings
Route::get('/appsettings', [AppSettingsController::class, 'get']);
Route::get('/appsettings/aboutus', [AppSettingsController::class, 'aboutUs']);
Route::get('/appsettings/userterms', [AppSettingsController::class, 'userTerms']);
Route::get('/appsettings/privacypolicy', [AppSettingsController::class, 'privacyPolicy']);

// News
Route::get('/news', [NewsController::class, 'get']);

Route::middleware('auth:sanctum')->group(function () {
    // Properties
    Route::get('/properties/likes', [PropertiesController::class, 'likedProperties']);
    Route::post('/properties/like', [PropertiesController::class, 'likeProperty']);

    // Profile
    Route::post('/profile/updateprofileimage', [ProfileController::class, 'updateProfileImage']);
    Route::get('/profile/userinfo', [ProfileController::class, 'userInfo']);
});