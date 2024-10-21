<?php

use App\Http\Controllers\Api\CookieController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Http\Request;
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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/{post}', [PostController::class, 'show']);
        Route::post('/', [PostController::class, 'store']);
        Route::put('/{post}', [PostController::class, 'update']);
    });

    Route::group(['prefix' => 'tags'], function () {
        Route::get('/', [TagController::class, 'index']);
        Route::post('/', [TagController::class, 'store']);
    });

    Route::post('/upload/media', [UploadController::class, 'store']);
});

Route::group(['prefix' => 'cks'], function () {
    Route::post('/', [CookieController::class, 'store']);
});

require __DIR__ . '/auth.php';
