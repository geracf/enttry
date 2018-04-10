@extends('layouts.landing')

@section('content')
<div class="container-fluid gray">
    <div class="row">

        <div id="sign-in" class="col-md-4 col-md-offset-4 sign-in">
            <div class="card">
                <div class="card-content">
                    <h4 class="blue-title">Regístrate</h4>

                    <form class="form-horizontal" method="POST" action="{{ url('new_user') }}">

                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control input button-grey" name="name" value="{{ old('name') }}" placeholder="Nombre" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>


                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control input button-grey" name="email" value="{{ old('email') }}" placeholder="Email" required>

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

                        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="password_confirmation" type="password" class="form-control input button-grey" name="password_confirmation" placeholder="Confirma tu contraseña" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-md-12">
                                <button class="btn btn-lg btn-block btn-login">Regístrate</button>
                            </div>

                        </div>

                    </form>

                    <hr>

                    <a class="btn btn-lg btn-block btn-fb" href="{{ url('signup') }}">
                        <i class="fa fa-facebook pull-left"></i>
                        Inicia sesión con Facebook
                    </a>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection
