@extends('layouts.app', ['active' => 'home'])

@section('content')

    @if (Auth::user()->isStudent())
        @include('dashboard.students')
    @else
        @include('dashboard.company')
    @endif

@endsection

