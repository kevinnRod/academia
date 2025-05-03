@extends('layouts.plantilla')

@section('contenido')
<div class="text-center">
<p>Período seleccionado: {{ $periodoSeleccionado }}</p>

    <h1>Acceso permitido</h1>
    <img src="{{asset('/login/img/viru.jpg')}}" width="100%" alt="">
    
</div>
    
@endsection