<!DOCTYPE html>
<html lang="es">
<head>
  <title>Gestion de Inventario</title>
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
</div>

<!-- Barra de Navegación Vertical -->
<div class="sidebar position-fixed">
  <nav class="nav flex-column">
    <a class="nav-link active" href="Inicio.php" style="color: #0066cc;">
      <img src="img/inicio-azul.png" alt="Icono Inicio">
      Inicio
    </a>
    <a class="nav-link" href="Inventario.php">
      <img src="img/inventario-foto.png" alt="Icono Inventario">
      Inventario
    </a>
    <a class="nav-link" href="Alumnos.php">
      <img src="img/alumnos-foto.png" alt="Icono Alumnos">
      Alumnos
    </a>
    <a class="nav-link" href="Prestamos.php">
      <img src="img/prestamos-foto.png" alt="Icono Préstamos">
      Préstamos
    </a>
  </nav>
</div>

<!-- Contenido Principal -->
<div class="main-content">
  <!-- Mensajes con botón de cierre -->
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Bienvenido al Sistema de Control de Inventario del ITSN. Aquí podrás gestionar los préstamos de equipos.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    Mantén la información actualizada para un mejor control.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

  <!-- Formulario de Registro de Préstamo -->
  <h2>Registro de préstamo</h2>
  <form id="prestamoForm">
      <div class="mb-3">
          <label for="idDispositivo" class="form-label">ID del dispositivo</label>
          <input type="text" class="form-control" id="idDispositivo" name="idDispositivo" placeholder="Ingrese el ID del dispositivo" required>
      </div>
      <div class="mb-3">
          <label for="numC" class="form-label">N° Control Alumno</label>
          <input type="text" class="form-control" id="numC" name="numC" placeholder="Ingrese el número de control" required>
      </div>
      <div class="mb-3">
          <label for="fechaSolicitud" class="form-label">Fecha de Solicitud</label>
          <input type="date" class="form-control" id="fechaSolicitud" name="fechaSolicitud" required>
      </div>
      <div class="mb-3">
          <label for="fechaEntrega" class="form-label">Fecha Limite</label>
          <input type="date" class="form-control" id="fechaEntrega" name="fechaEntrega" required>
      </div>
      <div class="mb-3">
          <label for="aula" class="form-label">Aula</label>
          <input type="text" class="form-control" id="aula" name="aula" placeholder="Ingrese el aula" required>
      </div>
      <div class="btn-group">
          <button type="button" class="btn btn-primary" onclick="enviarFormulario()">Solicitar</button>
      </div>
  </form>

  <!-- Modal para mostrar mensajes -->
  <div class="modal fade" id="resultadoModal" tabindex="-1" aria-labelledby="resultadoModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="resultadoModalLabel">Resultado</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body" id="modalMensaje">
                  <!-- Aquí se mostrará el mensaje de éxito o error -->
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
          </div>
      </div>
  </div>

  <script>
  // Función para enviar el formulario con AJAX
  function enviarFormulario() {
      const formData = new FormData(document.getElementById('prestamoForm'));

      fetch('insertar_prestamo.php', {
          method: 'POST',
          body: formData
      })
      .then(response => response.text())
      .then(data => {
          // Mostrar el mensaje en el cuerpo de la modal
          document.getElementById('modalMensaje').innerHTML = data;

          // Mostrar la modal de resultado
          new bootstrap.Modal(document.getElementById('resultadoModal')).show();

          // Limpiar el formulario después del envío
          document.getElementById('prestamoForm').reset();

          // Actualizar la tabla después de registrar el préstamo
          actualizarTabla();
      })
      .catch(error => {
          console.error('Error:', error);
      });
  }

  // Función para actualizar la tabla con los datos más recientes
  function actualizarTabla() {
      fetch('obtener_prestamos.php')
      .then(response => response.text())
      .then(data => {
          // Reemplazar el contenido de la tabla con los nuevos datos
          document.querySelector("table tbody").innerHTML = data;
      })
      .catch(error => {
          console.error('Error al actualizar la tabla:', error);
      });
  }
  </script>

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
              <th>ID dispositivo</th>
              <th>N° Control Alumno</th>
              <th>Fecha de Solicitud</th>
              <th>Fecha Limite</th>
              <th>Aula</th>
          </tr>
      </thead>
      <tbody>
          <?php
          // Verificar si hay resultados
          if ($resultado->num_rows > 0) {
              // Recorrer y mostrar los datos de cada fila
              while($fila = $resultado->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $fila["idDispositivo"] . "</td>";
                  echo "<td>" . $fila["numC"] . "</td>";
                  echo "<td>" . $fila["fechaSolicitud"] . "</td>";
                  echo "<td>" . $fila["fechaEntrega"] . "</td>";
                  echo "<td>" . $fila["aula"] . "</td>";
                  echo "</tr>";
              }
          } else {
              // Mensaje si no hay datos
              echo "<tr><td colspan='5'>No hay préstamos registrados actualmente</td></tr>";
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