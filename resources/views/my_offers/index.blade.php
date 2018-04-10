@extends('layouts.app', ['active' => 'my_offers'])

@section('content')

    <div class="arena">

        <h3 style="margin-left: 15px;">Mis ofertas</h3>
        <div class="my_offers--container">

            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Aplicantes</th>
                        <th>Visto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($offers as $offer)
                        <tr>
                            <td>
                                <a href="{{ url("offer/$offer->id") }}">
                                    {{ $offer->name }}</td>
                                </a>
                            <td>{{ $offer->applications->count() }}</td>
                            <td>{{ $offer->view_count }}</td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ url("my-offers/$offer->id") }}">
                                    <i class="fa fa-search"></i>
                                    Ver detalles
                                </a>
                                {{-- <a class="btn btn-xs btn-warning" href="{{ url("my-offers/$offer->id/edit") }}">
                                    <i class="fa fa-edit"></i>
                                    Editar
                                </a> --}}
                                <form method="post" action="{{ url("my-offers/$offer->id") }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-xs btn-danger">
                                        <i class="fa fa-times"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No hay ninguna oferta activa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

@endsection