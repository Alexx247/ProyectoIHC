<!DOCTYPE html>
<html lang="es">

<head>
  <title>Alumnos - Gestion de Inventario</title>
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
      <a class="nav-link active" href="Inicio.php">
        <img src="img/inicio-foto.png" alt="Icono Inicio">
        Inicio
      </a>
      <a class="nav-link" href="Inventario.php">
        <img src="img/inventario-foto.png" alt="Icono Inventario">
        Inventario
      </a>
      <a class="nav-link" href="Alumnos.php" style="color: #0066cc;">
        <img src="img/alumnos-azul.png" alt="Icono Alumnos">
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
      Bienvenido a la gestión de Alumnos.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Formulario de Registro de Alumnos -->
    <h2>Registro de Alumnos</h2>
    <form>
      <div class="mb-3">
        <label for="numeroControl" class="form-label">N° Control</label>
        <input type="text" class="form-control" id="numeroControl" placeholder="Ingrese el número de control">
      </div>
      <div class="mb-3">
        <label for="nombres" class="form-label">Nombres</label>
        <input type="text" class="form-control" id="nombres" placeholder="Ingrese los nombres">
      </div>
      <div class="mb-3">
        <label for="apellidoPaterno" class="form-label">Apellido Paterno</label>
        <input type="text" class="form-control" id="apellidoPaterno" placeholder="Ingrese el apellido paterno">
      </div>
      <div class="mb-3">
        <label for="apellidoMaterno" class="form-label">Apellido Materno</label>
        <input type="text" class="form-control" id="apellidoMaterno" placeholder="Ingrese el apellido materno">
      </div>
      <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="text" class="form-control" id="telefono" placeholder="Ingrese el teléfono">
      </div>
      <div class="mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <input type="text" class="form-control" id="direccion" placeholder="Ingrese la dirección">
      </div>
      <div class="btn-group">
        <button type="button" class="btn btn-primary">Agregar</button>
        <button type="button" class="btn btn-warning">Editar</button>
        <button type="button" class="btn btn-danger">Eliminar</button>
      </div>
    </form>

    <!-- Tabla de Datos -->
    <h3>Lista de Alumnos</h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>N° Control</th>
          <th>Nombres</th>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Teléfono</th>
          <th>Dirección</th>
        </tr>
      </thead>
      <tbody>
        <!-- Ejemplo de datos; se deberá rellenar con datos dinámicos de la base de datos -->
        <tr>
          <td>20221001</td>
          <td>Juan</td>
          <td>Pérez</td>
          <td>García</td>
          <td>555-1234</td>
          <td>Calle 1, Col. Centro</td>
        </tr>
        <tr>
          <td>20231002</td>
          <td>Ana</td>
          <td>Lopez</td>
          <td>Hernandez</td>
          <td>555-5678</td>
          <td>Calle 2, Col. Norte</td>
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