<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Post\CreatePost;
use App\Http\Actions\Post\UpdatePost;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PostController extends Controller
{
    public function show(Post $post)
    {
        return $post;
    }

    public function store(Request $request)
    {
        return App::make(CreatePost::class)->execute($request->all());
    }

    public function update(Request $request, Post $post)
    {
        return App::make(UpdatePost::class, ['post' => $post])->execute($request->all());
    }
}
