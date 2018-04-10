@extends('layouts.app', ['active' => 'discover'])

@section('content')

    <div class="arena">

        @if (session('success'))
            <div style="position: fixed; top: 0; width: 100%; z-index: 999;" class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div style="position: fixed; top: 0; width: 100%; z-index: 999;" class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row single-student">
            <div class="col-sm-4 col-sm-offset-4">
                <img class="img-responsive single-student__avatar" src="{{ $student->avatar() }}">
            </div>
        </div>

        <div class="row single-student">
            <div class="col-sm-6 col-sm-offset-3">
                <h3>{{ $student->name }}</h3>
            </div>
        </div>

        <div class="row single-student__details">
            @can ('contact', $student)
                <div style="margin-bottom: 15px;" class="col-sm-12">
                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#contactStudent">Contactar</button>
                </div>
            @elseif (Auth::user()->id != $student->id)
                <div style="margin-bottom: 15px;" class="col-sm-12">
                    <button class="btn btn-warning pull-right">No tienes puntos discovery :c</button>
                </div>
            @endcan

            @can ('contactDirectly', $student)
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Información de contacto</h4>
                    </div>
                    <div class="col-sm-6">
                        <strong>
                            <i class="fa fa-phone"></i>
                            Teléfono: <br>
                        </strong>
                        {{ $student->phone ?: 'No agregó ninguno' }}
                    </div>
                    <div class="col-sm-6">
                        <strong>
                            <i class="fa fa-at"></i>
                            Email: <br>
                        </strong>
                        {{ $student->email ?: 'No agregó ninguno' }}
                    </div>
                </div>
                <hr>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <h4>Información general</h4>
                </div>
                <div class="col-sm-3">
                    <p>
                        <strong>
                            <i class="fa fa-calendar-o"></i>
                            Edad: <br>
                        </strong>
                        {{ $student->age ? "$student->age años" : 'No especificó' }}
                    </p>
                </div>
                <div class="col-sm-3">
                    @if (!is_null($student->sex))
                    <p>
                        <strong>
                            <i class="fa {{ $student->sex ? 'fa-male' : 'fa-female' }}"></i>
                            Sexo:<br>
                        </strong>
                        {{ $student->sex ? 'Masculino' : 'Femenino' }}
                    </p>
                    @else
                    <p>
                        <strong>
                            <i class="fa fa-genderless"></i>
                            Sexo:<br>
                        </strong>
                        No especificó
                    </p>
                    @endif
                </div>
                <div class="col-sm-3">
                    <p>
                        <strong>
                            <i class="fa fa-calendar-o"></i>
                            Disponibilidad: <br>
                        </strong>
                        {{ $student->availability ?: 'No especificó' }}
                    </p>
                </div>
                <div class="col-sm-3">
                    <p>
                        <strong>
                            <i class="fa fa-graduation-cap"></i>
                            Graduado: <br>
                        </strong>
                        {{ $student->graduated_at ? $student->graduated_at->format('d-m-Y') : 'No especificó' }}
                        @if ($student->graduated_at && $student->graduated_at->diffInYears(Carbon\Carbon::now()) < 2)
                            <p class="text-success">Recién graduado</p>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p>
                        <strong>
                            <i class="fa fa-search"></i>
                            Campo de interés: <br>
                        </strong>
                        {{ $student->foi }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <p>
                        <strong>
                            <i class="fa fa-university"></i>
                            Universidad: <br>
                        </strong>
                        {{ $student->university ?: 'No especificó' }}
                    </p>
                </div>
                <div class="col-sm-4">
                    <p>
                        <strong>
                            <i class="fa fa-graduation-cap"></i>
                            Carrera: <br>
                        </strong>
                        {{ $student->major ?: 'No especificó' }}
                    </p>
                </div>
                <div class="col-sm-4">
                    <strong>
                        <i class="fa fa-map-marker"></i>
                        Localización: <br>
                    </strong>
                    {{ $student->state }} {{ $student->city }}
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h4>Habilidades</h4>
                </div>
                <div class="col-sm-4">
                    Idiomas
                    <ul>
                        @forelse($student->skills->where('type', 'language') as $language)
                            <li>{{ $language->title }} ({{ $language->development }})</li>
                        @empty
                            <li>Ninguno agregado</li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-sm-4">
                    Habilidades Técnicas
                    <ul>
                        @forelse($student->skills->where('type', 'technical') as $tech)
                            <li>{{ $tech->title }} ({{ $tech->development }})</li>
                        @empty
                            <li>Ninguno agregado</li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-sm-4">
                    Habilidades suaves
                    <ul>
                        @forelse($student->skills->where('type', 'soft') as $soft)
                            <li>{{ $soft->title }}</li>
                        @empty
                            <li>Ninguno agregado</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h4>Sociales</h4>
                </div>
                @if ($student->facebook)
                    <div class="col-sm-3">
                        <p>
                            <strong>
                                <i class="fa fa-facebook"></i>
                                <a class="single-student__social" href="{{ $student->facebook }}">  Ver</a>
                            </strong>
                        </p>
                    </div>
                @endif
                @if ($student->twitter)
                    <div class="col-sm-3">
                        <p>
                            <strong>
                                <i class="fa fa-twitter"></i>
                                <a class="single-student__social" href="{{ $student->twitter }}">  Ver</a>
                            </strong>
                        </p>
                    </div>
                @endif
                @if ($student->linkedin)
                    <div class="col-sm-3">
                        <p>
                            <strong>
                                <i class="fa fa-linkedin"></i>
                                <a class="single-student__social" href="{{ $student->linkedin }}">  Ver</a>
                            </strong>
                        </p>
                    </div>
                @endif
                @if ($student->spotify)
                    <div class="col-sm-3">
                        <p>
                            <strong>
                                <i class="fa fa-spotify"></i>
                                <a class="single-student__social" href="{{ $student->spotify }}">  Ver</a>
                            </strong>
                        </p>
                    </div>
                @endif
            </div>

        </div>

        <div class="row single-student__achivements">
            <div class="col-md-4 col-xs-12">
                <h4>Educación</h4>

                @if ($student->education->count() > 0)
                    @foreach($student->education as $education)
                        <div>
                            <p>
                                <a target="_blank" href="{{ $education->school_website }}">
                                    {{ $education->school_name }}
                                </a>
                            </p>
                            <p class="muted">
                                Desde: {{ title_case(Date::parse($education->start_date)->format('F Y')) }}
                                @if (!$education->current)
                                    a {{ title_case(Date::parse($education->end_date)->format('F Y')) }}
                                @endif
                            </p>
                            <p class="muted">
                                <strong>Campo de estudio: </strong>
                                {{ $education->degree }}
                            </p>
                            <p class="muted">
                                <strong>Reconocimientos: </strong>
                                {{ $education->achivements }}
                            </p>
                        </div>
                    @endforeach
                @else
                    <p>El estudiante no ha agregado datos.</p>
                @endif
            </div>
            <div class="col-md-4 col-xs-12">
                <h4>Experiencia</h4>
                @if ($student->workExperience->count() > 0)
                    @foreach($student->workExperience as $experience)
                        <div>
                            <p>
                                <a target="_blank" href="{{ $experience->organization_website }}">
                                    {{ $experience->organization_name }}
                                </a>
                            </p>
                            <p class="muted">
                                Desde: {{ title_case(Date::parse($experience->start_date)->format('F Y')) }}
                                @if (!$experience->current)
                                    a {{ title_case(Date::parse($experience->end_date)->format('F Y')) }}
                                @endif
                            </p>
                            <p class="muted">
                                <strong>Título: </strong>
                                {{ $experience->title }}
                            </p>
                            <p class="muted">
                                <strong>Responsabilidades: </strong>
                                {{ $experience->responsibilities }}
                            </p>
                        </div>
                    @endforeach
                @else
                    <p>El estudiante no ha agregado datos.</p>
                @endif
            </div>
            <div class="col-md-4 col-xs-12">
                <h4>Extracurricular</h4>
                @if ($student->featuredWork->count() > 0)
                    @foreach($student->featuredWork as $work)
                        <div>
                            <p>
                                <a target="_blank" href="{{ $work->feature_url }}">
                                    {{ $work->feature_name }}
                                </a>
                            </p>
                            <p class="muted">
                                Lanzado: {{ title_case(Date::parse($work->release_date)->format('F Y')) }}
                            </p>
                            <p class="muted">
                                <strong>Descripción: </strong>
                                {{ $work->desc }}
                            </p>
                        </div>
                    @endforeach
                @else
                    <p>El estudiante no ha agregado datos.</p>
                @endif
            </div>
        </div>

    </div>

    @can('contact', $student)
        <div id="contactStudent" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Contactar estudiante</h4>
                    </div>
                    <div class="modal-body">
                        <p>Recuerda que contactar a un estudiante cuesta un punto discovery.</p>
                        <hr>

                        <form action="{{ url("student/$student->id") }}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label>Oferta a la cual lo(a) invitas</label>
                                <select class="form-control" name="offer_id">
                                    <option>Selecciona una oferta</option>
                                    @foreach (Auth::user()->organization->offers as $offer)
                                        <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message">Escríbe tu mensaje</label>
                                <textarea class="form-control" name="message" placeholder="¿Que le quieres decir?" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary pull-right">Enviar</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan

@endsection