<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Response::json([
            'url' => Socialite::driver('google')
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    public function callback()
    {
        // TODO update later
        Auth::login(User::firstOrFail(), remember: true);

        return Redirect::to(config('app.frontend_url'));
    }
}
