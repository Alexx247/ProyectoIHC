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
  <form>
    <div class="mb-3">
      <label for="idDispositivo" class="form-label">ID del dispositivo</label>
      <input type="text" class="form-control" id="idDispositivo" placeholder="Ingrese el ID del dispositivo">
    </div>
    <div class="mb-3">
      <label for="numeroControl" class="form-label">N° Control Alumno</label>
      <input type="text" class="form-control" id="numeroControl" placeholder="Ingrese el número de control">
    </div>
    <div class="mb-3">
      <label for="fechaSolicitud" class="form-label">Fecha de Solicitud</label>
      <input type="date" class="form-control" id="fechaSolicitud">
    </div>
    <div class="mb-3">
      <label for="fechaFin" class="form-label">Fecha Limite</label>
      <input type="date" class="form-control" id="fechaFin">
    </div>
    <div class="mb-3">
      <label for="aula" class="form-label">Aula</label>
      <input type="text" class="form-control" id="aula" placeholder="Ingrese el aula">
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-primary">Solicitar</button>
      <button type="button" class="btn btn-danger">Devolver</button>
    </div>
  </form>

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
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
      <!-- Ejemplo de datos; se deberá rellenar con datos dinámicos de la base de datos -->
      <tr>
        <td>12345</td>
        <td>20221001</td>
        <td>2024-11-04</td>
        <td>2024-11-06</td>
        <td>Aula 101</td>
        <td>Pendiente</td>
      </tr>
      <tr>
        <td>67890</td>
        <td>20231002</td>
        <td>2024-11-03</td>
        <td>2024-11-07</td>
        <td>Aula 202</td>
        <td>Devuelto</td>
      </tr>
    </tbody>
  </table>
</div>

<!-- Pie de Página -->
<div class="footer">
  <p>&copy; 2024 - Instituto Tecnologico del Sur de Nayarit - Gestion de Inventario</p>
</div>

</body>
</html>