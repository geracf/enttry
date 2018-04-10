<?php

namespace App\Student;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $hidden = [
        'id', 'documentable_id', 'documentable_type', 'created_at', 'updated_at',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }

    public function url()
    {
        return $this->path ? Storage::url($this->path) : false;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Document $document) {
            Storage::delete($document->path);
        });
    }
}
