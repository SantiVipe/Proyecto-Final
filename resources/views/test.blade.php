@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3>Dropdown Test</h3>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownTest" data-bs-toggle="dropdown" aria-expanded="false">
                Opciones
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownTest">
                <li><a class="dropdown-item" href="#">Acción 1</a></li>
                <li><a class="dropdown-item" href="#">Acción 2</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
