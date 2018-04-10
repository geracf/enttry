@extends('layouts.new_landing', ['location' => 'employers'])

@section('content')

    <section role="page">
        <div class="container">
            <div class="Cgreeting">
                <div class="greeting-blue">
                    <div class="greeting-content">
                        <h1 class="greeting-title">Encuentra y contrata el mejor futuro posible</h1>
                        <h2 class="greeting-title2">Descubre, conecta y recluta los mejores estudiantes y recién egresados</h2><br>
                        <a href="#"><h3 class="begin">Comenzar</h3></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section role="page">
        <div class="Cdescription P2">
            <div class="row content">
                <div class="col-lg-6 Cmac">
                    <img src="img/phone.png" alt="">
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <h1 class="Cdescription-title">Redefine la manera de encontrar talento</h1>
                    <h3 class="Cdescription-text">
                        Encuentra fácilmente a los mejores candidatos para tu compañia usando la mejor herramienta
                    </h3>
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

    <div class="logAccount">
      <div class="accountContainer">

          <i class="fa fa-times falog" aria-hidden="true"></i>

          <h1 class="create-title">Ingresa</h1>
          <br>
            <form method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <input class="create" type="text" name="email" value="" placeholder="Tu email">
                <input class="create" type="password" name="password" value="" placeholder="Ingresa una contraseña">
                <br>
                <button class="register nav-link createL" href="#">Ingresa</button>
                <hr>
            </form>
          {{-- <a class="register nav-link facebook" href="{{ url('login-social/facebook') }}">Ingresa con Facebok</a> --}}

      </div>
    </div>

    <div class="createAccount">
        <form method="post" action="{{ url('new-organization') }}">
            {{ csrf_field() }}
            <div class="accountContainer aC1">
                <i class="fa fa-times" aria-hidden="true"></i>
                <h1 class="create-title">Publica una vacante</h1>
                <br>
                <input class="create" type="text" name="user_name" placeholder="Tu nombre completo">
                <input class="create" type="text" name="email" placeholder="Tu email">
                <input class="create" type="password" name="password" placeholder="Ingresa una contraseña">
                <input class="create" type="password" name="password_confirmation" placeholder="Confirma tu contraseña">
                <input class="create" type="text" name="company_name" placeholder="Nombre de la compañia">
                {{-- <input class="create" type="text" name="company_size" placeholder="Tamaño de la compañia"> --}}


                <select class="create" name="company_size" required>
                    <option value="">Tamaño de la compañía</option>
                    <option value="1 - 10">1 ~ 10</option>
                    <option value="10 - 100">10 ~ 100</option>
                    <option value="100 - 1000">100 ~ 1,000</option>
                    <option value="1000 - 10000">1,000 ~ 10,000</option>
                </select>
                <hr>
                <a class="register nav-link createL cont" href="#">Continuar</a>
            </div>
            <div class="accountContainer aC2">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                <i class="fa fa-times" aria-hidden="true"></i>
                <h1 class="create-title">Publica una vacante</h1>
                <br>
                <input class="create" type="text" name="phone" placeholder="Telefono de contacto">
                <input class="create" type="text" name="address" placeholder="Dirección">
                <input class="create" type="text" name="website" placeholder="Página Web">
                <textarea class="create area" name="desc" placeholder="Descripción"></textarea>
                <hr>
                <button class="register nav-link createL" href="#">Continuar</button>
            </div>
        </form>
    </div>

@endsection
