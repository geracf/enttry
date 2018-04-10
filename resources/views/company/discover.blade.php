@extends('layouts.app', ['active' => 'discover'])

@section('content')

<div class="arena">
    <div class="row">
        <div class="title">
            <h1>Discover</h1>
        </div>
        <discover-form></discover-form>
    </div>
</div>

@endsection
