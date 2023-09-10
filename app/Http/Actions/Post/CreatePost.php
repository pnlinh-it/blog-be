<?php

namespace App\Http\Actions\Post;

use App\Http\Actions\BaseApiAction;
use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CreatePost extends BaseApiAction
{
    public function rules(array $data): array
    {
        return [
            'title' => ['required'],
            'content' => ['required'],
        ];
    }

    public function execute(array $data)
    {
        $data = $this->validate($data);

        Arr::set($data, 'slug', $this->createSlug(Arr::get($data, 'title')));

        return Post::create($data);
    }

    // https://github.com/spatie/laravel-sluggable/blob/main/src/HasSlug.php#L133
    public function createSlug(string $title): string
    {
        $slug = Str::substr($title, 0, 250);
        $originalSlug = $slug;
        $i = 1;

        while ($this->isSlugExist($slug)) {
            $slug = $originalSlug . '-' . $i++;
        }

        return $slug;
    }

    public function isSlugExist(string $slug): bool
    {
        return Post::where('slug', $slug)->exists();
    }
}
