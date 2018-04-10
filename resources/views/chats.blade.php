@extends('layouts.app', ['active' => 'chats'])

@section('content')

<div class="arena--full-height">
    <div class="row">
        <div class="col-sm-6 no-padding">
            <chat-list></chat-list>
        </div>
        <div class="col-sm-6 no-padding">
            <chat-detail @chatClicked="getChat(this.chat_id)"></chat-detail>
        </div>
    </div>
</div>

@endsection
