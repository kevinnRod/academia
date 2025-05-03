<html>
    @foreach ($capacidad as $itemCapacidad)
    <td>
        <select class="form-select trimestre-select capacidad-select" disabled 
         data-idcapacidad="{{ $itemCapacidad->idcapacidad }}"
         data-dni="{{ $itemAlumno->dniAlumno }}" 
         name="notas[{{ $itemAlumno->dniAlumno }}][{{ $itemCapacidad->idcapacidad }}]" >
            <option value=""></option>
            <option value="AD">AD</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
        </select>
    </td>
@endforeach
    <script>
        function guardarNotas() {
    let cont=0
    var idperiodo = document.getElementById('idperiodoN').value;
    var idGrado = document.getElementById('idGradoN').value;
    var idSeccion = document.getElementById('idSeccionN').value;
    var idCurso = document.getElementById('idCursoN').value;
    var idtrimestre = document.getElementById('idtrimestreN').value;
    var codDocente = document.getElementById('codDocenteN').value;
           
    var alumnos = [];
    var capacidades = [];

    // Obtiene todos los elementos de capacidad-select
    var elementosCapacidad = document.querySelectorAll('.capacidad-select');

    
    elementosCapacidad.forEach(function (elemento) {
        var dniAlumno = elemento.getAttribute('data-dni');
        var idCapacidad = elemento.getAttribute('data-idcapacidad');
        var nota = elemento.value;

        // Agrega la capacidad a la lista de capacidades
        capacidades.push({ idCapacidad: idCapacidad, nota: nota });

        // Agrega el DNI del alumno a la lista de alumnos solo si aún no está presente
        if (!alumnos.includes(dniAlumno)) {
            alumnos.push(dniAlumno);
        }
    });
    //cantidad de capacidades
    var cantidadCapacidades = document.querySelectorAll('.capacidad-select').length;
   
            var data = {
            idperiodo: idperiodo,
            idGrado: idGrado,
            idSeccion: idSeccion,
            idCurso: idCurso,
            idtrimestre: idtrimestre,
            codDocente: codDocente,
            alumnos: alumnos,
            capacidades: capacidades
        };

            fetch('/guardarNotas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(result => {
                // Manejar la respuesta del servidor aquí
            })
            .catch(error => {
                console.error('Error al guardar las notas:', error);
            });

        i++
}

    
        


    </script>
</html>