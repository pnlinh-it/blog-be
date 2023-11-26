<?php

namespace App\Http\Actions\Tag;

use App\Http\Actions\BaseApiAction;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateTag extends BaseApiAction
{
    public function rules(array $data): array
    {
        return [
            'name' => 'required|min:3',
        ];
    }

    public function execute(array $data): Tag
    {
        $data = $this->validate($data);

        $slug = Str::slug($data['name']);
        if (Tag::where('slug', $slug)->exists()) {
            throw ValidationException::withMessages(['name' => 'Tag is exist']);
        }

        Arr::set($data, 'slug', $slug);

        return Tag::create($data);
    }
}
