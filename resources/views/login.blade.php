<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>SISTEMA DE NOTAS Y MATRICULAS</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/login/css/login.css">
    <link rel="stylesheet" href="/login/css/style.css">
    <link rel="icon" type="image/x-icon" href="/insignia.png">

</head>

<body class="login" style="background-color: #16191C;">
    <section>
        <div class="row g-0">
            <div class="col-lg-6 d-none d-lg-block">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner d-flex align-items-end">
                        <div class="carousel-item active">
                            <img src="{{ asset('/login/img/img2.jpg') }}" class="d-block m-auto img-fluid w-100 h-auto" alt="">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="font-weight-bold">Sistema de matrículas y notas</h5>
                            </div>
                        </div>
                        <div class="carousel-item img-2 min-vh-100">
                            <img src="{{ asset('/login/img/img1.jpg') }}" class="d-block m-auto img-fluid w-100 h-auto" alt="">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class font-weight-bold">Ing. Requerimientos</h5>
                            </div>
                        </div>

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                </div>
            </div>
            <div style="background-color: #16191C; color: white;" class="col-lg-6 d-flex flex-column align-items-end min-vh-100">

                <div class="align-self-center w-100 px-lg-5 py-lg-4 p-4">
                    <div class="logo">
                        <img src="{{asset('/login/img/verificar.png')}}" width="15%" class="d-block  m-auto" alt="Sistema de Ventas & ABC">
                    </div>
                    <h1 class="font-weight-bold mb-4 text-center">BIENVENIDO</h1>
                    <h2 class="font-weight-bold mb-4 text-center">SISTEMA DE NOTAS Y MATRICULAS</h2>
                    <h4 class="font-weight-bold mb-4 text-center">Inicio de sesión</h4>
                    <form class="mb-5" method="POST" action="{{ route('identificacion') }}">
                        @csrf
                        <div class="mb-4 form-group">
                            <label class="control-label" for="exampleInputEmail1" class="form-label font-weight-bold">Usuario</label>
                            <div class="input-icon">
                                <i class="fas fa-user"></i>
                                <input class="bg-dark-x border-0 form-control @error('name') is-invalid @enderror" type="text" placeholder="Ingrese usuario" id="name" name="name" value="{{old('name')}}" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputPassword1" class="form-label font-weight-bold">Contraseña</label>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                                <input class=" bg-dark-x border-0 mb-2 form-control @error('password') is-invalid @enderror" type="password" placeholder="Ingrese contraseña" id="password" name="password" value="{{old('password')}}" />
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-primary w-100">
                                Iniciar sesión </button>
                        </div>
                    </form>


                </div>

            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</body>


<body class="login">

    
   
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/adminlte/dist/js/adminlte.min.js"></script>

</body>

</html>