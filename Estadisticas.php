<?php
include 'verificar_sesion.php';

include 'Conexion.php';

// Consulta SQL para obtener los préstamos y las carreras de los alumnos
$sql = "
    SELECT a.carrera, COUNT(rp.idDispositivo) AS numPrestamos
    FROM registroprestamo rp
    JOIN alumnos a ON rp.numC = a.numControl
    GROUP BY a.carrera
    ORDER BY numPrestamos DESC
";
$resultado = $conexion->query($sql);

// Inicializar los arrays para las etiquetas y los datos de la gráfica
$carreras = [];
$prestamos = [];

// Llenar los arrays con los datos de la consulta
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $carreras[] = $fila["carrera"];
        $prestamos[] = $fila["numPrestamos"];
    }
}
// Segunda consulta: alumnos por carrera
$sqlAlumnos = "
    SELECT carrera, COUNT(numControl) AS numAlumnos
    FROM alumnos
    GROUP BY carrera
    ORDER BY numAlumnos DESC
";
$resultadoAlumnos = $conexion->query($sqlAlumnos);

// Inicializar arrays para alumnos
$carrerasAlumnos = [];
$numAlumnos = [];

// Llenar arrays de alumnos
if ($resultadoAlumnos->num_rows > 0) {
    while ($fila = $resultadoAlumnos->fetch_assoc()) {
        $carrerasAlumnos[] = $fila["carrera"];
        $numAlumnos[] = $fila["numAlumnos"];
    }
}

// Cerrar la conexión
$conexion->close();
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <title>Estadisticas - Gestion de Inventario</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css"> <!-- Enlace a styles.css -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script><!-- Para exportar la grafica -->
</head>

<body>

  <!-- Encabezado -->
  <div class="header">
    <h1>Control de Inventario</h1>
    <p>Gestión y control de equipos de manera eficiente</p>
    <img src="img/TecSurNay.png" alt="Logo ITSN" style="position: absolute; top: 10px; right: 10px; width: 150px;">
  </div>

  <!-- Barra de Navegación Vertical -->
  <div class="sidebar position-fixed">
        <nav class="nav flex-column">
            <a class="nav-link active" href="inicio_admin.php" >
                <img src="img/inicio-foto.png" alt="Icono Inicio">
                Inicio
            </a>
            <a class="nav-link" href="Inventario_admin.php">
                <img src="img/inventario-foto.png" alt="Icono Inventario">
                Inventario
            </a>
            <a class="nav-link" href="Alumnos_admin.php">
                <img src="img/alumnos-foto.png" alt="Icono Alumnos">
                Alumnos
            </a>
            <a class="nav-link" href="Prestamos_admin.php" >
                <img src="img/prestamos-foto.png" alt="Icono Préstamos">
                Préstamos
            </a>
            <a class="nav-link" href="Estadisticas.php" style="color: #0066cc;">
                <img src="img/estadisticas-azul.png" alt="Icono estadisticas">
                Estadísticas
            </a>
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <img src="img/salir-foto.png" alt="Icono Cerrar Sesión">
            Cerrar Sesión
        </a>
        </nav>
    </div>
<!-- Modal de Confirmación de Cerrar Sesión -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Cerrar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas cerrar sesión?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="cerrar_sesion.php" class="btn btn-danger">Sí, cerrar sesión</a>
            </div>
        </div>
    </div>
</div>
  <!-- Contenido Principal -->
  <div class="main-content">
    <!-- Mensajes con botón de cierre -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Bienvenido a la gestión de estadísticas.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
   
    <div class="container mt-5">
        <!-- Gráfica 2D -->
        <div class="row justify-content-center">
            <div class="col-md-6 text-start">
                <h3>Estadísticas de préstamos por carrera</h3>
                <div id="piechart_2d" style="width: 100%; height: 500px;"></div>
                <div class="text-center"><button id="exportarPDF1" class="btn btn-primary mt-3">Exportar Gráfica</button></div>
            </div>
        </div>

        <!-- Gráfica 3D -->
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 text-start">
                <h3>Estadísticas de alumnos por carrera</h3>
                <div id="piechart_3d" style="width: 100%; height: 500px;"></div>
                <div class="d-flex justify-content-center mt-3">
                <button id="exportarPDF2" class="btn btn-primary mt-3">Exportar Gráfica</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // Gráfica 2D: Préstamos por Carrera
            var dataPrestamos = google.visualization.arrayToDataTable([
                ['Carrera', 'Número de Préstamos'],
                <?php
                for ($i = 0; $i < count($carreras); $i++) {
                    echo "['" . $carreras[$i] . "', " . $prestamos[$i] . "]";
                    if ($i < count($carreras) - 1) echo ",";
                }
                ?>
            ]);

            var optionsPrestamos = {
                title: '',
                chartArea: { width: '90%', height: '80%' },
            };

            var chartPrestamos = new google.visualization.PieChart(document.getElementById('piechart_2d'));
            chartPrestamos.draw(dataPrestamos, optionsPrestamos);

            // Botón para exportar la gráfica 2D a PDF
            document.getElementById('exportarPDF1').addEventListener('click', function () {
                exportarGrafica(chartPrestamos, 'grafica-prestamos.pdf');
            });

            // Gráfica 3D: Alumnos por Carrera
            var dataAlumnos = google.visualization.arrayToDataTable([
                ['Carrera', 'Número de Alumnos'],
                <?php
                for ($i = 0; $i < count($carrerasAlumnos); $i++) {
                    echo "['" . $carrerasAlumnos[$i] . "', " . $numAlumnos[$i] . "]";
                    if ($i < count($carrerasAlumnos) - 1) echo ",";
                }
                ?>
            ]);

            var optionsAlumnos = {
                title: '',
                is3D: true,
                chartArea: { width: '90%', height: '80%' }
            };

            var chartAlumnos = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chartAlumnos.draw(dataAlumnos, optionsAlumnos);

            // Botón para exportar la gráfica 3D a PDF
            document.getElementById('exportarPDF2').addEventListener('click', function () {
                exportarGrafica(chartAlumnos, 'grafica-alumnos.pdf');
            });
        }

        // Función para exportar gráficos a PDF
        function exportarGrafica(chart, fileName) {
            const uri = chart.getImageURI();
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF();
            pdf.addImage(uri, 'PNG', 15, 40, 180, 160);
            pdf.save(fileName);
        }
    </script>
    <!-- Pie de Página -->
    <div class="footer">
      <p>&copy; 2024 - Instituto Tecnologico del Sur de Nayarit - Gestion de Inventario</p>
    </div>

</body>

</html>