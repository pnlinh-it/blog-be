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
 * By default api route has no Cookie middleware
 * But Sanctum add EnsureFrontendRequestsAreStateful middleware to handle Cookie
 * EnsureFrontendRequestsAreStateful check referer or origin but Google redirect has no these headers
 * @see EnsureFrontendRequestsAreStateful::fromFrontend()
 */
Route::get('/api/oauth/google/callback', [GoogleLoginController::class, 'callback']);
