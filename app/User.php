<?php

namespace App;

use App\FacebookAccount;
use App\Major;
use App\Student\University;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, Billable;
    protected $dates = ['graduated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'email', 'name', 'password', 'active'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'stripe_id', 'card_brand',
        'card_last_four', 'trial_ends_at', 'created_at', 'updated_at',
    ];

    // General relationships

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function picture()
    {
        return $this->morphOne(Picture::class, 'pictureable');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function chatRooms()
    {
        return $this->hasMany(ChatRoom::class);
    }


    // Relationships for the students

    public function appliedOffers()
    {
        return $this->hasMany(Student\Application::class);
    }

    public function workExperience()
    {
        return $this->hasMany(Student\WorkExperience::class);
    }

    public function featuredWork()
    {
        return $this->hasMany(Student\FeaturedWork::class);
    }

    public function education()
    {
        return $this->hasMany(Student\Education::class);
    }

    public function favorites()
    {
        return $this->hasMany(Student\Favorite::class);
    }

    public function documents()
    {
        return $this->morphMany(Student\Document::class, 'documentable');
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    // public function facebookAccount()
    // {
    //     return $this->hasOne(FacebookAccount::class);
    // }

    // Methods
    public function isStudent()
    {
        return $this->role->id == 3 ? true : false;
    }

    public function sections()
    {
        $sections = [];
        return $sections;
    }

    public function getFavoriteOffers()
    {
        $offers = collect();
        foreach ($this->favorites as $favorite) {
            $offer = $favorite->offer;

            $offer->prepareJson($this);
            $offer->has_questions = $offer->hasQuestions();

            $offers->push($offer);
        }

        return $offers;
    }

    public function getAppliedOffers()
    {
        $offers = collect();
        foreach ($this->appliedOffers as $applied) {
            $offer = $applied->offer;

            $offer->prepareJson($this);
            $offer->has_questions = $offer->hasQuestions();

            $offers->push($offer);
        }

        return $offers;
    }

    public function studentType()
    {
        $text = '';
        if ($this->student_type == null) {
            $text = null;
        } elseif ($this->student_type == 'full-time') {
            $text = 'Tiempo completo';
        } elseif ($this->student_type == 'part-time') {
            $text = 'Medio tiempo';
        } elseif ($this->student_type == 'graduate') {
            $text = 'Ya me gradué';
        }

        return ['value' => $this->student_type, 'text' => $text];
    }

    public function socialNetworks()
    {
        $email = [
            'active' => true,
            'icon' => 'fa-at',
            'network' => 'Email',
            'address' => $this->email
        ];
        $linkedin = [
            'active' => $this->linkedin ? true : false,
            'icon' => 'fa-linkedin',
            'network' => 'LinkedIn',
            'address' => $this->linkedin
        ];
        $facebook = [
            'active' => $this->facebook ? true : false,
            'icon' => 'fa-facebook',
            'network' => 'Facebook',
            'address' => $this->facebook
        ];
        $twitter = [
            'active' => $this->twitter ? true : false,
            'icon' => 'fa-twitter',
            'network' => 'Twitter',
            'address' => $this->twitter
        ];
        $instagram = [
            'active' => $this->instagram ? true : false,
            'icon' => 'fa-instagram',
            'network' => 'Instagram',
            'address' => $this->instagram
        ];
        $spotify = [
            'active' => $this->spotify ? true : false,
            'icon' => 'fa-spotify',
            'network' => 'Spotify',
            'address' => $this->spotify
        ];

        $socials = [
            'email' => $email,
            'linkedin' => $linkedin,
            'facebook' => $facebook,
            'twitter' => $twitter,
            'instagram' => $instagram,
            'spotify' => $spotify
        ];

        return $socials;
    }

    public function avatar()
    {
        return $this->picture ? Storage::url($this->picture->path) : Storage::url('dummy/placeholder.png');
    }

    public function full()
    {
        $this->makeVisible($this->hidden);
    }

    public function searchResultView()
    {
        return [
            'url' => url("student/$this->id"),
            'avatar' => $this->avatar(),
            'name' => $this->name,
            'foi' => str_limit($this->foi, 30),
            'university' => $this->university ?: '',
            'major' => $this->major ?: '',
        ];
    }
}
