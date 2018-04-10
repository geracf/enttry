@extends('layouts.landing')

@section('content')

    <div class="gray" style="min-height: calc(100vh - 310px);">
        <div class="container">
            <div class="row">
                <div class="col s4">
                    <div class="card" style="padding: 5px 15px; margin-top: 20px;">
                        <h3>Ventajas</h3>
                    </div>
                </div>
                <div class="col s8">

                    <div class="card" style="padding: 5px 15px 20px 15px; margin-top: 20px;">

                        <h3>¡Aquí encontraras a los mejores!</h3>
                        <br>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ url("payment") }}" method="POST">
                            {{ csrf_field() }}

                            <input type="hidden" name="plan" value="{{ $plan }}">
                            <div class="row">
                                <div class="col s6">
                                    <div class="input-field">
                                        <label>Nombre de tu organización</label>
                                        <input type="text" name="name" placeholder="Este nombre será visible para los estudiantes" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="input-field">
                                        <label>Correo electrónico de contacto</label>
                                        <input type="email" name="email" placeholder="Usado para enviar notificaciones e iniciar sesión" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s6">
                                    <div class="input-field">
                                        <label>Contraseña</label>
                                        <input type="password" name="password" placeholder="Más de 6 caracteres">
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="input-field">
                                        <label>Confirmar contraseña</label>
                                        <input type="password" name="password_confirmation" placeholder="Confirma tu contraseña">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s6">
                                    <div class="input-field">
                                        <select name="size">
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="1-10">De 1 a 10</option>
                                            <option value="10-100">De 10 a 100</option>
                                            <option value="100-500">De 100 a 500</option>
                                            <option value="500+">Más de 500</option>
                                        </select>
                                        <label>Número de empleados</label>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="input-field">
                                        <label>Teléfono</label>
                                        <input type="text" name="address" placeholder="Teléfono de contacto" value="{{ old('address') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s6">
                                    <div class="input-field">
                                        <label>Nombre del contacto principal</label>
                                        <input type="text" name="contact_name" placeholder="Tu nombre" value="{{ old('contact_name') }}">
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="input-field">
                                        <label>Dirección</label>
                                        <input type="text" name="address" placeholder="Your organizations' address" value="{{ old('address') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col s12">
                                    <div class="input-field">
                                        <label>Página web</label>
                                        <input type="url" name="website" placeholder="Your organizations' website" value="{{ old('website') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Descripción</label>
                                <textarea class="materialize-textarea" style="height: 100px;" placeholder="Describe your organization" name="desc">{{ old('desc') }}</textarea>
                            </div>

                            <script
                                src="https://checkout.stripe.com/checkout.js"
                                class="stripe-button"
                                data-key="{{ env('STRIPE_KEY') }}"
                                data-amount="{{ $amount }}"
                                data-name="{{ $name }}"
                                data-description="{{ $desc }}"
                                data-image="{{ $img }}"
                                data-locale="auto">
                            </script>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select').material_select();
        });
    </script>
@endsection