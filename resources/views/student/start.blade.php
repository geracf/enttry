@extends('layouts.app', ['active' => 'NO_NAVBAR'])

@section('content')

    <div class="start__headline">
        <a href="{{ url('/') }}">
            <img src="/img/long_logo.png" alt="JobsHere" title="JobsHere">
        </a>
        <a class="pull-right logout" href="{{ url('logout') }}"
            style="margin: 15px;"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit()">Cerrar sesión</a>
    </div>

    <div class="container start__header">
        <h1>Bienvenido a JobsHere!</h1>
        <h4>Por favor llena tu CV</h4>
        <br><br>
    </div>

    <div class="container start__wrapper">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#aboutYou" aria-expanded="true" aria-controls="aboutYou">
                            Cuéntanos de ti
                        </a>
                    </h4>
                </div>
                <div id="aboutYou" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <start-details
                            url="{{ url("user/picture") }}"
                            token="{{ csrf_token() }}"></start-details>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#skills" aria-expanded="false" aria-controls="skills">
                            Habilidades
                            <span class="badge pull-right optional">opcional</span>
                        </a>
                    </h4>
                </div>
                <div id="skills" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <start-skill></start-skill>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#extraActivities" aria-expanded="false" aria-controls="extraActivities">
                            Actividades extracurriculares / Proyectos Personales
                            <span class="badge pull-right optional">opcional</span>
                        </a>
                    </h4>
                </div>
                <div id="extraActivities" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <start-featured></start-featured>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#workExperience" aria-expanded="false" aria-controls="workExperience">
                            Experiencia laboral
                            <span class="badge pull-right optional">opcional</span>
                        </a>
                    </h4>
                </div>
                <div id="workExperience" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <start-work></start-work>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#education" aria-expanded="false" aria-controls="education">
                            Educación
                            <span class="badge pull-right optional">opcional</span>
                        </a>
                    </h4>
                </div>
                <div id="education" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <start-education></start-education>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#sociales" aria-expanded="false" aria-controls="sociales">
                            Redes sociales
                            <span class="badge pull-right optional">opcional</span>
                        </a>
                    </h4>
                </div>
                <div id="sociales" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <start-social></start-social>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="ready" href="{{ url("home") }}">
        <i class="fa fa-angle-right fa-3x"></i>
    </a>

@endsection