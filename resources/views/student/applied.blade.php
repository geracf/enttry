@extends('layouts.app', ['active' => 'applied'])

@section('content')

    <div class="arena">
        <offer-list
            url="api/applied"
            :paginated="false"
            null_text="No has aplicado a ninguna oferta laboral!"
            title="Ofertas a las que has aplicado"></offer-list>
    </div>

@endsection
