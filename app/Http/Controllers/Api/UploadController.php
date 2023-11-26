<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Upload\UploadAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $url = app(UploadAction::class)->execute($request->all());

        return Response::json(['location' => $url]);
    }
}
