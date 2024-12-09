<?php
include 'verificar_sesion.php';
?>
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
        <img src="img/TecSurNay.png" alt="Logo ITSN" style="position: absolute; top: 10px; right: 10px; width: 150px;">
    </div>

    <!-- Barra de Navegación Vertical -->
    <div class="sidebar position-fixed">
        <nav class="nav flex-column">
            <a class="nav-link active" href="inicio_admin.php" style="color: #0066cc;">
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
            <a class="nav-link" href="Estadisticas.php">
        <img src="img/estadisticas_foto.png" alt="Icono Estadísticas">
        Estadísticas
      </a>
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <img src="img/salir-foto.png" alt="Icono Cerrar Sesión">
                Cerrar Sesión
            </a>
        </nav>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <!-- Mensajes con botón de cierre -->
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="mensajeBienvenida">
            Bienvenido al sistema de control de inventario del ITSN. Aquí podrás gestionar los préstamos de equipos.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-info alert-dismissible fade show" role="alert" id="mensajeInfo">
            Mantén la información actualizada para un mejor control.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <!-- Formulario de Registro de Préstamo -->
        <h2>Registro de préstamo</h2>
        <form id="prestamoForm">
            <div class="mb-3">
                <label for="idDispositivo" class="form-label">Código del dispositivo</label>
                <input type="text" class="form-control" id="idDispositivo" name="idDispositivo"
                    placeholder="Ingrese el codigo del dispositivo a prestar" required>
            </div>
            <div class="mb-3">
                <label for="numC" class="form-label">N° Control Alumno</label>
                <input type="text" class="form-control" id="numC" name="numC" placeholder="Ingrese el número de control"
                    required>
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

        <!-- Modal para editar un préstamo -->
        <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Préstamo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editarPrestamoForm">
                            <input type="hidden" id="editIdDispositivo" name="idDispositivo">
                            <div class="mb-3">
                                <label for="editNumC" class="form-label">N° Control Alumno</label>
                                <input type="text" class="form-control" id="editNumC" name="numC" required>
                            </div>
                            <div class="mb-3">
                                <label for="editFechaSolicitud" class="form-label">Fecha de Solicitud</label>
                                <input type="date" class="form-control" id="editFechaSolicitud" name="fechaSolicitud"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editFechaEntrega" class="form-label">Fecha Limite</label>
                                <input type="date" class="form-control" id="editFechaEntrega" name="fechaEntrega"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editAula" class="form-label">Aula</label>
                                <input type="text" class="form-control" id="editAula" name="aula" required>
                            </div>
                            <button type="button" class="btn btn-success" onclick="actualizarPrestamo()">Guardar
                                Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para mostrar mensaje de se guardo exitosamente el prestamo -->
        <div class="modal fade" id="resultadoModal" tabindex="-1" aria-labelledby="resultadoModalLabelGuardar"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabelGuardar">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="modalMensajeGuardar">
                        Se ha guardado el préstamo correctamente!!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para mostrar mensaje de error al resgitrar el prestamo -->
        <div class="modal fade" id="resultadoModalPrestamoIncompleto" tabindex="-1"
            aria-labelledby="resultadoModalLabelGuardar" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabelGuardar">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="modalMensajeGuardar">
                        Hay datos incompletos o las fechas no son correctas!!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para mostrar mensaje de se edito exitosamente el prestamo -->
        <div class="modal fade" id="resultadoModalEditar" tabindex="-1" aria-labelledby="resultadoModalLabelEditar"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabelEditar">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="modalMensajeEditar">
                        Se ha actualizado el préstamo correctamente!!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación de Eliminación -->
        <div class="modal fade" id="confirmarEliminacionModal" tabindex="-1"
            aria-labelledby="confirmarEliminacionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmarEliminacionModalLabel">Confirmación de Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar este préstamo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Si, Eliminar</button>
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
                        Se ha borrado el préstamo correctamente!!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
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

        <script>
            // Función para enviar el formulario con AJAX
            function enviarFormulario() {
                // Verifica que los campos obligatorios estén llenos
                const idDispositivo = document.getElementById('idDispositivo').value.trim();
                const numC = document.getElementById('numC').value.trim();
                const fechaSolicitud = document.getElementById('fechaSolicitud').value.trim();
                const fechaEntrega = document.getElementById('fechaEntrega').value.trim();
                const aula = document.getElementById('aula').value.trim();
                const fechaSolicitudObj = new Date(fechaSolicitud);
                const fechaEntregaObj = new Date(fechaEntrega);

                // Verificar si hay campos vacíos
                if (!idDispositivo || !numC || !fechaSolicitud || !fechaEntrega || !aula || fechaEntregaObj < fechaSolicitudObj) {
                    new bootstrap.Modal(document.getElementById('resultadoModalPrestamoIncompleto')).show();
                    return;
                }

                // Proceder con el envío si los campos están completos
                const formData = new FormData(document.getElementById('prestamoForm'));

                fetch('insertar_prestamo.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        // Mostrar el mensaje en el cuerpo de la modal
                        document.getElementById('modalMensajeGuardar').innerHTML = data;

                        if (data.includes("registrados exitosamente")) {
                            // Si la respuesta indica éxito, limpiar el formulario
                            document.getElementById('prestamoForm').reset();
                            // Mostrar la modal de resultado
                            new bootstrap.Modal(document.getElementById('resultadoModal')).show();
                            // Actualizar la tabla de registros después de la inserción
                            actualizarTabla();
                        } else {
                            // Si hay un error, solo mostrar el mensaje de error en la modal
                            new bootstrap.Modal(document.getElementById('resultadoModal')).show();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Función para actualizar la tabla con los datos más recientes
            function actualizarTabla() {
                fetch('obtener_prestamos_admin.php')
                    .then(response => response.text())
                    .then(data => {
                        // Reemplazar el contenido de la tabla con los nuevos datos
                        document.querySelector("table tbody").innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error al actualizar la tabla:', error);
                    });
            }

            //Mostrar datos de la tabla para edición
            function mostrarEditarModal(idDispositivo, numC, fechaSolicitud, fechaEntrega, aula) {
                document.getElementById('editIdDispositivo').value = idDispositivo;
                document.getElementById('editNumC').value = numC;
                document.getElementById('editFechaSolicitud').value = fechaSolicitud;
                document.getElementById('editFechaEntrega').value = fechaEntrega;
                document.getElementById('editAula').value = aula;
                new bootstrap.Modal(document.getElementById('editarModal')).show();
            }

            // Función para mostrar el modal de confirmación de eliminación
            function eliminarPrestamo(idDispositivo) {
                // Asignar el idDispositivo al botón de confirmar eliminación
                document.getElementById('confirmarEliminarBtn').onclick = function (event) {
                    event.preventDefault(); // Prevenir la acción predeterminada del botón (evitar recarga de la página)

                    // Llamar a la función para eliminar el préstamo
                    eliminarPrestamoConfirmado(idDispositivo);
                };

                // Mostrar el modal de confirmación
                new bootstrap.Modal(document.getElementById('confirmarEliminacionModal')).show();
            }

            // Función para eliminar el registro de la base de datos
            function eliminarPrestamoConfirmado(idDispositivo) {
                // Enviar la solicitud AJAX para eliminar el préstamo
                fetch('eliminar_prestamo.php', {
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
                        console.error('Error al eliminar el préstamo:', error);
                    });
            }

            // Función para actualizar el préstamo
            function actualizarPrestamo() {
                const formData = new FormData(document.getElementById('editarPrestamoForm'));

                // Enviar los datos al servidor
                fetch('editar_prestamo.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text()) // Recibir la respuesta del servidor
                    .then(data => {
                        // Mostrar mensaje en el modal
                        document.getElementById('modalMensajeEditar').innerHTML = data;

                        // Mostrar el modal de resultado
                        new bootstrap.Modal(document.getElementById('resultadoModalEditar')).show();

                        // Si la respuesta indica que la actualización fue exitosa, cerrar el modal de edición
                        if (data.includes('actualizado correctamente')) {
                            var editarModal = bootstrap.Modal.getInstance(document.getElementById('editarModal'));
                            editarModal.hide();  // Cerrar el modal de edición

                            // Opcional: Recargar la página o actualizar la tabla para reflejar los cambios
                            actualizarTabla();  // Llamar a la función para actualizar la tabla
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Programar la desaparición del primer mensaje a los 5 segundos
            setTimeout(() => {
                const mensajeBienvenida = document.getElementById('mensajeBienvenida');
                if (mensajeBienvenida) {
                    mensajeBienvenida.classList.remove('show'); // Remueve la clase que lo muestra
                    mensajeBienvenida.classList.add('fade');   // Asegura la animación de desvanecimiento
                    setTimeout(() => mensajeBienvenida.remove(), 150); // Elimina el elemento del DOM
                }
            }, 5000); // 5 segundos

            // Programar la desaparición del segundo mensaje a los 7 segundos
            setTimeout(() => {
                const mensajeInfo = document.getElementById('mensajeInfo');
                if (mensajeInfo) {
                    mensajeInfo.classList.remove('show'); // Remueve la clase que lo muestra
                    mensajeInfo.classList.add('fade');   // Asegura la animación de desvanecimiento
                    setTimeout(() => mensajeInfo.remove(), 150); // Elimina el elemento del DOM
                }
            }, 7000); // 7 segundos
        </script>

<?php
        include 'Conexion.php';

        // Consulta SQL para obtener los datos de la tabla registroprestamo
        $sql = "SELECT idDispositivo, numC, fechaSolicitud, fechaEntrega, aula FROM registroprestamo";
        $resultado = $conexion->query($sql);
        ?>

        <!-- Tabla de Datos -->
        <h3>Préstamos actuales</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">Codigo dispositivo</th>
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
                    echo "<tr><td colspan='7'>No hay préstamos registrados actualmente</td></tr>";
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