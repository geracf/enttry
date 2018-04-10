<?php

namespace App\Http\Controllers\Api;

use App\ChatRoom;
use App\Http\Controllers\Controller;
use App\Notifications\StudentApplied;
use App\Offer;
use App\Student\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AppliedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $offers = collect();

        $offers = [
            'data' => $user->getAppliedOffers(),
            'params' => [
                'can_add' => $user->can('create', Offer::class)
            ]
        ];
        return $offers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'offer_id' => 'required|integer|exists:offers,id'
        ]);

        $user = Auth::user();
        $offer = Offer::find($request->offer_id);

        if ($user->can('apply', $offer)) {
            $application = new Application;
            $application->offer_id = $request->offer_id;

            $user->appliedOffers()->save($application);

            $chat_room = new ChatRoom;
            $chat_room->application_id = $application->id;

            $user->chatRooms()->save($chat_room);

            Notification::send($offer->organization->members, new StudentApplied($user, $offer));

            return ['success' => 'Applied to offer'];
        }

        return response('You cant aply to this offer', 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
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
