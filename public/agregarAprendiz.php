<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- head -->

<head>
    <?php include 'assets/config/head.php'; ?>

    <meta charset="UTF-8">
    <title>Tabla Aprendices</title>
    <style>
        .btn-observaciones {
            background-color: #6f42c1;
            color: white;
        }

        .btn-editar {
            background-color: #ffc107;
            color: black;
        }

        .btn-eliminar {
            background-color: #dc3545;
            color: white;
        }

        .container {
            margin-top: 250px;
        }
    </style>
</head>
<!-- fin head -->

<body class="index-page">

    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <div class="profile-img">
            <img src="assets/img/yo.jpg" alt="" class="img-fluid rounded-circle">
        </div>

        <a href="index.html" class="logo d-flex align-items-center justify-content-center">
            <h1 class="sitename">Luis Felipe</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php" class="active"><i class="bi bi-house navicon"></i>Inicio</a></li>
                <li><a href="perfil.php"><i class="bi bi-person navicon"></i>Perfil</a></li>
                <li><a href="calendario.php"><i class="bi bi-file-earmark-text navicon"></i>Calendario</a></li>
                <li><a href="agregarAprendiz.php"><i class="bi bi-person-fill-add"></i>&nbsp;&nbsp;&nbsp;Agregar Aprendiz</a></li>
            </ul>
        </nav>
    </header>
    <!-- fin header -->

    <!-- main -->
    <main class="main">
        <div class="container mt-5">
            <!-- Agregar aprendiz -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark bi bi-person-fill-add" data-bs-toggle="modal" data-bs-target="#modalAprendiz">
                        Agregar Aprendiz
                    </button>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Seleccionar Ficha
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Seleccionar ficha</a></li>
                        </ul>
                    </div>
                </div>

                <div class="input-group w-25">
                    <input type="text" class="form-control" placeholder="Buscar">
                    <button class="btn btn-secondary"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo Documento</th>
                            <th>N. Documento</th>
                            <th>Email</th>
                            <th>Género</th>
                            <th>Peso</th>
                            <th colspan="3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button class="btn btn-sm btn-observaciones">Observaciones</button></td>
                            <td><button class="btn btn-sm btn-editar">Editar</button></td>
                            <td><button class="btn btn-sm btn-eliminar">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para agregar a los aprendices -->
        <div class="modal fade" id="modalAprendiz" tabindex="-1" aria-labelledby="modalAprendizLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAprendizLabel">Agregar Aprendiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Documento</label>
                                    <select class="form-select">
                                        <option selected>Seleccionar</option>
                                        <option value="CC">Cédula de ciudadanía</option>
                                        <option value="TI">Tarjeta de identidad</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Número de Documento</label>
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Género</label>
                                    <select class="form-select">
                                        <option selected>Seleccionar</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Peso</label>
                                    <input type="number" class="form-control" placeholder="kg">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <body class="d-flex flex-column min-vh-100">

        <main class="flex-grow-1">
            <!-- Aquí va todo el contenido -->
        </main>

        <body class="d-flex flex-column min-vh-100">

            <main class="flex-grow-1">
                <!-- Aquí va todo el contenido -->
            </main>

            <footer id="footer" class="footer position-relative light-background">
                <div class="container">
                    <div class="copyright text-center">
                        <p>
                            © <span>Copyright</span>
                            <strong class="px-1 sitename">SenGym</strong>
                            <span>All Rights Reserved</span>
                        </p>
                    </div>
                    <div class="credits text-center">
                        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                        Distributed by <a href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </footer>

        </body>

    </body>
    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->

    <!-- Preloader -->

    <!-- Vendor JS Files -->
    <?php include 'assets/config/scripts.php'; ?>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- js calendario -->
    <script src="assets/js/js.js"></script>

</body>

</html>
</body>

</html>