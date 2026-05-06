@extends('adminlte::page')
@section('title', 'Vitácora')
@section('content_header')
    <h1>Registro de Actividades (Vitácora)</h1>
    <hr>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Actividades Registradas</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Acción</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vitacoras as $vitacora)
                                <tr>
                                    <td>{{ $vitacora->usuario }}</td>
                                    <td>{{ $vitacora->accion }}</td>
                                    <td>{{ $vitacora->hora ? \Illuminate\Support\Carbon::parse($vitacora->hora)->format('d/m/Y H:i:s') : '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No hay actividades registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop