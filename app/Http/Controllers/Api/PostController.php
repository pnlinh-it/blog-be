<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Post\CreatePost;
use App\Http\Actions\Post\UpdatePost;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $keywordFilter = AllowedFilter::custom(
            'keyword',
            new FilterLikeMultipleFields(),
            'title,content'
        );
        // $roleFilter = AllowedFilter::exact('roles', 'roles.name')->default('default');
        // $roleFilter = AllowedFilter::exact('roles', 'roles.name');
        $createdBeforeFilter = AllowedFilter::scope('created_before');
        $createdAfterFilter = AllowedFilter::scope('created_after');

        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters([
                $keywordFilter,
                'title',
                'content',
                $createdBeforeFilter,
                $createdAfterFilter,
            ])
            ->defaultSort('-created_at')
            ->allowedSorts(
                'id',
                'title',
                'content',
                'created_at'
                // AllowedSort::field('created_at')->defaultDirection(SortDirection::DESCENDING)
            )
            // ->with('roles')
            ->paginate($request->query('per_page'));

        return PostResource::collection($posts);
    }
    public function show(Post $post)
    {
        $post->load('tags');

        return new PostResource($post);
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
