<?php

namespace App;

use App\Question;
use App\Requirement;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Offer extends Model
{
    protected $hidden = [
        'updated_at', 'show_location',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function applications()
    {
        return $this->hasMany(Student\Application::class);
    }

    public function favorites()
    {
        return $this->hasMany(Student\Favorite::class);
    }

    public function pictures()
    {
        return $this->morphMany(Picture::class, 'pictureable');
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function hasQuestions()
    {
        if ($this->questions != null) {
            return true;
        }
        return false;
    }

    public function prepareJson(User $user)
    {
        $this->url = url("offer/$this->id");
        $this->img_url = $this->thumbnail();
        $this->company_name = $this->organization->name;
        $this->favorited = $this->favorites->contains('user_id', $user->id);
        $this->favorite_id = $this->favorited ? $this->favorites->where('user_id', $user->id)[0]->id : null;
        $this->can_favorite = $user->can('favorite', $this);
        $this->can_apply = $user->can('apply', $this);
        $this->name = str_limit($this->name, 40, '...');
        $this->desc = str_limit($this->desc, 100, '...');
    }

    public function searchResultView(User $user)
    {
        return [
            'url' => url("offer/$this->id"),
            'img_url' => $this->thumbnail(),
            'company_name' => $this->organization->name,
            'can_favorite' => $user->can('favorite', $this),
            'can_apply' => $user->can('apply', $this),
            'name' => str_limit($this->name, 20, '...'),
            'desc' => str_limit($this->desc, 40, '...'),
        ];
    }

    public function thumbnail()
    {
        if ($this->pictures->count() > 0) {
            if (Storage::exists($this->pictures[0]->path)) {
                return Storage::url($this->pictures[0]->path);
            }
        }
        return Storage::url('dummy/thumbnail.png');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Offer $offer) {
            if ($offer->applications) {
                $offer->applications()->delete();
            }
            if ($offer->pictures) {
                $offer->pictures()->delete();
            }
            if ($offer->requirements) {
                $offer->requirements()->delete();
            }
            if ($offer->questions) {
                $offer->questions()->delete();
            }
        });
    }
}
