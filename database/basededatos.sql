drop database if exists g07mn;
create database g07mn;
use g07mn;

create table estadosCivil(idEstadoCivil integer, estadoCivil varchar(20), primary key(idEstadoCivil));

create table niveles(idNivel integer, nivel char(20), primary key(idNivel));

create table anyoEscolar(numAnyo char(4), fechaInicio date, fechaTermino date, estado integer, primary key(numAnyo));

create table docentes(codDocente integer auto_increment, apellidos varchar(100), nombres varchar(100), direccion varchar(100), idEstadoCivil integer, telefono char(15), fechaIngreso date, idNivel integer, estado integer, primary key(codDocente), foreign key(idNivel) references niveles(idNivel), foreign key(idEstadoCivil) references estadosCivil(idEstadoCivil));

create table grados(idGrado integer, grado varchar(50), idNivel integer, primary key(idGrado), foreign key(idNivel) references niveles(idNivel));

create table secciones(idSeccion integer auto_increment, idGrado integer, seccion char(2), numAnyo integer, aula char(4), estado integer, primary key(idSeccion), foreign key(idGrado) references grados(idGrado));

create table cursos(idCurso integer auto_increment, codCurso varchar(10), curso varchar(50), idNivel integer, estado integer, primary key(idCurso), foreign key(idNivel) references niveles(idNivel));

create table capacidades(idCapacidad integer auto_increment, abreviatura varchar(100), descripcion varchar(100), primary key(idCapacidad));

create table docente_curso(id integer auto_increment, codDocente integer, idCurso integer, numAnyo char(4), idSeccion integer, idGrado integer, estado integer, primary key(id, codDocente, idCurso));

create table curso_capacidad(idCurso integer, idCapacidad integer, orden integer, primary key(idCurso, idCapacidad));

create table apoderados(dniApoderado char(8), apellidos varchar(50), nombres varchar(50), edad integer, idEstadoCivil integer, telefono char(15), direccion varchar(50), primary key(dniApoderado), foreign key(idEstadoCivil) references estadosCivil(idEstadoCivil));

create table alumnos(dniAlumno char(8), apellidos varchar(50), nombres varchar(50), edad integer, fechaNacimiento date, dniApoderado char(8), estado integer, primary key(dniAlumno));

create table alumno_seccion(dniAlumno char(8), idSeccion integer, idGrado integer, estado integer, primary key(dniAlumno, idSeccion, idGrado));

create table matriculas(numMatricula integer auto_increment, fechaMatricula date, numAnyo char(4), dniAlumno char(8), idSeccion integer, idGrado integer, estado integer, primary key(numMatricula), foreign key(numAnyo) references anyoEscolar(numAnyo));

create table notas(idCurso integer, idCapacidad integer, numAnyo char(4), dniAlumno char(8), idSeccion integer, idGrado integer, unidad1 integer, unidad2 integer, unidad3 integer, unidad4 integer, exonerar char(1), primary key(idCurso, idCapacidad, numAnyo, dniAlumno, idSeccion, idGrado));

insert into estadosCivil values
(1, 'Soltero'),
(2, 'Casado'),
(3, 'Divorsiado'),
(4, 'Viudo');

insert into niveles values
(1, 'Inicial'),
(2, 'Primaria'),
(3, 'Secundaria');

insert into grados values
(1, '3 años', 1),
(2, '4 años', 1),
(3, '5 años', 1),
(4, 'Primer Grado de Pimaria', 2),
(5, 'Segundo Grado de Pimaria', 2),
(6, 'Tercer Grado de Pimaria', 2),
(7, 'Cuarto Grado de Pimaria', 2),
(8, 'Quinto Grado de Pimaria', 2),
(9, 'Sexto Grado de Primaria', 2),
(10, 'Primer Grado de Secundaria', 3),
(11, 'Segundo Grado de Secundaria', 3),
(12, 'Tercer Grado de Secundaria', 3),
(13, 'Cuarto Grado de Secundaria', 3),
(14, 'Quinto Grado de Secundaria', 3);