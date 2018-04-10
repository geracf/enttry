@extends('layouts.app', ['active' => 'my_offers'])

@section('content')

    <div class="arena">

        <h3 style="margin-left: 15px;">Detalles de {{ $offer->name }}</h3>
        <div class="my_offers--container">

            <h3>Personas que han aplicado</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @forelse($offer->applications as $application)
                            <td>
                                <a href="{{ url("student/".$application->student->id) }}">
                                    {{ $application->student->name }}
                                </a>
                            </td>
                            <td>
                                <form style="display: inline-block;" method="POST" action="{{ url("application/$application->id") }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="PUT">
                                    <select style="margin: 5px;" name="status">
                                        <option {{ $application->status == 'Nuevo' ? 'selected="selected"' : '' }} value="Nuevo">Nuevo</option>
                                        <option {{ $application->status == 'Pendiente' ? 'selected="selected"' : '' }} value="Pendiente">Pendiente</option>
                                        <option {{ $application->status == 'Revisado' ? 'selected="selected"' : '' }} value="Revisado">Revisado</option>
                                        <option {{ $application->status == 'Contratado' ? 'selected="selected"' : '' }} value="Contratado">Contratado</option>
                                    </select>
                                    <button class="btn btn-xs btn-warning">
                                        <i class="fa fa-edit"></i>
                                        Cambiar
                                    </button>
                                </form>
                            </td>
                            <td>{{ $application->created_at->format('d-m-Y H:i A') }}</td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ url("my-offers/$application->id/chat") }}">
                                    <i class="fa fa-comment"></i>
                                    Chat
                                </a>
                            </td>
                        @empty
                            <td colspan="3">No ha aplicado nadie</td>
                        @endforelse
                    </tr>
                </tbody>
            </table>


        </div>
    </div>

@endsection