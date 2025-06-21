<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function storeAdImage($file)
    {
        $image = Image::make($file);
        $image->fit(800, 600);
        $path = 'ads/' . Str::uuid() . '.' . $file->extension();
        Storage::disk('public')->put($path, $image->encode());
        return $path;
    }
}