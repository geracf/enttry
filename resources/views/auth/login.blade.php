@extends('layouts.landing')

@section('content')
@if (session('success'))
    <div class="card-panel teal lighten-2">
        <p style="margin-left: 30px;"><strong>Perfecto!</strong> {{ session('success') }}</p>
    </div>
@endif
<div class="container-fluid gray">

    <div class="row">

        <div id="sign-in" class="col s12 m6 offset-m3 sign-in">
            <div class="card">
                <div class="card-content">
                    <h4 class="blue-title">Iniciar sesión</h4>

                    @if (session('success'))
                        <div style="margin: 10px 0;" class="green darken-2">
                            <p style="color: white; padding: 8px;">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div style="margin: 10px 0;" class="red darken-2">
                            <p style="color: white; padding: 8px;">{{ session('error') }}</p>
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">

                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control input button-grey" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control input button-grey" name="password" placeholder="Contraseña" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div>
                            <button style="width: 100%;" class="btn btn-lg btn-block btn-login">Iniciar sesión</button>
                        </div>

                    </form>

                    <hr>

                    <a class="btn btn-lg btn-block btn-login" href="{{ url('register') }}">Regístrate</a>

                    <div class="or"></div>

                    <a class="btn btn-lg btn-block btn-fb" href="{{ url('login-social/facebook') }}">
                        <i class="fa fa-facebook pull-left"></i>
                        Inicia sesión con Facebook
                    </a>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection
