<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('confirm/{confirm_id}', 'Web\UserController@confirm');

Route::get('/', 'Web\LandingController@students');
Route::get('/employers', 'Web\LandingController@companies');
Route::get('plans/{plan_name}', 'Web\LandingController@plans');

Route::post('payment', 'Web\PaymentController@pay');

Route::get('start', 'Web\StartController@index');
Route::get('discover', 'Web\DiscoverController@discover');
Route::get('favorites', 'Web\FavoriteController@index');
Route::get('applied', 'Web\AppliedController@index');
Route::get('chats', 'Web\ChatController@index');
Route::get('curriculum', 'Web\CurriculumController@index');

Route::post('offer', 'Web\OfferController@store');
Route::get('offer/{offer_id}', 'Web\OfferController@show');
Route::post('offer/{offer_id}', 'Web\OfferController@apply');
Route::put('offer/{offer_id}', 'Web\OfferController@update');

Route::get('my-offers', 'Web\MyOfferController@index');
Route::get('my-offers/{offer_id}', 'Web\MyOfferController@show');
Route::get('my-offers/{offer_id}/edit', 'Web\MyOfferController@edit');
Route::put('my-offers/{offer_id}', 'Web\MyOfferController@update');
Route::delete('my-offers/{offer_id}', 'Web\MyOfferController@destroy');
Route::get('my-offers/{offer_id}/chat', 'Web\MyOfferController@chat');

Route::post('organization/picture', 'Web\OrganizationController@pictureUpload');
Route::post('organization/{$organization_id}', 'Web\OrganizationController@update');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');

Route::post('user/picture', 'Web\UserController@pictureUpload');
Route::post('new_user', 'Web\UserController@register');

Route::get('student/{student_id}', 'Web\StudentController@show');
Route::post('student/{student_id}', 'Web\StudentController@discover');

Route::get('login-social/facebook/callback', 'Web\StudentController@callback');
Route::get('login-social/facebook', 'Web\StudentController@socialLogin');

Route::put('application/{application_id}', 'Web\ApplicationController@update');

Auth::routes();

Route::post('new-organization', 'Web\OrganizationController@store');
Route::get('organization/{organization_id}/confirm', 'Web\OrganizationController@confirm');
