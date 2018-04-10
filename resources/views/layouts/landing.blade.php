@php
    if (!isset($location)) {
        $location = 'employers';
    }
@endphp
<!DOCTYPE html>
<html>
    <head>
    <meta author="JobsHere">
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="/img/favicon.ico">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ env('APP_NAME') }}">

        <title>{{ env('APP_NAME') }}</title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />

        {{-- Styles & Fonts --}}
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/landing.css">

        {{-- JS --}}
        <script type="text/javascript" src="/js/landing.js"></script>

    </head>
    <body>

        {{-- <nav>
            <div class="nav-wrapper">
                <a href="{{ url('/') }}" class="brand-logo">
                    <img src="/img/long_logo.png" alt="JobsHere" title="JobsHere">
                </a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    @if ($location == 'employers')
                        <li>
                            <a href="{{ url('/') }}" class="btn btn-link">Alumnos</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ url('employers') }}" class="btn btn-link">Empleadores</a>
                        </li>
                    @endif
                    <li class="nav-item na">
                        <a class="log nav-link" href="#" class="btn btn-link">Iniciar sesión</a></li>
                    <li>
                        <a href="{{ url('register') }}" class="btn btn-link">Regístrate</a>
                    </li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    @if ($location == 'employers')
                    <li><a href="{{ url('/') }}">Alumnos</a></li>
                    @else
                    <li><a href="{{ url('employers') }}">Empleadores</a></li>
                    @endif
                    <li><a href="{{ url('login') }}">Iniciar sesión</a></li>
                    <li><a href="{{ url('register') }}">Regístrate</a></li>
                </ul>
            </div>
        </nav> --}}

        @yield('content')

        <footer class="page-footer grey darken-3 clearfix">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <a href="{{ url('/') }}" class="brand-logo">
                            <img src="/img/long_logo.png" alt="JobsHere" title="JobsHere" class="brand-logo responsive-img">
                        </a>
                    </div>
                    <div class="col s12 m4">
                        <p class="strong">JobsHere</p>
                        <ul>
                            <li><a href="#">Contáctanos</a></li>
                            <li><a href="#">Trabajar con nosotros</a></li>
                            <li><a href="#">Quejas y sugerencias</a></li>
                        </ul>
                    </div>
                    <div class="col s12 m4">
                        <p class="strong">Ingresa</p>
                        <ul>
                            <li><a href="{{ url('login') }}">Iniciar sesión</a></li>
                            <li><a href="{{ url('register') }}">Regístrate</a></li>
                            <li><a href="#">Inicia sesión con Facebook</a></li>
                        </ul>
                    </div>
                    <div class="col s12 m4">
                        <p class="strong">Legal</p>
                        <ul>
                            <li><a href="#">Política de privacidad</a></li>
                            <li><a href="#">Uso de datos personales</a></li>
                            <li><a href="#">Cookies y sesiones</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p class="pull-right">© 2017 JobsHere</p>
                    </div>
                </div>
            </div>

        </footer>

        @yield('modals')

    </body>
    @yield('scripts')
</html>
