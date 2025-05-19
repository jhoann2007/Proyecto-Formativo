<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- head -->
<head>
    <?php include 'assets/config/head.php'; ?>

    <meta charset="UTF-8">
    <title>Gestión de Entrenadores</title>
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
            margin-top: 100px;
        }
    </style>
</head>
<!-- fin head -->

<body class="index-page">

    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <div class="profile-img">
            <img src="assets/img/negrito.jpg" alt="" class="img-fluid rounded-circle">
        </div>

        <a href="index.html" class="logo d-flex align-items-center justify-content-center">
            <h1 class="sitename">Fernando</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="/inicio"><i class="bi bi-house navicon"></i>Inicio</a></li>
                <li><a href="/perfil"><i class="bi bi-person navicon"></i>Perfil</a></li>
                <li><a href="/calendario"><i class="bi bi-file-earmark-text navicon"></i>Calendario</a></li>
                <li><a href="/agregarAprendiz"><i class="bi bi-person-fill-add"></i>&nbsp;&nbsp;&nbsp;Agregar Aprendiz</a></li>
                <li><a href="/agregarEntrenador" class="active"><i class="bi bi-person-fill-add"></i>&nbsp;&nbsp;&nbsp;Agregar Entrenador</a></li>
            </ul>
        </nav>
    </header>
    <!-- fin header -->

    <!-- main -->
    <main class="main">
        <div class="container mt-5">
            <!-- Agregar entrenador -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark bi bi-person-fill-add" data-bs-toggle="modal" data-bs-target="#modalEntrenador">
                        Agregar Entrenador
                    </button>
                </div>

                <div class="input-group w-25">
                    <input type="text" class="form-control" placeholder="Buscar" id="searchInput">
                    <button class="btn btn-secondary"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <?php include_once $content; ?>
        </div>
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <div class="container">
            <div class="copyright text-center">
                <p>
                    © <span>Copyright</span>
                    <strong class="px-1 sitename">GymTech SENA</strong>
                    <span>All Rights Reserved</span>
                </p>
            </div>
            <div class="credits text-center">
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                Distributed by <a href="https://themewagon.com">ThemeWagon</a>
            </div>
        </div>
    </footer>

    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->

    <!-- Vendor JS Files -->
    <?php include 'assets/config/scripts.php'; ?>

    <!-- Main JS File -->
    <script src="../../../public/js/main.js"></script>

    <!-- js calendario -->
    <script src="../../../public/js/js.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Búsqueda en tabla -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Búsqueda en tabla
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    filterTable(searchTerm);
                });
            }
            
            // Función para filtrar por búsqueda
            function filterTable(searchTerm) {
                const tableRows = document.querySelectorAll('tbody tr');
                
                tableRows.forEach(row => {
                    if (!row.classList.contains('no-data')) {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
                
                checkNoResults();
            }
            
            // Verificar si hay resultados visibles
            function checkNoResults() {
                const tableRows = document.querySelectorAll('tbody tr');
                const tbody = document.querySelector('tbody');
                let visibleRows = 0;
                
                tableRows.forEach(row => {
                    if (row.style.display !== 'none' && !row.classList.contains('no-data')) {
                        visibleRows++;
                    }
                });
                
                // Eliminar mensaje de no resultados si existe
                const noResultsRow = document.querySelector('.no-results');
                if (noResultsRow) {
                    noResultsRow.remove();
                }
                
                // Mostrar mensaje si no hay resultados
                if (visibleRows === 0) {
                    const noResultsRow = document.createElement('tr');
                    noResultsRow.className = 'no-results';
                    noResultsRow.innerHTML = '<td colspan="7" class="text-center">No se encontraron entrenadores con los criterios de búsqueda</td>';
                    tbody.appendChild(noResultsRow);
                }
            }
        });
    </script>
</body>
</html>