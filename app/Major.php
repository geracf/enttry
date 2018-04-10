<?php

namespace App;

use App\User;
use App\Student\University;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
