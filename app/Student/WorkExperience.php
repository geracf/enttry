<?php

namespace App\Student;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class WorkExperience extends Model
{
    protected $hidden = [
        'user_id', 'technologies_used', 'responsibilities', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function picture()
    {
        return $this->morphOne(\App\Picture::class, 'pictureable');
    }

    public function document()
    {
        return $this->morphOne(Document::class, 'documentable');
    }

    public function thumbnail()
    {
        $this->picture ? $thumbnail = Storage::url($this->picture->path) : $thumbnail = null;
        unset($this->picture);
        return $thumbnail;
    }

    public function file_url()
    {
        $this->document ? $url = Storage::url($this->document->path) : $url = null;
        unset($this->document);
        return $url;
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
            'title' => $this->title,
            'where' => $this->organization_name,
            'url' => $this->organization_website,
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (WorkExperience $work) {
            if ($work->picture) {
                $work->picture->delete();
            }
            if ($work->document) {
                $work->document->delete();
            }
        });
    }
}
