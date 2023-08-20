<?php

use App\Http\Controllers\Auth\GoogleLoginController;
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

/**
 * Put that route here to use web's middleware @see \App\Http\Kernel
 *
 * That will ensure cookie is set after google redirect user to our callback
 * By default EnsureFrontendRequestsAreStateful middleware will add cookie middleware
 * by check referer or origin but Google redirect has no these headers
 */
Route::get('/oauth/google/callback', [GoogleLoginController::class, 'callback']);
