@extends('layouts.app', ['active' => 'favorites'])

@section('content')

    <div class="arena">
        <offer-list
            url="api/favorite"
            :paginated="false"
            null_text="No has marcado ninguna oferta como favorita!"
            title="Ofertas favoritas"></offer-list>
    </div>

@endsection
