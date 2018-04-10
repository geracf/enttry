@extends('layouts.app', ['active' => 'my_offers'])

@section('content')

    <div class="arena">

        <h3 style="margin-left: 15px;">Editar {{ $offer->name }}</h3>
        <div class="my_offers--container__form">

            <form action="{{ url("my-offers/$offer->id") }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label>Nombre de la oferta</label>
                    <input class="form-control" type="text" name="name" value="{{ $offer->name }}">
                </div>

                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>Categoría</label>
                            <input class="form-control" type="text" name="category" placeholder="IT, Investigación, RH?">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>Tipo de trabajo</label>
                            <select name="type" class="form-control">
                                <option value="full-time">Tiempo completo</option>
                                <option value="internship">Prácticas profecionales</option>
                                <option value="part-time">Medio tiempo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>Aplicante deseado</label>
                            <select name="looking_for" class="form-control">
                                <option value="student">Estudiante</option>
                                <option value="graduate">Graduado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Salario ofertado</label>
                            <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input type="text" class="form-control" id="exampleInputAmount" name="salary" placeholder="Cantidad en MXN">
                                <div class="input-group-addon">.00 MXN/Mes</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Localización</label>
                            <input class="form-control" type="text" name="location" placeholder="¿Dónde van a trabajar?">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <input type="hidden" name="lat" id="formLat">
                        <input type="hidden" name="lng" id="formLng">
                        <div id="map"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="show_location" value="0">
                                    <input type="checkbox" name="show_location" checked="checked" value="1"> Mostrar localización en mapa
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="remote" value="0">
                                    <input type="checkbox" name="remote" value="1"> Puede ser trabajado remoto
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Descripción laboral</label>
                            <textarea class="form-control" name="desc" placeholder="¿Que puede esperar el aplicate del trabajo?"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Imágenes <span class="small">Las nuevas imágenes sobreescribirán a las anteriores</span></label>
                            <input class="form-control" type="file" name="pictures[]" multiple>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <h3 style="margin-left: 15px;">Opcionales</h3>

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Pregunta 1</label>
                            <input class="form-control" type="text" name="question[]" placeholder="¿Dónde escuchaste de nuestra empresa?">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Pregunta 2</label>
                            <input class="form-control" type="text" name="question[]" placeholder="¿Que experiencia tienes en el campo?">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Pregunta 3</label>
                            <input class="form-control" type="text" name="question[]" placeholder="¿Cuáles son tus hobbies?">
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">

        var lat = -12.123123;
        var lng = -12.123123;

        var map = new GMaps({
            div: '#map',
            lat: lat,
            lng: lng,
        });

        GMaps.geolocate({
          success: function(position) {
            lat = position.coords.latitude;
            lng = position.coords.longitude;

            $('#formLat').val(lat)
            $('#formLng').val(lng)

            map.setCenter(lat, lng);
            map.addMarker({
                lat: lat,
                lng: lng,
                draggable: true,
                dragend: function (e) {
                    lat = e.latLng.lat();
                    lng = e.latLng.lng();
                    $('#formLat').val(lat);
                    $('#formLng').val(lng);
                }
            });
          },
          error: function(error) {
            alert('Geolocation failed: '+error.message);
          },
          not_supported: function() {
            alert("Your browser does not support geolocation");
          }
        })

    </script>

@endsection