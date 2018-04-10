<?php

namespace App\Traits;

use Image;
use App\Picture;
use Illuminate\Support\Facades\Storage;

trait UsesPictures
{
    public function addMany($model, $pictures, $url = false)
    {
        foreach ($pictures as $picture) {
            $new_img = Image::make($picture);
            $new_img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $new_img->save('./tmp/temp.jpg');
            $new_img->destroy();

            $img = file_get_contents('./tmp/temp.jpg');

            if (!$url) {
                $url = "photos/".md5($img).".jpg";
            }

            Storage::disk('s3')->getDriver()->put($url, $img, [ 'visibility' => 'public', 'CacheControl' => 'max_age=2592000']);

            $pic = new Picture;
            $pic->path = $url;
            $pic->desc = $model->name ?: 'Picture';

            $model->pictures()->save($pic);
        }
    }
}
