<!-- DATOS DEL PAGO -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Datos del Pago</h4>

                <!-- Contenedor para los pagos existentes -->
                <div id="pagos-container">
                    @foreach($pagos as $index => $pago)
                    <div class="row row-cols-2 mb-4 pago-item">
                        <div class="col-md-12">
                            <label for="idmediopago_{{ $index }}" class="form-label">Medio de Pago</label>
                            <select name="idmediopago[{{ $index }}]" id="idmediopago_{{ $index }}" class="form-select" required>
                                <option value="" disabled>Seleccione un medio de pago</option>
                                @foreach($mediopago as $medio)
                                    <option value="{{ $medio->idmediopago }}" {{ $medio->idmediopago == $pago->idmediopago ? 'selected' : '' }}>{{ $medio->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="nropago_{{ $index }}" class="form-label">Número de Pago</label>
                            <input type="text" name="nropago[{{ $index }}]" id="nropago_{{ $index }}" class="form-control" placeholder="Número de Pago" value="{{ $pago->nropago }}" required>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Fecha de Pago</label>
                            <div class="col-md-12">
                                <input type="date" name="fechaPago[{{ $index }}]" id="fechaPago_{{ $index }}" class="form-control" value="{{ $pago->fecha }}">
                            </div>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Monto Pagado</label>
                            <div class="col-md-12">
                                <input type="text" name="montoPago[{{ $index }}]" id="montoPago_{{ $index }}" class="form-control" placeholder="Monto Pagado" value="{{ $pago->monto }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="estadoPago[{{ $index }}]">Estado del Pago:</label>
                            <select name="estadoPago[{{ $index }}]" id="estadoPago[{{ $index }}]" class="form-control">
                                <option value="pendiente" {{ $pago->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmado" {{ $pago->estado === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                <option value="cancelado" {{ $pago->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label class="col-md-12 mb-0">Comprobante actual</label>
                            <div class="col-sm-12 border-bottom">
                                @if ($pago->rutaImagen)
                                <a href="{{ asset($pago->rutaImagen) }}" class="fancybox" data-fancybox="gallery">
                                    <img src="{{ asset($pago->rutaImagen) }}" alt="Foto del comprobante" class="img-fluid mt-2" width="200px">
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="rutaImagen_{{ $index }}" class="form-label">Cambiar foto de comprobante</label>
                            <input type="file" name="rutaImagen[{{ $index }}]" id="rutaImagen_{{ $index }}" accept="image/jpeg, image/png" class="form-control @error('rutaImagen') is-invalid @enderror">
                            @error('rutaImagen')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">Seleccione una imagen del comprobante (tamaño máximo: 2MB)</small>
                        </div>
                        <!-- Aquí va el contenido de los campos de pago -->
                        <input  name="idpago[]"  value="{{ $pago->idpago }}">
                        <div class="col-md-12">
                            <!-- Botón para eliminar el pago -->
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
                    <div class="form-group">
                        <div class="col-sm-12 d-flex">
                            <button type="submit" class="btn btn-success mx-auto me-2 text-white"><i class="fas fa-save"></i> Guardar Cambios</button>
                            <a href="{{ route('cancelarMatricula') }}" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
<script>
    document.getElementById('add-payment-btn').addEventListener('click', function() {
    // Obtener el contenedor donde se agregan los pagos
    var container = document.getElementById('pagos-container');

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
    var imageContainer = newPayment.querySelector('.img-fluid');
    if (imageContainer) {
        imageContainer.remove();
    }

    // Agregar el nuevo pago al contenedor
    container.appendChild(newPayment);
});

document.addEventListener('DOMContentLoaded', function() {
    // Manejar clic en el botón de eliminar pago
    document.getElementById('pagos-container').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-payment-btn')) {
            var paymentItem = event.target.closest('.pago-item');
            var index = event.target.getAttribute('data-index');

            // Marcar el pago como cancelado
            var estadoPagoSelect = paymentItem.querySelector('select[name="estadoPago[' + index + ']"]');
            if (estadoPagoSelect) {
                estadoPagoSelect.value = 'cancelado';
            }

            // Ocultar el elemento visualmente
            paymentItem.style.display = 'none';
        }
    });
});

</script>

@endsection





public function update(Request $request, $numMatricula)
{
    // dd($request->all());
    // Validación de los datos
    $request->validate([
        'idtipociclo' => 'required',
        'idarea' => 'required',
        'idciclo' => 'required',
        'idaula' => 'required',
        'dniAlumno' => 'required',
        'apellidosAlumno' => 'required',
        'nombresAlumno' => 'required',
        'fechaNacimiento' => 'required',
        'idcarrera' => 'required',
        'featured' => 'nullable|image|mimes:jpeg,png|max:2048',
        'idpago.*' => 'nullable|integer|exists:pago,idpago',
        'nropago.*' => 'required_with:idpago.*|numeric',
        'fechaPago.*' => 'required_with:idpago.*|date',
        'montoPago.*' => 'required_with:idpago.*|numeric',
        'idmediopago.*' => 'required_with:idpago.*|integer',
        'estadoPago.*' => 'required_with:idpago.*|in:pendiente,confirmado,cancelado',

        'rutaImagen.*' => 'nullable|image|mimes:jpeg,png|max:2048',
        
    ]);

    // Actualizar los datos de la matrícula
    $matricula = Matricula::findOrFail($numMatricula);
    $matricula->dniAlumno = $request->dniAlumno;
    $matricula->idaula = $request->idaula;
    $matricula->idciclo = $request->idciclo;
    $matricula->save();

    // Actualizar los datos de los pagos existentes
    foreach ($request->idpago as $index => $idpago) {
        if ($idpago) {
            // Buscar el pago por su ID
            $pago = Pago::findOrFail($idpago);

            // Actualizar los campos del pago
            $pago->nropago = $request->nropago[$index];
            $pago->fecha = $request->fechaPago[$index];
            $pago->monto = $request->montoPago[$index];
            $pago->idmediopago = $request->idmediopago[$index];
            $pago->estado = $request->estadoPago[$index]; // Actualizar el estado del pago

            // Procesar la imagen del comprobante si se proporciona
            if ($request->hasFile('rutaImagen.' . $index)) {
                $file = $request->file('rutaImagen.' . $index);
                $destinationPath = 'images/pagos/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $file->move($destinationPath, $filename);

                if ($uploadSuccess) {
                    // Verificar si hay una imagen anterior y eliminarla
                    if ($pago->rutaImagen) {
                        $oldFilePath = public_path($pago->rutaImagen);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Actualizar la referencia de la imagen en la base de datos con la nueva ruta
                    $pago->rutaImagen = $destinationPath . $filename;
                }
            }

            $pago->save();
        } else {
            // Crear un nuevo pago si idpago es null
            $pago = new Pago();
            $pago->nropago = $request->nropago[$index];
            $pago->fecha = $request->fechaPago[$index];
            $pago->monto = $request->montoPago[$index];
            $pago->idmediopago = $request->idmediopago[$index];
            $pago->numMatricula = $numMatricula;
            $pago->estado = $request->estadoPago[$index]; // Establecer el estado del pago

            // Procesar la imagen del comprobante si se proporciona
            if ($request->hasFile('rutaImagen.' . $index)) {
                $file = $request->file('rutaImagen.' . $index);
                $destinationPath = 'images/pagos/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $file->move($destinationPath, $filename);

                if ($uploadSuccess) {
                    $pago->rutaImagen = $destinationPath . $filename;
                }
            }

            $pago->save();
        }
    }

    // Actualizar los datos del alumno
    $alumno = Alumno::findOrFail($matricula->dniAlumno);
    $alumno->dniAlumno = $request->dniAlumno;
    $alumno->apellidos = $request->apellidosAlumno;
    $alumno->nombres = $request->nombresAlumno;
    $alumno->fechaNacimiento = $request->fechaNacimiento;
    $alumno->idcarrera = $request->idcarrera;

    // Procesar la nueva imagen del alumno si se proporciona
    if ($request->hasFile('featured')) {
        $file = $request->file('featured');
        $destinationPath = 'images/alumnos/';
        $filename = time() . '-' . $file->getClientOriginalName();
        $uploadSuccess = $file->move($destinationPath, $filename);

        if ($uploadSuccess) {
            // Verificar si hay una imagen anterior y eliminarla
            if ($alumno->featured) {
                $oldFilePath = public_path($alumno->featured);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            // Actualizar la referencia de la imagen en la base de datos con la nueva ruta
            $alumno->featured = $destinationPath . $filename;
        }
    }

    $alumno->save();

    return redirect()->route('matriculas.index')->with('success', 'Matrícula y datos del alumno actualizados con éxito');
}

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

                // Limpiar los valores de los inputs
                if (input.type === 'text' || input.type === 'date' || input.type === 'select-one') {
                    input.value = '';
                } else if (input.type === 'file') {
                    input.value = ''; // Limpiar el input file
                }
            });

            // Eliminar la imagen previa del comprobante en la nueva entrada de pago
            var imageContainer = newPayment.querySelector('.img-fluid');
            if (imageContainer) {
                imageContainer.remove();
            }

            // Agregar el nuevo pago al contenedor
            container.appendChild(newPayment);
        });

        // Función para actualizar los índices de los elementos de pago
        function updatePaymentIndices() {
            container.querySelectorAll('.pago-item').forEach(function(item, index) {
                item.querySelectorAll('input, select').forEach(function(input) {
                    // Actualiza el nombre y el id de cada input
                    input.name = input.name.replace(/\[\d+\]/, '[' + index + ']');
                    input.id = input.id.replace(/_\d+$/, '_' + index);
                });

                // Actualiza el atributo data-index del botón de eliminar
                var removeButton = item.querySelector('.remove-payment-btn');
                if (removeButton) {
                    removeButton.setAttribute('data-index', index);
                }
            });
        }
    });
</script>
@endsection