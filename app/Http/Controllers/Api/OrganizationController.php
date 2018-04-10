<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Offer;
use App\Organization;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function self()
    {
        $user = Auth::user();

        if ($user->organization) {
            $organization = $user->organization;

            $organization->unread_notifications = $user->unreadNotifications->sortBy('created_at')->take(3);
            $organization->thumbnail = $organization->thumbnail();
            $organization->desc = $organization->desc;

            return $organization;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->organization) {
            $offers = [
                'data' => $user->organization->offers->sortByDesc('created_at')->take(3),
                'params' => [
                    'can_add' => $user->can('create', Offer::class)
                ]
            ];

            foreach ($offers['data'] as $offer) {
                $offer->prepareJson($user);
                $offer->has_questions = $offer->hasQuestions();
            }

            return $offers;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $user->newSubscription('premium', 'premium')->create($stripeToken);

        return $user;

        // $user->subscribed();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $organization = Organization::findOrFail($id);

        if ($user->can('view', $organization)) {
            $organization->offers;
            $organization->pictures;

            return $organization;
        }

        return response('Not authorized', 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());

        $user = Auth::user();
        $organization = Organization::findOrFail($id);

        if ($user->can('update', $organization)) {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'desc' => 'nullable|string',
                'address' => 'nullable|string|max:255',
                'website' => 'nullable|url',
                'email' => 'nullable|email',
                'twitter' => 'nullable|url',
                'facebook' => 'nullable|url',
                'linkedin' => 'nullable|url'
            ]);

            $organization->update($request->all());

            $organization->offers;
            $organization->pictures;

            return $organization;
        }

        return response('Not authorized', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
