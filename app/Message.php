<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function picture()
    {
        return $this->morphOne(Picture::class, 'pictureable');
    }

    public function document()
    {
        return $this->morphOne(Document::class, 'documentable');
    }

    public function sentByMe($user_id)
    {
        return $this->sender_id == $user_id;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Message $message) {
            if ($this->picture) {
                $this->picture->delete();
            }
            if ($this->document) {
                $this->document->delete();
            }
        });
    }
}
