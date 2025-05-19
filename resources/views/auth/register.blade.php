@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro de usuario') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        <!-- Identificación -->
                        <div class="row mb-3">
                            <label for="identificacion" class="col-md-4 col-form-label text-md-end">Identificación</label>
                            <div class="col-md-6">
                                <input id="identificacion" type="text" class="form-control @error('identificacion') is-invalid @enderror" name="identificacion" value="{{ old('identificacion') }}" required autofocus>
                                @error('identificacion')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div class="row mb-3">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end">Nombre completo</label>
                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="rol" value="cliente">

                        <!-- Dirección -->
                        <div class="row mb-3">
                            <label for="direccion" class="col-md-4 col-form-label text-md-end">Dirección</label>
                            <div class="col-md-6">
                                <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion') }}">
                                @error('direccion')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="row mb-3">
                            <label for="telefono" class="col-md-4 col-form-label text-md-end">Teléfono</label>
                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}">
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar contraseña</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <!-- Botón -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrarse
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
