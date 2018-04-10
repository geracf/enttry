<!doctype html>
<html lang="en">

<head>
    <title>JobsHere!</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="/img/logo.png">
    <link rel="stylesheet" href="/css/onepage.min.css">
    <link rel="stylesheet" href="/css/index.min.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <script src="https://use.fontawesome.com/eb6de00e39.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="#">
            <img src="/img/logolong.png"  alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="right collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item na">
                    @if ($location == 'employers')
                        <a class="nav-link" href="{{ url('/') }}">Estudiantes</a>
                    @else
                        <a class="nav-link" href="{{ url('employers') }}">Empleadores</a>
                    @endif
                </li>
                <li class="nav-item na">
                    <a class="log nav-link" href="#">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="register nav-link" href="#">Registrate</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main">
        @if ($errors->any())
            <div style="z-index: 99; top: 87px;" class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>

    @yield('modals')

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/onepage-scroll/1.3.1/jquery.onepage-scroll.min.js"></script>

    <script src="/js/scroll.js"></script>
    <script src="/js/jquery.gsap.js"></script>
    <script src="/js/TimelineMax.js"></script>
    <script src="/js/TweenMax.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.3/ScrollMagic.js"></script>
    <script src="/js/animation.gsap.js"></script>
    <script src="/js/animations.js"></script>
    @yield('scripts')
</body>

</html>
