@extends('layouts.new_landing', ['location' => 'student'])

@section('content')

    <section role="page">
        <div class="container">
            <div class="greeting">
                <div class="greeting-content">
                    <h1 class="greeting-title">Únete a los demás Estudiantes y Recien Egresados</h1>
                    <h2 class="greeting-title2">Encuentra Trabajo o Prácticas Profesionales</h2><br>
                    <a href="#"><h3 class="begin">Comenzar</h3></a>
                </div>
            </div>
        </div>
    </section>

    <section role="page">
        <div class="description-background">
            <div class="description">
                <div class="circle"></div>
                <div class="row content">
                    <div class="col-lg-4 offset-lg-1">
                        <h1 class="description-title">Encuentra y Se Encontrado</h1>
                        <h3 class="description-text" style="margin-top: 60px;">
                            El mundo es más que solo experiencia laboral.
                            Crea tu perfil
                            y se encontrado por
                            las mejores compañias
                            al mismo tiempo
                            que encuentras la mejor
                            compañia para ti
                        </h3>
                    </div>
                    <div class="col-lg-6 offset-lg-1 mac"><img style="margin-bottom: 60px;" src="img/mac.png" alt=""></div>
                </div>
            </div>
        </div>
    </section>

    <section role="page">
        <div class="company content">
            <h1 class="company-title">Las Mejores compañias están aqui</h1>

            <div class="container companies">
                <div class="row">
                    <div class="col-md-4">
                        <img style="width: 70%; display: block; margin: auto;" class="img" src="/img/slider/spectal.png" alt="Spectal" title="Spectal">
                    </div>
                    <div class="col-md-4">
                        <img style="width: 70%; display: block; margin: auto;" class="img" src="/img/slider/blooders.png" alt="Blooders" title="Blooders">
                    </div>
                    <div class="col-md-4">
                        <img style="width: 70%; display: block; margin: auto;" class="img" src="/img/slider/yellowdress.png" alt="Yellow Dress" title="Yellow Dress">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <img style="width: 70%; display: block; margin: auto;" class="img" src="/img/slider/recrew.png" alt="Recrew" title="Recrew">
                    </div>
                    <div class="col-md-4">
                        <img style="width: 70%; display: block; margin: auto;" class="img" src="/img/slider/scannen.png" alt="Scannen" title="Scannen">
                    </div>
                    <div class="col-md-4">
                        <img style="width: 70%; display: block; margin: auto;" class="img" src="/img/slider/startupstudio.png" alt="Startup Studio" title="Startup Studio">
                    </div>
                </div>
            </div>
      </div>
      {{-- <div class="footer"></div> --}}
    </section>

@endsection

@section('modals')

    <div class="createAccount">
        <div class="accountContainer">

        <i class="fa fa-times" aria-hidden="true"></i>
            <h1 class="create-title">Crea una Cuenta</h1>
            <br>

            <form id="registerForm" action="{{ url('new_user') }}" method="post">
                {{ csrf_field() }}
                <input class="create" type="text" name="name" placeholder="Tu nombre completo">
                <input class="create" type="text" name="email" placeholder="Tu email">
                <input class="create" type="password" name="password" placeholder="Ingresa una contraseña">
                <input class="create" type="password" name="password_confirmation" placeholder="Confirma tu contraseña">
                <br>
                <a class="register nav-link createL" href="#"
                    onclick="document.getElementById('registerForm').submit()">Registrate</a>
                <hr>
            </form>
            <a href="{{ url('login-social/facebook') }}" class="register nav-link facebook">Registrate con Facebook</a>

        </div>
    </div>

    <div class="logAccount">
        <div class="accountContainer">

            <i class="fa fa-times falog" aria-hidden="true"></i>
            <h1 class="create-title">Ingresa</h1>
            <br>

            <form id="loginForm" method="post" action="{{ url('login') }}">
                {{ csrf_field() }}
                <input class="create" type="text" name="email" placeholder="Tu email">
                <input class="create" type="password" name="password" placeholder="Ingresa una contraseña">
            </form>

            <br>
            <a class="register nav-link createL" href="#"
                onclick="event.preventDefault();
                document.getElementById('loginForm').submit();">Ingresa</a>
            <hr>
            <a href="{{ url('login-social/facebook') }}" class="register nav-link facebook">Ingresa con Facebook</a>

      </div>
    </div>

@endsection