@extends('layouts.app', ['active' => 'my_offers'])

@section('content')

    <div class="arena">
        <div class="my_offers--container">

            <h3>
                Chat con {{ $application->student->name }} <br>
                <span class="small">Sobre {{ $offer->name }}</span>
            </h3>

            <single-chat
                :id="{{ $application->chats->id }}"></single-chat>

        </div>
    </div>

@endsection