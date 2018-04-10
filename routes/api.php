<?php

use App\Student\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('message', 'Api\MessageController');

// Shared
Route::resource('chats', 'Api\ChatController');

// Organizations
Route::get('organization/self', 'Api\OrganizationController@self');
Route::resource('organization', 'Api\OrganizationController');
Route::resource('offer/{offer_id}/application', 'Api\ApplicationController');
Route::post('offer/search', 'Api\OfferController@search');
Route::resource('offer', 'Api\OfferController');
Route::resource('user', 'Api\UserController');
Route::post('user/search', 'Api\UserController@search');
Route::resource('university', 'Api\UniversityController');

// Student
Route::resource('experience', 'Api\WorkExperienceController');
Route::resource('featured', 'Api\FeaturedWorkController');
Route::resource('applied', 'Api\AppliedController');
Route::resource('education', 'Api\EducationController');
Route::resource('document', 'Api\DocumentController');
Route::resource('favorite', 'Api\FavoriteController');
Route::post('user/details', 'Api\UserController@setStudentDetails');
Route::get('socials', 'Api\UserController@getSocialMedia');
Route::post('socials', 'Api\UserController@setSocialMedia');

// Skills
Route::resource('skills', 'Api\SkillController');

// Payment
Route::post('payment', 'Api\PaymentMethod@store');
Route::get('plans', 'Api\PaymentMethod@plans');

// Validation
Route::get('can-apply', function () {
    $user = Auth::user();
    return $user->can('create', Application::class);
});
