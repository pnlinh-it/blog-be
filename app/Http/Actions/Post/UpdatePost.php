<?php

namespace App\Http\Actions\Post;

use App\Http\Actions\BaseApiAction;
use App\Models\Post;

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
        ];
    }

    public function execute(array $data): Post
    {
        $this->post->update($this->validate($data));

        return $this->post;
    }
}
