<!DOCTYPE html>
<html lang="es">

<head>
  <title>Inventario - Gestion de Inventario</title>
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
      <a class="nav-link" href="Inventario.php" style="color: #0066cc;">
        <img src="img/inventario-azul.png" alt="Icono Inventario">
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
    <h2>Gestión de dispositivos</h2>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      Aquí puedes agregar, editar o eliminar dispositivos del inventario.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Formulario de Registro de Dispositivo -->
    <form>
      <div class="mb-3">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" class="form-control" id="codigo" placeholder="Ingrese el código del dispositivo">
      </div>
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre del dispositivo">
      </div>
      <div class="mb-3">
        <label for="marca" class="form-label">Marca</label>
        <input type="text" class="form-control" id="marca" placeholder="Ingrese la marca del dispositivo">
      </div>
      <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select class="form-select" id="estado">
          <option value="Disponible">Disponible</option>
          <option value="En préstamo">En préstamo</option>
          <option value="Fuera de servicio">Fuera de servicio</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" placeholder="Ingrese una descripción"></textarea>
      </div>
      <!-- Botones -->
      <div class="btn-group">
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </form>

    <!-- Tabla de Datos -->
    <h3>Dispositivos Registrados</h3>
  </div>

  <!-- Pie de Página -->
  <div class="footer">
    <p>&copy; 2024 - Instituto Tecnologico del Sur de Nayarit - Gestion de Inventario</p>
  </div>

</body>

</html>