<?php

namespace App\Http\Controllers\Api;

use App\ChatRoom;
use App\Http\Controllers\Controller;
use App\Message;
use App\Notifications\ChatAnswered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ChatController extends Controller
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

        if ($user->role_id == 3) {
            foreach ($user->chatRooms as $chatRoom) {
                $chatRoom->subject_avatar = $chatRoom->thumbnail();
                $chatRoom->subject_name = $chatRoom->subjectName();
                $chatRoom->last_message = $chatRoom->lastMessage();
                $chatRoom->active = false;
            }

            return $user->chatRooms;
        } else {
            $organization = $user->organization;
            $chat = collect();
            foreach ($organization->applications as $application) {
                $chatRoom = $application->chats;
                $chatRoom->subject_avatar = $chatRoom->thumbnail();
                $chatRoom->subject_name = $chatRoom->subjectName();
                $chatRoom->last_message = $chatRoom->lastMessage();
                $chatRoom->active = false;
                $chat->push($chatRoom);
            }

            return $chat;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'message' => 'required|string|max:255',
            'chat_id' => 'required|integer|exists:chat_rooms,id',
        ]);

        $user = Auth::user();
        $chat_room = ChatRoom::find($request->chat_id);

        if ($user->can('update', $chat_room)) {
            $message = new Message;

            $message->chat_room_id = $request->chat_id;
            $message->message = $request->message;

            $user->sentMessages()->save($message);

            if ($chat_room->user_id == $user->id) {
                $organization = $chat_room->application->offer->organization;
                Notification::send($organization->members, new ChatAnswered($user, $chat_room));
            }

            return ['success' => 'message recieved'];
        }
        // return response('Something happened', 403);
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
        $chatRoom = ChatRoom::findOrFail($id);

        if ($user->can('view', $chatRoom)) {
            foreach ($chatRoom->messages as $message) {
                $message->sent_by_me = $message->sentByMe($user->id);
            }

            return $chatRoom->messages->sortBy('id')->values();
        }
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
