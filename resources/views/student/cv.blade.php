@extends('layouts.app', ['active' => 'home'])

@section('content')

<div class="arena--untainted">
    <div class="row no-padding">
        <div class="col-xs-12">
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            <div class="row">

                <start-details
                    url="{{ url("user/picture") }}"
                    token="{{ csrf_token() }}"></start-details>

                <start-featured></start-featured>

            </div>

            <div class="row">

                <start-work></start-work>

                <start-education></start-education>

                <start-social></start-social>

            </div>

        </div>
    </div>
</div>
@endsection
