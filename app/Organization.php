<?php

namespace App;

use App\Offer;
use App\Student\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Billable;

class Organization extends Model
{

    use Billable;

    protected $fillable = [
        'name', 'desc', 'address', 'website', 'email', 'twitter', 'facebook', 'linkedin'
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    // Relationships

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function pictures()
    {
        return $this->morphMany(Picture::class, 'pictureable');
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function applications()
    {
        return $this->hasManyThrough(Application::class, Offer::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function thumbnail()
    {
        if ($this->pictures->count() > 0) {
            return Storage::url($this->pictures[0]->path);
        }
        return '/img/student-background.png';
    }

    // Methods
    public static function boot()
    {
        parent::boot();

        static::deleting(function (Organization $organization) {
            if ($organization->pictures->count() > 0) {
                foreach ($$organization->pictures as $picture) {
                    $picture->delete();
                }
            }
            if ($organization->members->count() > 0) {
                foreach ($organization->members as $member) {
                    $member->delete();
                }
            }
        });
    }
}
