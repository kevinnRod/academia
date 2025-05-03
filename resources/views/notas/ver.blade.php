@extends('layouts.plantilla')
@section('estilos')
<style>
.confirmation-dialog {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    justify-content: center;
    align-items: center;
}

.confirmation-box {
    background: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    padding: 20px;
    max-width: 400px;
    text-align: center;
    border-radius: 5px;
}

.confirmation-box h3 {
    margin-top: 0;
}

.confirmation-box button {
    margin: 10px;
    padding: 5px 10px;
    background: #ff4f4f;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.confirmation-box button.cancel {
    background: #ccc;
}

</style>
@endsection

@section('titulo')
    <h3 class="page-title mb-0 p-0">VER NOTAS</h3>
@endsection

@section('rutalink')
    <li class="breadcrumb-item active" aria-current="page">VER NOTAS</li>
@endsection 

@section('contenido')
    <div class="row text-black">
        <!-- column -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-12">
                        <h4 class="card-title">Lista de Notas registradas</h4>

                    </div>

                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid justify-content-end">
                            <div class="col-md-4 col-6">
                                <form class="d-flex" role="search">
                                    <input name="buscarpor" class="form-control me-2" type="search" placeholder="Busqueda por curso" arialabel="Search" value="{{ $buscarpor }}">
                                    <button class="btn btn-success" type="submit">Buscar</button>
                                </form>
                            </div>
                        </div>
                    </nav>

                    @if (session('datos'))
                    <div id="mensaje">
                        @if (session('datos'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" >
                            {{ session('datos') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" arialabel="Close"></button>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="border-top-0">Periodo</th>
                                    <th class="border-top-0">Trimestre</th>
                                    <th class="border-top-0">Curso</th>
                                    <th class="border-top-0">Nivel</th>
                                    <th class="border-top-0">Grado</th>
                                    <th class="border-top-0">Sección</th>
                                    <th class="border-top-0">Docente</th>
                                    <th class="border-top-0">Opciones</th>
                                </tr>
                            </thead> 
                            <tbody>
                            @if ($gruposDeNotas->isEmpty())
                                <div class="col-12">
                                    <p>No hay registros</p>
                                </div>
                            @else
                                @foreach ($gruposDeNotas as $grupo)
                                    @php
                                        $primerNota = $grupo->first(); 
                                    @endphp
                                    <tr>
                                        <td>{{ $primerNota->idperiodo}}</td>
                                        <td>{{ $primerNota->trimestre->descripcion}}</td>
                                        <td>{{ $primerNota->curso->curso }}</td>
                                        <td>{{ $primerNota->curso->nivel->nivel }}</td>
                                        <td>{{ $primerNota->grado->grado }}</td>
                                        <td>{{ $primerNota->seccion->seccion }}</td>
                                        <td>{{ $primerNota->docente->nombres }} {{ $primerNota->docente->apellidos }}</td>
                                        <td>
                                        <a href="{{ route('notas.verAlumnosPorFiltros', ['periodo' => $primerNota->idperiodo, 'curso' => $primerNota->idCurso, 'grado' => $primerNota->idGrado, 'seccion' => $primerNota->idSeccion, 'trimestre' => $primerNota->idtrimestre]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a href="{{ route('notas.eliminar', ['idperiodo' => $primerNota->idperiodo, 'idCurso' => $primerNota->idCurso, 'idGrado' => $primerNota->idGrado, 'idSeccion' => $primerNota->idSeccion, 'idtrimestre' => $primerNota->idtrimestre]) }}" class="btn btn-danger btn-sm eliminar-nota" data-eliminacion-confirm="¿Estás seguro de que deseas eliminar este registro?">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </a>
                                        <a target="_blank" href="{{ route('notas.notasPdfPorCurso', ['periodo' => $primerNota->idperiodo, 'curso' => $primerNota->idCurso, 'grado' => $primerNota->idGrado, 'seccion' => $primerNota->idSeccion, 'trimestre' => $primerNota->idtrimestre]) }}" class="btn btn-warning btn-sm"><i class="fas fa-print"></i>Imprimir</a>

                                      
                                    </td>

                                        

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="confirmationModal" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="confirmationMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const eliminarNotasLinks = document.querySelectorAll(".eliminar-nota");

    eliminarNotasLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            const confirmMessage = link.getAttribute("data-eliminacion-confirm");
            const confirmationModal = document.getElementById("confirmationModal");
            const confirmationMessage = document.getElementById("confirmationMessage");

            // Set the confirmation message
            confirmationMessage.textContent = confirmMessage;

            // Show the confirmation modal
            $(confirmationModal).modal('show');

            // Handle the delete confirmation
            document.getElementById("confirmDelete").addEventListener("click", function() {
                window.location.href = link.getAttribute("href");
            });
        });
    });
});

</script>


@endsection