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

// Cerrar la conexión
$conexion->close();
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <title>Prestamos - Gestion de Inventario</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css"> <!-- Enlace a styles.css -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
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
  <div class="row justify-content-center">
    <div class="col-md-6 text-center">
      <h3>Estadísticas de préstamos por carrera</h3>
      <canvas id="prestamosPorCarrera" width="500" height="500"></canvas>
      <button id="exportarPDF" class="btn btn-primary mt-3">Exportar a PDF</button>
    </div>
  </div>
</div>

                <script>
                var ctx = document.getElementById('prestamosPorCarrera').getContext('2d');
                var prestamosPorCarreraChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                    labels: <?php echo json_encode($carreras); ?>,
                    datasets: [{
                        label: 'Número de Préstamos',
                        data: <?php echo json_encode($prestamos); ?>,
                        backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 71, 0.2)',
                        'rgba(128, 0, 128, 0.2)'
                        ],
                        borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 71, 1)',
                        'rgba(128, 0, 128, 1)'
                        ],
                        borderWidth: 1
                    }]
                    },
                    options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                        position: 'top',
                        },
                        tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' préstamos';
                            }
                        }
                        }
                    }
                    }
                });

                // Script para exportar la gráfica a PDF
                document.getElementById('exportarPDF').addEventListener('click', function () {
                    var canvas = document.getElementById('prestamosPorCarrera');
                    var canvasImg = canvas.toDataURL('image/png', 1.0);

                    const { jsPDF } = window.jspdf;
                    const pdf = new jsPDF();

                    pdf.addImage(canvasImg, 'PNG', 15, 15, 180, 180);

                    pdf.save('grafica-prestamos.pdf');
                });
                </script>


    <!-- Pie de Página -->
    <div class="footer">
      <p>&copy; 2024 - Instituto Tecnologico del Sur de Nayarit - Gestion de Inventario</p>
    </div>

</body>

</html>