<?php
include 'verificar_sesion.php';
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
            <a class="nav-link" href="Prestamos_admin.php" style="color: #0066cc;">
                <img src="img/prestamos-azul.png" alt="Icono Préstamos">
                Préstamos
            </a>
            <a class="nav-link" href="Estadisticas.php">
                <img src="img/estadisticas_foto.png" alt="Icono estadisticas">
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
      Bienvenido a la gestión de préstamos.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Formulario de Búsqueda de Dispositivos Prestados -->
    <h2>Búsqueda de préstamos</h2>
    <form>
      <div class="mb-3">
        <label for="idDispositivo" class="form-label">ID del dispositivo</label>
        <input type="text" class="form-control" id="idDispositivo" placeholder="Ingrese el ID del dispositivo">
      </div>
      <div class="mb-3">
        <label for="nombreDispositivo" class="form-label">Nombre del dispositivo</label>
        <input type="text" class="form-control" id="nombreDispositivo" placeholder="Ingrese el nombre del dispositivo">
      </div>
      <div class="mb-3">
        <label for="numeroControl" class="form-label">N° Control del alumno</label>
        <input type="text" class="form-control" id="numeroControl" placeholder="Ingrese el número de control">
      </div>
      <div class="btn-group">
        <button type="button" class="btn btn-primary">Buscar</button>
      </div>
    </form>

    <!-- Tabla de Datos de Préstamos -->
    <?php
    // Conexión a la base de datos
    $conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

    // Verificar conexión
    if ($conexion->connect_error) {
      die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta SQL para obtener los datos de la tabla registroprestamo
    $sql = "SELECT idDispositivo, numC, fechaSolicitud, fechaEntrega, aula FROM registroprestamo";
    $resultado = $conexion->query($sql);
    ?>

    <!-- Tabla de Datos -->
    <h3>Préstamos actuales</h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="text-center">ID dispositivo</th>
          <th class="text-center">N° Control Alumno</th>
          <th class="text-center">Fecha de Solicitud</th>
          <th class="text-center">Fecha Limite</th>
          <th class="text-center">Aula</th>
          <th class="text-center">Editar Préstamo</th>
          <th class="text-center">Eliminar Préstamo</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Verificar si hay resultados
        if ($resultado->num_rows > 0) {
          // Recorrer y mostrar los datos de cada fila
          while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='text-center'>" . $fila["idDispositivo"] . "</td>";
            echo "<td class='text-center'>" . $fila["numC"] . "</td>";
            echo "<td class='text-center'>" . $fila["fechaSolicitud"] . "</td>";
            echo "<td class='text-center'>" . $fila["fechaEntrega"] . "</td>";
            echo "<td class='text-center'>" . $fila["aula"] . "</td>";
            echo "<td class='text-center'>" . "<button class='btn btn-warning btn-sm' onclick=\"mostrarEditarModal('" . $fila["idDispositivo"] . "', '" . $fila["numC"] . "', '" . $fila["fechaSolicitud"] . "', '" . $fila["fechaEntrega"] . "', '" . $fila["aula"] . "')\">Editar</button> " . "</td>";
            echo "<td class='text-center'>" . "<button class='btn btn-danger btn-sm' onclick=\"eliminarPrestamo('" . $fila["idDispositivo"] . "')\">Eliminar</button>" . "</td>";
            echo "</tr>";
          }
        } else {
          // Mensaje si no hay datos
          echo "<tr><td colspan='6'>No hay préstamos registrados actualmente</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <?php
    // Cerrar la conexión a la base de datos
    $conexion->close();
    ?>

    <hr>
    <!-- Pie de Página -->
    <div class="footer">
      <p>&copy; 2024 - Instituto Tecnologico del Sur de Nayarit - Gestion de Inventario</p>
    </div>

</body>

</html>