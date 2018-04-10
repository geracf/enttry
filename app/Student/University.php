<?php

namespace App\Student;

use App\User;
use App\Major;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    public function students()
    {
        return $this->hasMany(User::class);
    }

    public function majors()
    {
        return $this->hasMany(Major::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (University $university) {
            // something
        });
    }
}
