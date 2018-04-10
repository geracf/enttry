<?php

namespace App\Student;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Education extends Model
{
    protected $hidden = [
        'user_id', 'created_at', 'updated_at', 'technologies_used', 'achivements', 'start_date', 'end_date', 'current'
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

    public function prepareJson()
    {
        return [
            'id' => $this->id,
            'from' => date('M Y', strtotime($this->start_date)),
            'to' => $this->current ? 'now' : date('M Y', strtotime($this->end_date)),
            'degree' => $this->degree,
            'where' => $this->school_name,
            'url' => $this->school_website,
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Education $education) {
            if ($education->picture) {
                $education->picture->delete();
            }
        });
    }
}
