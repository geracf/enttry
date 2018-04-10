@extends('layouts.app', ['active' => 'home'])

@section('content')
    <div class="arena">
        <offer-list
            title="Ofertas abiertas"
            url="api/organization"
            action="{{ url('offer') }}"
            :is_student="false"
            :paginated="true"
            null_text="Agrega una oferta!"></jobs-offer-list>
    </div>
    <div class="arena">
        <company-dashboard
            title="{{ $organization->name }}"
            token="{{ csrf_token() }}"
            base_url="{{ url("/") }}"
            url="{{ url("organization/picture") }}"
            plan_action="{{ url("employers") }}#plans"></company-dashboard>
    </div>
@endsection