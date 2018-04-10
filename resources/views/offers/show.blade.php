@extends('layouts.app', ['active' => 'discover'])

@section('content')

<div class="arena--untainted">

    <div class="row">
        <div class="col-xs-12 col-sm-6">

            <offer-socials
                left_bubble="fa-facebook"
                left_bubble_url="{{ $offer->organization->facebook }}"
                center_bubble="{{ $offer->thumbnail() }}"
                center_bubble_url=""
                right_bubble="fa-twitter"
                right_bubble_url="{{ $offer->organization->twitter }}"
                company_name="{{ $offer->organization->name }}"></offer-socials>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <h3>Vista general</h3>

                <div class="col-xs-12 card offer__overview">

                    <div class="row offer__header">
                        <div class="col-xs-6">
                            <h3>{{ $offer->name }}</h3>
                        </div>
                        <div class="col-xs-6">
                            <p>
                                {{ $offer->looking_for }}
                                <i class="fa fa-star"></i>
                            </p>
                        </div>
                    </div>

                    <div class="row offer__description">
                        <p>{{ $offer->desc }}</p>
                    </div>

                    <hr>

                    <div class="row offer__description">
                        <div class="col-xs-6 offer__section-title">
                            <h3>Salario</h3>
                        </div>
                        <div class="col-xs-6 offer__info">
                            <p>{{ $offer->salary }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row offer__description">
                        <div class="col-xs-6 offer__section-title">
                            <h3>Dirección</h3>
                        </div>
                        <div class="col-xs-6 offer__info">
                            <p>{{ $offer->location ?: 'None provided' }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row offer__description">
                        <div class="col-xs-12 offer__section-title">
                            <h3>Requerimientos</h3>
                        </div>
                        <div class="col-xs-12 offer__info">
                            @if ($offer->requirements->count() > 0)
                                @foreach($offer->requirements as $requirement)
                                    <li class="{{ $requirement->mandatory ? 'text-danger' : '' }}">{{ $requirement->text }}</li>
                                @endforeach
                            @else
                                <p>No hay requerimientos especiales</p>
                            @endif
                        </div>
                    </div>
                    {{-- {{ dd(Auth::user()->role_id == 3 && !$offer->can_apply, Auth::user()->role_id, $offer->can_apply) }} --}}

                    @if (Auth::user()->role_id == 3 && Auth::user()->can('apply', $offer))
                    <div class="row offer__actions">
                        <button id="applyToOffer" class="btn btn-primary">Aplica ahora</button>
                    </div>
                    @elseif (Auth::user()->role_id == 3 && !$offer->can_apply)
                        <div class="row offer__actions">
                            <button class="btn btn-warning">Ya aplicaste a esta oferta</button>
                        </div>
                    @else
                        <div class="row offer__actions">
                            <button id="openOfferModal" class="btn btn-danger">Acciones</button>
                        </div>
                    @endif

                </div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-6">

            <div class="row">
                <h3>Preguntas</h3>

                <div class="col-xs-12 card">

                    <form id="applyForm" method="post" action="{{ url("offer/$offer->id") }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Telephone</label>
                            <input class="form-control" type="text" name="phone" placeholder="Escribe tu teléfono">
                        </div>

                        @if ($offer->questions->count() > 0)
                            @foreach($offer->questions as $i => $question)
                                <div class="form-group">
                                    <label>{{ $question->text }}</label>
                                    <input class="form-control" type="text" name="answers[{{ $question->id }}]" placeholder="Escribe tu respuesta" required>
                                </div>
                            @endforeach
                        @endif

                    </form>

                </div>
            </div>

            <div class="row map__container">
                <div id="map"></div>
            </div>

        </div>
    </div>

    <offer-modal
        action="{{ url("offer/$offer->id") }}"
        method="put"
        token="{{ csrf_token() }}"
        :id="{{ $offer->id }}"
        :is_student="{{ Auth::user()->role_id == 3 ? 'true' : 'false' }}"></offer-modal>

</div>

@endsection

@section('scripts')
    @if ($offer->show_location)
        <script type="text/javascript">
            map = new GMaps({
                div: '#map',
                lat: {{ $offer->lat ?: '12' }},
                lng: {{ $offer->lng ?: '12' }}
            });

            map.addMarker({
                lat: {{ $offer->lat ?: '12' }},
                lng: {{ $offer->lng ?: '12' }},
                title: '{{ $offer->name }}',
            });
        </script>
    @endif
    <script type="text/javascript">
        $('#applyToOffer').click(function (e) {
            document.getElementById('applyForm').submit();
        });

        $('#openOfferModal').click(function (e) {
            $('#addOffer').modal('show');
        });
    </script>
@endsection