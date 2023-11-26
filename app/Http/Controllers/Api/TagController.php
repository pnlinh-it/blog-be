<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Tag\CreateTag;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $keywordFilter = AllowedFilter::custom(
            'keyword',
            new FilterLikeMultipleFields(),
            'name,slug'
        );

        $posts = QueryBuilder::for(Tag::class)
            ->allowedFilters([$keywordFilter])
            ->defaultSort('-created_at')
            ->paginate(perPage: $request->query('per_page'));

        return TagResource::collection($posts)->withQuery($request->query());
    }

    public function store(Request $request)
    {
        $tag = app(CreateTag::class)->execute($request->all());

        return new TagResource($tag);
    }
}
