@extends('adminlte::page')
@section('title', 'Cambiar Contraseña')
@section('content_header')
    <h1>Cambiar Contraseña</h1>
    <hr>
@stop
{{-- FORM --}}
@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cambiar tu contraseña</h3>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="current_password">Contraseña Actual <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control" name="current_password" placeholder="Ingresa tu contraseña actual" required>
                                    </div>
                                    @error('current_password')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Nueva Contraseña <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" class="form-control" name="password" placeholder="Ingresa la nueva contraseña" required>
                                    </div>
                                    <small class="form-text text-muted">La contraseña debe tener al menos 8 caracteres, incluyendo 1 mayúscula, 1 minúscula y 1 número.</small>
                                    @error('password')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Nueva Contraseña <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirma la nueva contraseña" required>
                                    </div>
                                    @error('password_confirmation')
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{ url('/admin') }}" class="btn btn-default"><i class="fas fa-arrow-left"></i> Cancelar</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cambiar Contraseña</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop