<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, materialpro admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, materialpro admin lite design, materialpro admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Material Pro Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Sistema de Matriculas y Notas - Líderes</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/materialpro-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/x-icon" href="/insignia.jpg">
    <!-- chartist CSS -->
    <link href="/admintemplates/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="/admintemplates/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="/admintemplates/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="/admintemplates/plugins/c3-master/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/admintemplates/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js" integrity="sha512-j7/1CJweOskkQiS5RD9W8zhEG9D9vpgByNGxPIqkO5KrXrwyDAroM9aQ9w8J7oRqwxGyz429hPVk/zR6IOMtSA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        


    @yield('estilos')
</head>

<body>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contacto</a>
                </li>
                @php
                $periodoSeleccionado = session('periodoSeleccionado');
                @endphp


                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Período seleccionado: {{ $periodoSeleccionado }}</a>
                </li>

                
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Notas y matriculas

                </span>

            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
   
                <div class="user-panel mt-3 pb-3 mb-3 flex text-center">

                    <div class="info text-center float-center">
                        <a href="{{ route('home') }}" class="d-block text-center m-auto text-center">Centro preuniversitario Líderes</a>
                    </div>
                </div>





                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Maestros
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('periodo.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Periodos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tipociclo.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tipo ciclo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tipoexamen.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tipo examen</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('area.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Áreas</p>
                                    </a>
                                    <a href="{{ route('carrera.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Carreras</p>
                                    </a>
                                    
                                </li>

                                <li class="nav-item" hidden>
                                    <a href="{{ route('aulas.general') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Grados y secciones</p>
                                    </a>
                                </li>

                            </ul>

                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Ciclo
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ciclo.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ciclo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('aula.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Aulas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cursoos.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cursos</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Matricula
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item" hidden>
                                    <a href="{{ route('alumnos.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumnos</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('matriculas.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Matricular</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Notas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            
                            <ul class="nav nav-treeview">
                                
                                <li class="nav-item">
                                    <a href="{{ route('examen.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Examenes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('notaExamen.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Notas</p>
                                    </a>
                                </li>

                                <li class="nav-item" hidden>
                                    <a href="{{ route('capacidades.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Capacidades</p>
                                    </a>
                                </li>

                                
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Reportes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('notaExamen.reportes') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reportes</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('notaExamen.notasAlumno') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Notas por alumno</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Personal
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('docentes.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Profesores</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                       

                        <li class="nav-item" hidden>
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Mantenedor
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('catedra.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cátedra</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('docenteCurso.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>DocenteCurso</p>
                                    </a>
                                </li>
                          
                                <li class="nav-item">
                                    <a href="{{ route('notas.index') }}"class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Registrar notas</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('notas.ver') }}"class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Mostrar notas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('notas.reporte') }}"class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reporte notas</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('notas.boleta') }}"class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Boleta de notas</p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                    </ul>
                    <hr>
                    <div class="m-auto text-center d-flex justify-content-center form_container">
                        <div class="input-group mb-2">
                            <form class="m-auto" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn-danger btnblock m-auto" type="submit"><span>Salir </span><i class="fa fa-power-off" class="d-flex justify-content-center"></i></button>
                            </form>
                        </div>
                    </div>

                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header ">
                <div class="container-fluid ">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        </div>
                        
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('contenido')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="/admintemplates/plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="/admintemplates/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/admintemplates/js/app-style-switcher.js"></script>
    <!--Wave Effects -->
    <script src="/admintemplates/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="/admintemplates/js/sidebarmenu.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- chartist chart -->
    <script src="/admintemplates/plugins/chartist-js/dist/chartist.min.js"></script>
    <script src="/admintemplates/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 JavaScript -->
    <script src="/admintemplates/plugins/d3/d3.min.js"></script>
    <script src="/admintemplates/plugins/c3-master/c3.min.js"></script>
    <!--Custom JavaScript -->
    <script src="/admintemplates/js/pages/dashboards/dashboard1.js"></script>
    <script src="/admintemplates/js/custom.js"></script>
<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/adminlte/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/adminlte/dist/js/demo.js"></script>
    
    <script>
        setTimeout(function(){
            document.querySelector('#mensaje').remove();
        },3000);
    </script>

    @yield('script')

    <script src="/js/funciones.js"></script>

</body>

</html>