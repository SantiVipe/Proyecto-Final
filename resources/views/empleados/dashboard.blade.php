@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bienvenido, {{ Auth::user()->name }}</h2>
    <p>Este es tu panel de empleado.</p>
</div>
@endsection
