<?php

namespace App\Http\Actions\Post;

use App\Http\Actions\BaseApiAction;
use App\Models\Post;
use Illuminate\Support\Arr;

class UpdatePost extends BaseApiAction
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function rules(array $data): array
    {
        return [
            'title' => ['required'],
            'content' => ['required'],
            'tags' => ['sometimes', 'array'],
            'tags.*' => ['required', 'exists:tags,id'],
        ];
    }

    public function execute(array $data): Post
    {
        $data = $this->validate($data);

        $this->post->update($data);

        if ($tagIds = Arr::get($data, 'tags')) {
            $this->post->tags()->sync($tagIds);
        }

        return $this->post;
    }
}
