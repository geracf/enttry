<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Message;
use App\ChatRoom;

class MessageController extends Controller
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

        $rooms = $user->chat_rooms;
        if ($rooms->count() > 0) {
            foreach ($rooms as $room) {
                $room->student;
                $room->offer;
            }
        }

        return $rooms;
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

        if ($user->can('create', Message::class)) {
            $this->validate($request, [
                '' => '',
            ]);
        }

        return response('Nor authorized', 403);
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
        $room = ChatRoom::findOrFail($id);

        if ($user->can('view', $room)) {
            $room->offer;
            $room->student;
            $room->messages;

            return $room;
        }
        
        return response('Nor authorized', 403);
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
        foreach ($variable as $key => $value) {
            # code...
        }
    }
}
