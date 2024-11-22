<?php
include 'verificar_sesion.php';
?>

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
            <a class="nav-link active" href="inicio_usuario.php">
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
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <img src="img/salir-foto.png" alt="Icono Cerrar Sesión">
            Cerrar Sesión
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
        <form id="alumnoForm">
            <div class="mb-3">
                <label for="numControl" class="form-label">N° Control</label>
                <input type="text" class="form-control" id="numControl" name="numControl"
                    placeholder="Ingrese el número de control" required>
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ingrese los nombres"
                    required>
            </div>
            <div class="mb-3">
                <label for="apPat" class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" id="apPat" name="apPat"
                    placeholder="Ingrese el apellido paterno" required>
            </div>
            <div class="mb-3">
                <label for="apMat" class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" id="apMat" name="apMat"
                    placeholder="Ingrese el apellido materno">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el teléfono"
                    required>
            </div>
            <div class="mb-3">
                <label for="domicilio" class="form-label">Domicilio</label>
                <input type="text" class="form-control" id="domicilio" name="domicilio"
                    placeholder="Ingrese la dirección" required>
            </div>
                        <div class="mb-3">
                <label for="carrera" class="form-label">Carrera</label>
                <select class="form-select" id="carrera" name="carrera" required>
                    <option value="">Seleccione una carrera</option>
                    <option value="IIA">IIA</option>
                    <option value="ITIC">ITIC</option>
                    <option value="IGE">IGE</option>
                </select>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" onclick="enviarFormulario()">Agregar alumno(a)</button>
            </div>
        </form>

        <!-- Modal para mostrar mensaje de se guardo exitosamente el alumno -->
        <div class="modal fade" id="resultadoModal" tabindex="-1" aria-labelledby="resultadoModalLabelGuardar"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabelGuardar">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" id="modalMensajeGuardar">
                        Se ha guardado el alumno(a) correctamente!!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar un alumno -->
        <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Alumno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editarAlumnoForm">
                            <!-- Campo oculto para numControl -->
                            <input type="hidden" id="editNumControl" name="numControl">

                            <!-- Campo para nombres -->
                            <div class="mb-3">
                                <label for="editNombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="editNombres" name="nombres" required>
                            </div>

                            <!-- Campo para apellido paterno -->
                            <div class="mb-3">
                                <label for="editApPat" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" id="editApPat" name="apPat" required>
                            </div>

                            <!-- Campo para apellido materno -->
                            <div class="mb-3">
                                <label for="editApMat" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" id="editApMat" name="apMat" required>
                            </div>

                            <!-- Campo para teléfono -->
                            <div class="mb-3">
                                <label for="editTelefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="editTelefono" name="telefono" required>
                            </div>

                            <!-- Campo para domicilio -->
                            <div class="mb-3">
                                <label for="editDomicilio" class="form-label">Domicilio</label>
                                <input type="text" class="form-control" id="editDomicilio" name="domicilio" required>
                            </div>
                            <div class="mb-3">
                                        <label for="editCarrera" class="form-label">Carrera</label>
                                        <select class="form-select" id="editCarrera" name="carrera" required>
                                            <option value="IIA">IIA</option>
                                            <option value="ITIC">ITIC</option>
                                            <option value="IGE">IGE</option>
                                        </select>
                                    </div>

                            <!-- Botón para guardar -->
                            <button type="button" class="btn btn-success" onclick="actualizarAlumno()">Guardar
                                Cambios</button>
                        </form>
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
                        Se ha actualizado el alumno(a) correctamente!!
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
                        ¿Estás seguro de que deseas eliminar este alumno(a)?
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
                        Se ha borrado el alumno(a) correctamente!!
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
                const numControl = document.getElementById('numControl').value.trim();
                const nombres = document.getElementById('nombres').value.trim();
                const apPat = document.getElementById('apPat').value.trim();
                const domicilio = document.getElementById('domicilio').value.trim();
                const carrera = document.getElementById('carrera').value;

                if (!numControl || !nombres || !apPat || !domicilio || carrera === "") {
                    alert("Por favor, complete los campos obligatorios: N° Control Alumno , Nombres, Apellido Paterno y domicilio.");
                    return;
                }

                // Proceder con el envío si los campos están completos
                const formData = new FormData(document.getElementById('alumnoForm'));

                fetch('insertar_alumno.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        // Mostrar el mensaje en el cuerpo de la modal
                        document.getElementById('modalMensajeGuardar').innerHTML = data;

                        // Mostrar la modal de resultado
                        new bootstrap.Modal(document.getElementById('resultadoModal')).show();

                        // Limpiar el formulario después del envío
                        document.getElementById('alumnoForm').reset();
                        // Actualizar la tabla de registros después de la inserción
                        actualizarTabla();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Función para actualizar la tabla con los datos más recientes
            function actualizarTabla() {
                fetch('obtener_alumnos.php')
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
            function mostrarEditarModal(numControl, nombres, apPat, apMat, telefono, domicilio, carrera) {
                document.getElementById('editNumControl').value = numControl; // Llena el campo oculto
                document.getElementById('editNombres').value = nombres;
                document.getElementById('editApPat').value = apPat;
                document.getElementById('editApMat').value = apMat;
                document.getElementById('editTelefono').value = telefono;
                document.getElementById('editDomicilio').value = domicilio;
                document.getElementById('editCarrera').value = carrera;
                    new bootstrap.Modal(document.getElementById('editarModal')).show();
                }
            // Función para mostrar el modal de confirmación de eliminación
            function eliminarAlumno(numControl) {
                // Asignar el N.C al botón de confirmar eliminación
                document.getElementById('confirmarEliminarBtn').onclick = function (event) {
                    event.preventDefault(); // Prevenir la acción predeterminada del botón (evitar recarga de la página)

                    // Llamar a la función para eliminar el préstamo
                    eliminarAlumnoConfirmado(numControl);
                };
                // Mostrar el modal de confirmación
                new bootstrap.Modal(document.getElementById('confirmarEliminacionModal')).show();
            }

            // Función para eliminar el registro de la base de datos
            function eliminarAlumnoConfirmado(numControl) {
                // Enviar la solicitud AJAX para eliminar el alumno
                fetch('eliminar_alumno.php', {
                    method: 'POST',
                    body: JSON.stringify({ numControl: numControl }), // Enviar los datos como JSON
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
                        console.error('Error al eliminar el alumno:', error);
                    });
            }

            // Función para actualizar el préstamo
            function actualizarAlumno() {
                const formData = new FormData(document.getElementById('editarAlumnoForm'));

                // Enviar los datos al servidor
                fetch('editar_alumno.php', {
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
            document.getElementById('editarAlumnoForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Evita que el formulario recargue la página
                actualizarAlumno();
            });
        </script>

        <?php
        include 'Conexion.php';

        // Consulta SQL para obtener los datos de la tabla alumnos
        $sql = "SELECT numControl, nombres, apPat, apMat, telefono, domicilio, carrera FROM alumnos";
        $resultado = $conexion->query($sql);
        ?>

        <!-- Tabla de Datos -->
        <h3>Alumnos</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">N° Control Alumno</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Apellido Paterno</th>
                    <th class="text-center">Apellido Materno</th>
                    <th class="text-center">Telefono</th>
                    <th class="text-center">Domicilio</th>
                    <th class="text-center">Carrera</th>
                    <th class="text-center">Editar Alumno</th>
                    <th class="text-center">Eliminar Alumno</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar si hay resultados
                if ($resultado->num_rows > 0) {
                    // Recorrer y mostrar los datos de cada fila
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='text-center'>" . $fila["numControl"] . "</td>";
                        echo "<td class='text-center'>" . $fila["nombres"] . "</td>";
                        echo "<td class='text-center'>" . $fila["apPat"] . "</td>";
                        echo "<td class='text-center'>" . $fila["apMat"] . "</td>";
                        echo "<td class='text-center'>" . $fila["telefono"] . "</td>";
                        echo "<td class='text-center'>" . $fila["domicilio"] . "</td>";
                        echo "<td class='text-center'>" . $fila["carrera"] . "</td>";
                        echo "<td class='text-center'>" . "<button class='btn btn-warning btn-sm' onclick=\"mostrarEditarModal('" . $fila["numControl"] . "', '" . $fila["nombres"] . "', '" . $fila["apPat"] . "', '" . $fila["apMat"] . "', '" . $fila["telefono"] . "', '" . $fila["domicilio"] . "', '" . $fila["carrera"] . "')\">Editar</button> " . "</td>";
                        echo "<td class='text-center'>" . "<button class='btn btn-danger btn-sm' onclick=\"eliminarAlumno('" . $fila["numControl"] . "')\">Eliminar</button>" . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Mensaje si no hay datos
                    echo "<tr><td colspan='8'>No hay alumnos registrados actualmente</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Cerrar la conexión a la base de datos
        $conexion->close();
        ?>


        <!-- Pie de Página -->
        <div class="footer">
            <p>&copy; 2024 - Instituto Tecnologico del Sur de Nayarit - Gestion de Inventario</p>
        </div>

</body>

</html>