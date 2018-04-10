<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $hidden = [
        'offer_id', 'updated_at', 'student_id'
    ];

    public function student()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function application()
    {
        return $this->belongsTo(Student\Application::class);
    }

    public function lastMessage()
    {
        return isset($this->messages->sortBy('id')->take(-1)->values()[0]->message) ?
           str_limit($this->messages->sortBy('id')->take(-1)->values()[0]->message, 50, '...') : 'No hay mensajes';
    }

    public function subjectName()
    {
        return $this->application->offer->name;
    }

    public function thumbnail()
    {
        return $this->application->offer->thumbnail();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (ChatRoom $chat) {
            if ($chat->messages) {
                $chat->messages()->delete();
            }
        });
    }
}
