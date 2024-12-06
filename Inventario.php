<?php
include 'verificar_sesion.php';
?>
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
      <a class="nav-link active" href="inicio_usuario.php">
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
      <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <img src="img/salir-foto.png" alt="Icono Cerrar Sesión">
            Cerrar Sesión
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
    <form id="dispositivoForm">
      <div class="mb-3">
        <label for="idDispositivo" class="form-label">Código</label>
        <input type="text" class="form-control" id="idDispositivo" name="idDispositivo" placeholder="Ingrese el código del dispositivo">
      </div>
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del dispositivo">
      </div>
      <div class="mb-3">
        <label for="marca" class="form-label">Marca</label>
        <input type="text" class="form-control" id="marca"  name="marca" placeholder="Ingrese la marca del dispositivo">
      </div>
      <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select class="form-select" id="estado" name="estado" >
        <option value="">Seleccione una estado</option>
          <option value="Disponible">Disponible</option>
          <option value="Fuera de servicio">Fuera de servicio</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion"  name="descripcion" placeholder="Ingrese una descripción"></textarea>
      </div>
      <!-- Botones -->
      <div class="btn-group">
        <button type="button" class="btn btn-primary" onclick="enviarFormulario()">Guardar</button>
      </div>
    </form>
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
 <!-- Modal para mostrar mensaje de guardado exitoso -->
 <div class="modal fade" id="resultadoModal" tabindex="-1" aria-labelledby="resultadoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabel">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="modalMensajeGuardar">
                        Se ha guardado el dispositivo correctamente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar un dispositivo -->
        <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Dispositivo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editarDispositivoForm">
                            <input type="hidden" id="editIdDispositivo" name="idDispositivo">
                            <div class="mb-3">
                                <label for="editNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="editMarca" class="form-label">Marca</label>
                                <input type="text" class="form-control" id="editMarca" name="marca" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEstado" class="form-label">Estado</label>
                                <select class="form-select" id="editEstado" name="estado" required>
                                <option value="Disponible">Disponible</option>
                                <option value="En préstamo">En préstamo</option>
                                <option value="Fuera de servicio">Fuera de servicio</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editDescripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="editDescripcion" name="descripcion" rows="3"></textarea>
                            </div>
                            <button type="button" class="btn btn-success" onclick="actualizarDispositivo()">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de borrado exitosamente -->
        <div class="modal fade" id="resultadoModalBorrar" tabindex="-1" aria-labelledby="resultadoModalLabelBorrar"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabelBorrar">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="modalMensajeBorrar">
                        Se ha borrado el dispositivo correctamente!!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de Confirmación de Eliminación -->
        <div class="modal fade" id="confirmarEliminacionModal" tabindex="-1" aria-labelledby="confirmarEliminacionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmarEliminacionModalLabel">Confirmación de Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar este dispositivo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Sí, Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
         <!-- Modal para mostrar mensaje de se edito exitosamente el alumno -->
         <div class="modal fade" id="resultadoModalEditar" tabindex="-1" aria-labelledby="resultadoModalLabelEditar"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabelEditar">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="modalMensajeEditar">
                        Se ha actualizado correctamente!!
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
                const idDispositivo = document.getElementById('idDispositivo').value.trim();
                const nombre = document.getElementById('nombre').value.trim();
                const marca = document.getElementById('marca').value.trim();
                const estado = document.getElementById('estado').value;

                if (!idDispositivo || !nombre || !marca || estado === "") {
                    alert("Por favor, complete los campos obligatorios: ID Dispositivo, Nombre, Marca y Estado.");
                    return;
                }

                const formData = new FormData(document.getElementById('dispositivoForm'));

                fetch('insertar_dispositivo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modalMensajeGuardar').innerHTML = data;
                    new bootstrap.Modal(document.getElementById('resultadoModal')).show();
                    document.getElementById('dispositivoForm').reset();
                    actualizarTabla();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            // Función para actualizar la tabla con los datos más recientes
            function actualizarTabla() {
                fetch('obtener_dispositivos.php')
                .then(response => response.text())
                .then(data => {
                    document.querySelector("table tbody").innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al actualizar la tabla:', error);
                });
            }

            // Función para mostrar el modal de edición
            function mostrarEditarModal(idDispositivo, nombre, marca, estado, descripcion) {
                document.getElementById('editIdDispositivo').value = idDispositivo;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editMarca').value = marca;
                document.getElementById('editEstado').value = estado;
                document.getElementById('editDescripcion').value = descripcion;
                new bootstrap.Modal(document.getElementById('editarModal')).show();
            }

            // Función para actualizar un dispositivo
                function actualizarDispositivo() {
                const formData = new FormData(document.getElementById('editarDispositivoForm'));
                fetch('actualizar_dispositivo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modalMensajeEditar').innerHTML = data;
                    new bootstrap.Modal(document.getElementById('resultadoModalEditar')).show();
                    if (data.includes('actualizado correctamente')) {
                        var editarModal = bootstrap.Modal.getInstance(document.getElementById('editarModal'));
                        editarModal.hide();  // Cerrar el modal de edición
                        actualizarTabla();  // Llamar a la función para actualizar la tabla
                    }
                })
                .catch(error => console.error('Error:', error));
            }


            

            // Función para mostrar el modal de edición
            function mostrarEditarModal(idDispositivo, nombre, marca, estado, descripcion) {
                document.getElementById('editIdDispositivo').value = idDispositivo;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editMarca').value = marca;
                document.getElementById('editEstado').value = estado;
                document.getElementById('editDescripcion').value = descripcion;
                new bootstrap.Modal(document.getElementById('editarModal')).show();
            }

          
              // Función para mostrar el modal de confirmación de eliminación
              function eliminarDispositivo(idDispositivo) {
                // Asignar el N.C al botón de confirmar eliminación
                document.getElementById('confirmarEliminarBtn').onclick = function (event) {
                    event.preventDefault(); // Prevenir la acción predeterminada del botón (evitar recarga de la página)

                    // Llamar a la función para eliminar el préstamo
                    eliminarDispositivoConfirmado(idDispositivo);
                };
                // Mostrar el modal de confirmación
                new bootstrap.Modal(document.getElementById('confirmarEliminacionModal')).show();
            }

            // Función para eliminar el registro de la base de datos
            function eliminarDispositivoConfirmado(idDispositivo) {
                // Enviar la solicitud AJAX para eliminar el alumno
                fetch('eliminar_dispositivo.php', {
                    method: 'POST',
                    body: JSON.stringify({ idDispositivo: idDispositivo }), // Enviar los datos como JSON
                    headers: {
                        'Content-Type': 'application/json', // Especificar el tipo de contenido
                    },
                })
                    .then(response => response.text())
                    .then(data => {
                        // Mostrar el mensaje de éxito o error
                        //alert(data);

                        // Mostrar el popup de "Se eliminó correctamente"
                        document.getElementById('modalMensajeBorrar').innerHTML = data;

                        // Mostrar la modal de resultado
                        new bootstrap.Modal(document.getElementById('resultadoModalBorrar')).show();

                        // Actualizar la tabla de registros después de la eliminación
                        actualizarTabla();

                        // Cerrar el modal de confirmación
                        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmarEliminacionModal'));
                        modal.hide();
                    })
                    .catch(error => {
                        console.error('Error al eliminar :', error);
                    });
            }
        </script>
        <?php
          include 'Conexion.php';

          // Inicia sesión para obtener el idUsuario
          if (!isset($_SESSION['usuario_id'])) {
              die("Error: No se ha identificado al usuario.");
          }

          $idUsuario = $_SESSION['usuario_id'];

          // Consulta SQL para obtener los dispositivos del usuario actual
          $sql = "SELECT idDispositivo, nombre, marca, estado, descripcion 
                  FROM inventario 
                  WHERE idUsuario = ?";
          $stmt = $conexion->prepare($sql);
          $stmt->bind_param("i", $idUsuario);
          $stmt->execute();
          $resultado = $stmt->get_result();
          ?>

          <!-- Tabla de Datos -->
          <h3>Dispositivos registrados</h3>
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th class="text-center">Código</th>
                      <th class="text-center">Nombre</th>
                      <th class="text-center">Marca</th>
                      <th class="text-center">Estado</th>
                      <th class="text-center">Descripción</th>
                      <th class="text-center">Editar</th>
                      <th class="text-center">Eliminar</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  if ($resultado->num_rows > 0) {
                      while ($fila = $resultado->fetch_assoc()) {
                          echo "<tr>";
                          echo "<td class='text-center'>" . $fila["idDispositivo"] . "</td>";
                          echo "<td class='text-center'>" . $fila["nombre"] . "</td>";
                          echo "<td class='text-center'>" . $fila["marca"] . "</td>";
                          echo "<td class='text-center'>" . $fila["estado"] . "</td>";
                          echo "<td class='text-center'>" . $fila["descripcion"] . "</td>";
                          echo "<td class='text-center'>" . "<button class='btn btn-warning btn-sm' onclick=\"mostrarEditarModal('" . $fila["idDispositivo"] . "', '" . $fila["nombre"] . "', '" . $fila["marca"] . "', '" . $fila["estado"] . "', '" . $fila["descripcion"] . "')\">Editar</button> " . "</td>";
                          echo "<td class='text-center'>" . "<button class='btn btn-danger btn-sm' onclick=\"eliminarDispositivo('" . $fila["idDispositivo"] . "')\">Eliminar</button>" . "</td>";
                          echo "</tr>";
                      }
                  } else {
                      echo "<tr><td colspan='7'>No hay dispositivos registrados actualmente</td></tr>";
                  }
                  ?>
              </tbody>
          </table>

          <?php
          // Cerrar recursos
          $stmt->close();
          $conexion->close();
          ?>


    <div class="footer">
        <p>&copy; 2024 - Instituto Tecnológico del Sur de Nayarit - Gestión de Inventario</p>
    </div>
</body>
</html>
    
          