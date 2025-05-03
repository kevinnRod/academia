@extends('layouts.plantilla')

@section('titulo')
    <h3 class="page-title mb-0 p-0">Año Escolar</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">Año Escolar</li>
@endsection

@section('contenido')
<div class="row text-black">
    <!-- column -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title">Lista de grados y secciones</h4>
                    </div>
                </div>
                @if (session('datos'))
                <div id="mensaje">
                    @if (session('datos'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" >
                        {{ session('datos') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                </div>
                @endif

                <div class="row">
                    @if (count($periodo) <= 0)
                        <div class="col-12">
                            <p>No hay registros</p>
                        </div>
                    @else
                    @foreach($periodo as $itemanyo)
                        <div class="col-md-4">
                            <div class="card" style="border-radius: 20px; overflow: hidden; ">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('' . $imagenes[$loop->index]) }}" alt="Imagen" style="width: 510px; height: 305px;">
                                </div>
                                <div class="card-body text-center"> 
                                    <div class="text-center">
                                        <h5 >Periodo: {{ $itemanyo->idperiodo }}</h5>
                                    </div>
                                    
                                    <p class="card-text">
                                        <a href="{{ route('aulas.index', $itemanyo->idperiodo) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Grados y secciones
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach




                    @endif
                </div>
                {{ $periodo->links() }}
            </div>
        </div>
    </div>
</div>


@endsection