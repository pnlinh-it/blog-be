<?php

namespace App\Http\Actions\Upload;

use App\Http\Actions\BaseApiAction;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UploadAction extends BaseApiAction
{
    public function rules(array $data): array
    {
        // ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']
        return [
            'image' => 'required|image',
        ];
    }

    public function execute(array $data)
    {
        $path = Storage::drive('s3')->putFile(
            'blog/medias',
            $data['image'],
            Filesystem::VISIBILITY_PUBLIC
        );

        return Storage::drive('s3')->url($path);
    }
}
