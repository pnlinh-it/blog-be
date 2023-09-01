<?php

namespace App\Http\Actions\Post;

use App\Http\Actions\BaseApiAction;
use App\Models\Post;

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

        return Post::create($data);
    }
}
