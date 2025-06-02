@extends('layouts.plantilla')

@section('titulo')
<h3 class="page-title mb-0 p-0">Modificar Matrícula</h3>
@endsection

@section('rutalink')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('matriculas.index') }}">Matrículas</a></li>
<li class="breadcrumb-item active" aria-current="page">Modificar</li>
@endsection

@section('contenido')
<form class="form-horizontal form-material mx-2" method="POST" action="{{ route('matriculas.update', $matricula->numMatricula) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- DATOS MATRICULA -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Datos de la matrícula</h4>
                    <div class="row row-cols-2">
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Periodo</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" id="idperiodo" name="idperiodo" onchange="cargarTiposCiclo()">
                                    <option value="" selected>--Periodo--</option>
                                    @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->idperiodo }}" {{ $periodo->idperiodo == $periodo->idperiodo ? 'selected' : '' }}>
                                        {{ $periodo->idperiodo }}
                                    </option>
                                    @endforeach

                             
                                </select>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Tipo de Ciclo</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" id="idtipociclo" name="idtipociclo" onchange="cargarCiclos()">
                                    <option value="" selected>--Tipo de Ciclo--</option>
                                    @foreach ($tiposCiclo as $tipo)
                                    <option value="{{ $tipo->idtipociclo }}" {{ $tipo->idtipociclo == $matricula->ciclo->idtipociclo ? 'selected' : '' }}>
                                        {{ $tipo->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Área</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" id="idarea" name="idarea" onchange="cargarCiclos(); cargarCarreras();">
                                    <option value="" selected>--Área--</option>
                                    @foreach ($areas as $area)
                                    <option value="{{ $area->idarea }}" {{ $area->idarea == $matricula->ciclo->idarea ? 'selected' : '' }}>
                                        {{ $area->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Ciclo</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" id="idciclo" name="idciclo" onchange="cargarAulas()">
                                    <option value="" selected>--Ciclo--</option>
                                    @foreach ($ciclos as $ciclo)
                                    <option value="{{ $ciclo->idciclo }}" {{ $ciclo->idciclo == $matricula->ciclo->idciclo ? 'selected' : '' }}>
                                        {{ $ciclo->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Aula</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" id="idaula" name="idaula">
                                    <option value="" selected>--Aula--</option>
                                    @foreach ($aulas as $aula)
                                    <option value="{{ $aula->idaula }}" {{ $aula->idaula == $matricula->aula->idaula ? 'selected' : '' }}>
                                        {{ $aula->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DATOS ALUMNO -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Datos del Alumno</h4>
                    <div class="row row-cols-2">
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">DNI del Alumno</label>
                            <div class="col-md-12">
                                <input type="text" name="dniAlumno" id="dniAlumno" class="form-control" placeholder="DNI del Alumno" value="{{ $matricula->alumno->dniAlumno }}" required>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Apellidos</label>
                            <div class="col-md-12">
                                <input type="text" name="apellidosAlumno" id="apellidosAlumno" class="form-control" placeholder="Apellidos" value="{{ $matricula->alumno->apellidos }}" required>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Nombres</label>
                            <div class="col-md-12">
                                <input type="text" name="nombresAlumno" id="nombresAlumno" class="form-control" placeholder="Nombres" value="{{ $matricula->alumno->nombres }}" required>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Fecha de Nacimiento</label>
                            <div class="col-md-12">
                                <input type="date" name="fechaNacimiento" class="form-control" id="fechaNacimiento" value="{{ $matricula->alumno->fechaNacimiento }}" required>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Carrera</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none ps-0 form-control-line" name="idcarrera" id="idcarrera" required>
                                    <option value="" selected>--Seleccionar Carrera--</option>
                                    @foreach ($carreras as $carrera)
                                    <option value="{{ $carrera->idcarrera }}" {{ $carrera->idcarrera == $matricula->alumno->idcarrera ? 'selected' : '' }}>
                                        {{ $carrera->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Foto actual</label>
                            <div class="col-sm-12 border-bottom">
                                @if (!empty($alumno->urlFotoTemporal))
                                    <img src="{{ $alumno->urlFotoTemporal }}" alt="Foto del alumno" width="200px">
                                @endif

                            </div>

                        <div class="col form-group">
                            <label for="featured" class="col-md-12 mb-0">Cambiar foto del alumno</label>
                            <div class="col-sm-12 border-bottom">
                                <input type="file" name="featured" id="featured" accept="image/jpeg, image/png" class="form-control ps-0 form-control-line @error('featured') is-invalid @enderror">
                                @error('featured')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Seleccione una imagen (tamaño máximo: 2MB)</small>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- DATOS DEL PAGO -->
<div class="row mb-4">
        <div class="col-sm-12">
            <div class="card">
            <h4 class="text-center m-0 p-2">Datos del Pago</h4>
                <div class="card-body">
                    

                    <!-- Contenedor para los pagos existentes -->
                    <div id="pagos-container">
                        @foreach($pagos as $index => $pago)
                        <div class="row row-cols-2 mb-4 pago-item">
                            <div class="col-md-6 mb-3">
                                <label for="idmediopago_{{ $index }}" class="form-label">Medio de Pago</label>
                                <select name="idmediopago[{{ $index }}]" id="idmediopago_{{ $index }}" class="form-select" required>
                                    <option value="" disabled>Seleccione un medio de pago</option>
                                    @foreach($mediopago as $medio)
                                        <option value="{{ $medio->idmediopago }}" {{ $medio->idmediopago == $pago->idmediopago ? 'selected' : '' }}>{{ $medio->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nropago_{{ $index }}" class="form-label">Número de Pago</label>
                                <input type="text" name="nropago[{{ $index }}]" id="nropago_{{ $index }}" class="form-control" placeholder="Número de Pago" value="{{ $pago->nropago }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fechaPago_{{ $index }}" class="form-label">Fecha de Pago</label>
                                <input type="date" name="fechaPago[{{ $index }}]" id="fechaPago_{{ $index }}" class="form-control" value="{{ $pago->fecha }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="montoPago_{{ $index }}" class="form-label">Monto Pagado</label>
                                <input type="text" name="montoPago[{{ $index }}]" id="montoPago_{{ $index }}" class="form-control" placeholder="Monto Pagado" value="{{ $pago->monto }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estadoPago_{{ $index }}" class="form-label">Estado del Pago</label>
                                <select name="estadoPago[{{ $index }}]" id="estadoPago_{{ $index }}" class="form-select">
                                    <option value="pendiente" {{ $pago->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmado" {{ $pago->estado === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                    <option value="cancelado" {{ $pago->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Comprobante Actual</label>
                                @if ($pago->urlTemporal)
                                    <a href="{{ $pago->urlTemporal }}" target="_blank">
                                        <img src="{{ $pago->urlTemporal }}" width="200px">
                                    </a>
                                @else
                                    <p>Sin comprobante</p>
                                @endif

                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="rutaImagen_{{ $index }}" class="form-label">Cambiar Foto de Comprobante</label>
                                <input type="file" name="rutaImagen[{{ $index }}]" id="rutaImagen_{{ $index }}" accept="image/jpeg, image/png" class="form-control @error('rutaImagen') is-invalid @enderror">
                                @error('rutaImagen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Seleccione una imagen del comprobante (tamaño máximo: 2MB)</small>
                            </div>
                            <input type="hidden" name="idpago[]" value="{{ $pago->idpago }}">
                            <div class="col-md-12 mb-3">
                                <button type="button" class="btn btn-danger btn-sm remove-payment-btn" data-index="{{ $index }}">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Botón para agregar un nuevo pago -->
                    <button type="button" id="add-payment-btn" class="btn btn-primary mt-4">Añadir Pago</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTONES -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success text-white"><i class="fas fa-save"></i> Guardar Cambios</button>
                        <a href="{{ route('cancelarMatricula') }}" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var container = document.getElementById('pagos-container');

        // Manejar clic en el botón de eliminar pago
        container.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('remove-payment-btn')) {
                var paymentItem = event.target.closest('.pago-item');
                
                // Eliminar el elemento del DOM
                if (paymentItem) {
                    paymentItem.remove();
                    
                    // Actualizar índices de los elementos restantes
                    updatePaymentIndices();
                }
            }
        });

        // Función para actualizar los índices de los pagos
        function updatePaymentIndices() {
            var items = container.querySelectorAll('.pago-item');
            items.forEach(function(item, index) {
                item.querySelectorAll('input, select').forEach(function(input) {
                    // Actualizar el nombre y el id de cada input
                    input.name = input.name.replace(/\[\d+\]/, '[' + index + ']');
                    input.id = input.id.replace(/_\d+$/, '_' + index);
                });
            });
        }

        // Manejar clic en el botón de añadir pago
        document.getElementById('add-payment-btn').addEventListener('click', function() {
            // Clonar el último elemento de pago
            var lastPayment = container.querySelector('.pago-item:last-child');
            var newPayment = lastPayment.cloneNode(true);

            // Incrementar el índice de los elementos
            var currentIndex = container.querySelectorAll('.pago-item').length;

            // Limpiar y actualizar los nombres e IDs de los elementos clonados
            newPayment.querySelectorAll('input, select').forEach(function(input) {
                // Actualiza el nombre y el id de cada input
                input.name = input.name.replace(/\[\d+\]/, '[' + currentIndex + ']');
                input.id = input.id.replace(/_\d+$/, '_' + currentIndex);

                // Limpiar los valores de los inputs (si es necesario)
                if (input.type === 'text' || input.type === 'date' || input.type === 'select-one') {
                    input.value = '';
                } else if (input.type === 'file') {
                    input.value = ''; // Limpiar el input file
                } else if (input.type === 'hidden') {
                    input.value = ''; // Asegúrate de limpiar el ID de pago oculto para un nuevo pago
                }
            });

            // Elimina la imagen previa del comprobante en la nueva entrada de pago
            var image = newPayment.querySelector('img');
            if (image) {
                image.remove();
            }

            // Añadir el nuevo pago al contenedor
            container.appendChild(newPayment);
        });
    });
</script>
@endsection