<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Organization' => 'App\Policies\OrganizationPolicy',
        'App\Offer' => 'App\Policies\OfferPolicy',
        'App\Message' => 'App\Policies\MessagePolicy',
        'App\ChatRoom' => 'App\Policies\ChatRoomPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Skill' => 'App\Policies\SkillPolicy',
        'App\Student\WorkExperience' => 'App\Policies\WorkExperiencePolicy',
        'App\Student\Application' => 'App\Policies\ApplicationPolicy',
        'App\Student\FeaturedWork' => 'App\Policies\FeaturedWorkPolicy',
        'App\Student\Education' => 'App\Policies\EducationPolicy',
        'App\Student\Favorite' => 'App\Policies\FavoritePolicy',
        'App\Student\Document' => 'App\Policies\DocumentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
