<?php

namespace App\Student;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FeaturedWork extends Model
{
    protected $hidden = [
        'user_id', 'technologies_used', 'desc', 'release_date', 'updated_at', 'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function picture()
    {
        return $this->morphOne(\App\Picture::class, 'pictureable');
    }

    public function thumbnail()
    {
        $this->picture ? $thumbnail = Storage::url($this->picture->path) : $thumbnail = null;
        unset($this->picture);
        return $thumbnail;
    }

    public function full()
    {
        $this->makeVisible($this->hidden);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (FeaturedWork $feature) {
            if ($feature->picture) {
                $feature->picture->delete();
            }
        });
    }
}
