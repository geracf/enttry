@if ($active == 'NO_NAVBAR')

@else
<nav class="navbar navbar-default visible-xs">
    <div class="container-fluid">
        <div class="navbar-header">
            <button @click="menuHidden = !menuHidden" type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </div>
</nav>

<div class="dimmer" @click="menuHidden = !menuHidden" :class="{ 'hidden' : menuHidden }"></div>
<div class="side-menu" :class="{ 'hidden-xs' : menuHidden }">
    <div class="logo">
        <a href="{{ url("/home") }}">
            <img src="/img/logo.png" alt="JobsHere" title="JobsHere" class="circle img-responsive logo slide-menu__logo">
        </a>
    </div>
    {{-- {{ $active }} --}}
    <div class="slide-menu__item {{ $active == 'home' ? 'active' : '' }}">
        <a href="{{ url('/home') }}">
            <i class="fa fa-home fa-3x"></i>
            <p>Inicio</p>
        </a>
    </div>
    <div class="slide-menu__item {{ $active == 'discover' ? 'active' : '' }}">
        <a href="{{ url('/discover') }}">
            <i class="fa fa-search fa-3x"></i>
            <p>Descubre</p>
        </a>
    </div>
    @if (Auth::user()->isStudent())
    <div class="slide-menu__item {{ $active == 'favorites' ? 'active' : '' }}">
        <a href="{{ url('/favorites') }}">
            <i class="fa fa-star fa-3x"></i>
            <p>Favoritos</p>
        </a>
    </div>
    <div class="slide-menu__item {{ $active == 'applied' ? 'active' : '' }}">
        <a href="{{ url('/applied') }}">
            <i class="fa fa-check-circle-o fa-3x"></i>
            <p>Aplicadas</p>
        </a>
    </div>
    @else
    <div class="slide-menu__item {{ $active == 'my_offers' ? 'active' : '' }}">
        <a href="{{ url('/my-offers') }}">
            <i class="fa fa-cogs fa-3x"></i>
            <p>Procesos</p>
        </a>
    </div>
    @endif
    <div class="slide-menu__item {{ $active == 'chats' ? 'active' : '' }}">
        <a href="{{ url('/chats') }}">
            <i class="fa fa-comment fa-3x"></i>
            <p>Chats</p>
        </a>
    </div>
    <div class="slide-menu__item">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">

            <i class="fa fa-sign-out fa-3x"></i>
            <p>Cerrar sesión</p>
        </a>
    </div>
</div>
@endif