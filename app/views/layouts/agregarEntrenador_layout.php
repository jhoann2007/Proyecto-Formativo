<?php 
// Iniciar la sesión AL PRINCIPIO de todo
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- head -->
<head>
    <?php 
    // session_start(); // Movido arriba
    include 'assets/config/head.php'; 
    ?>

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
            margin-top: 100px; /* Esto podría necesitar ajuste si el header es fixed/sticky */
        }
    </style>
</head>
<!-- fin head -->

<body class="index-page">

    <!-- header -->
    <header id="header" class="header dark-background d-flex flex-column">
        <div class="profile-img">
            <img src="assets/img/gigachad.png" alt="" class="img-fluid rounded-circle">
        </div>

        <a href="index.html" class="logo d-flex align-items-center justify-content-center">
            <h1 class="sitename">GigaChad</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="/inicio"><i class="bi bi-house navicon"></i>Inicio</a></li>
                <li><a href="/perfil"><i class="bi bi-person navicon"></i>Perfil</a></li>
                <li><a href="/calendario"><i class="bi bi-file-earmark-text navicon"></i>Calendario</a></li>
                <?php
                // Asegurarse de que 'user_rol_nombre' existe para evitar notices,
                // aunque tu script de login ya lo convierte a minúsculas y establece 'desconocido' por defecto.
                $rolUsuario = $_SESSION['user_rol_nombre'] ?? 'desconocido'; 

                // Corregido: switch en lugar de witch
                switch ($rolUsuario) {
                    case 'admin':
                        echo "
                        <li><a href='/agregarAprendiz' class='active'><i class='bi bi-person-fill-add'></i>   Agregar Aprendiz</a></li>
                        <li><a href='/agregarEntrenador' class='active'><i class='bi bi-person-fill-add'></i>   Agregar Entrenador</a></li>
                        ";
                        break;
                    case 'entrenador': 
                        echo "
                        <li><a href='/agregarAprendiz' class='active'><i class='bi bi-person-fill-add'></i>   Agregar Aprendiz</a></li>
                        ";
                        break;
                    // Opcional: un caso por defecto si quieres manejar roles no esperados
                    // default:
                    //     // No mostrar nada extra o mostrar un mensaje
                    //     break;
                }
                ?>
            </ul>
        </nav>
    </header>
    <!-- fin header -->

    <!-- main -->
    <main class="main">
        <div class="container mt-5"> {/* Considera si este mt-5 es suficiente con el header. Si el header es sticky o fixed, el contenido podría quedar debajo. */}
            <!-- Agregar Entrenador -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark bi bi-person-fill-add" data-bs-toggle="modal" data-bs-target="#modalEntrenador">
                        Agregar Entrenador
                    </button>

                    
                    <div id="ficha-seleccionada" class="d-flex align-items-center ms-3 text-muted"></div>
                </div>

                <div class="input-group w-25">
                    <input type="text" class="form-control" placeholder="Buscar" id="searchInput">
                    <button class="btn btn-secondary"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <?php 
            // Verificar si $content está definido antes de incluirlo para evitar errores
            if (isset($content) && file_exists($content)) {
                include_once $content; 
            } else {
                // Opcional: mostrar un mensaje si $content no está definido o el archivo no existe
                // echo "<p>Contenido no disponible.</p>";
            }
            ?>
        </div>
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

    <!-- Scroll -->
    <?php include 'assets/config/scroll.php'; ?>
    <!-- fin Scroll -->

    <!-- Vendor JS Files -->
    <?php include 'assets/config/scripts.php'; ?>

    <!-- Main JS File -->
    <script src="../../../public/js/main.js"></script>

    <!-- js calendario -->
    <script src="../../../public/js/js.js"></script>
    <script src="assets/js/main.js"></script> {/* Cuidado con rutas relativas como esta, asegúrate que 'assets/js/main.js' es correcto en el contexto de esta página */}

    <!-- Búsqueda en tabla y filtrado por ficha -->
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
            
            // Filtrado por ficha
            const fichaLinks = document.querySelectorAll('.ficha-filter');
            const fichaSeleccionadaText = document.getElementById('ficha-seleccionada');
            
            if (fichaSeleccionadaText) { // Verificar que el elemento existe
                fichaLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const fichaId = this.getAttribute('data-ficha');
                        const fichaNombre = this.getAttribute('data-ficha-nombre');
                        
                        // Actualizar texto de ficha seleccionada
                        if (fichaId === 'todas') {
                            fichaSeleccionadaText.textContent = '';
                            filterByFicha('todas');
                        } else {
                            fichaSeleccionadaText.textContent = 'Ficha: ' + fichaNombre;
                            filterByFicha(fichaId);
                        }
                    });
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
            
            // Función para filtrar por ficha
            function filterByFicha(fichaId) {
                const tableRows = document.querySelectorAll('tbody tr');
                
                tableRows.forEach(row => {
                    if (!row.classList.contains('no-data')) {
                        if (fichaId === 'todas') {
                            row.style.display = '';
                        } else {
                            const fichaCell = row.getAttribute('data-ficha');
                            if (fichaCell === fichaId) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    }
                });
                
                checkNoResults();
            }
            
            // Verificar si hay resultados visibles
            function checkNoResults() {
                const tbody = document.querySelector('tbody');
                if (!tbody) return; // Salir si no hay tbody

                const tableRows = tbody.querySelectorAll('tr');
                let visibleRows = 0;
                
                tableRows.forEach(row => {
                    if (row.style.display !== 'none' && !row.classList.contains('no-data') && !row.classList.contains('no-results')) {
                        visibleRows++;
                    }
                });
                
                // Eliminar mensaje de no resultados si existe
                const noResultsRow = tbody.querySelector('.no-results');
                if (noResultsRow) {
                    noResultsRow.remove();
                }
                
                // Mostrar mensaje si no hay resultados y hay un tbody para añadirlo
                if (visibleRows === 0) {
                    const newNoResultsRow = document.createElement('tr');
                    newNoResultsRow.className = 'no-results';
                    // Ajustar el colspan al número de columnas de tu tabla
                    const numColumns = tbody.querySelector('tr:not(.no-results):not(.no-data)')?.cells.length || 9; // Intenta obtener el número de columnas, default 9
                    newNoResultsRow.innerHTML = `<td colspan="${numColumns}" class="text-center">No se encontraron resultados con los criterios de búsqueda</td>`;
                    tbody.appendChild(newNoResultsRow);
                }
            }
        });
    </script>
</body>
</html>