<?php

namespace App\Student;

use App\ChatRoom;
use App\Offer;
use App\Student\Document;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Application extends Model
{

    // Relationships

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function chats()
    {
        return $this->hasOne(ChatRoom::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Application $application) {
            if ($application->documents) {
                foreach ($application->documents as $document) {
                    $document->delete();
                }
            }
        });
    }
}
