<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos del formulario de edición
$idDispositivo = $_POST['idDispositivo'];
$numC = $_POST['numC'];
$fechaSolicitud = $_POST['fechaSolicitud'];
$fechaEntrega = $_POST['fechaEntrega'];
$aula = $_POST['aula'];

// Validar que el numC exista en la tabla de alumnos
$sqlVerificarAlumno = "SELECT numControl FROM alumnos WHERE numControl = ?";
$stmtVerificar = $conexion->prepare($sqlVerificarAlumno);

if ($stmtVerificar) {
    $stmtVerificar->bind_param("i", $numC); // Usamos 'i' para entero
    $stmtVerificar->execute();
    $resultado = $stmtVerificar->get_result();

    if ($resultado->num_rows === 0) {
        echo "Error: El número de control no existe en la base de datos.";
        $stmtVerificar->close();
        $conexion->close();
        exit;
    }
    $stmtVerificar->close();
} else {
    echo "Error al preparar la consulta de validación: " . $conexion->error;
    $conexion->close();
    exit;
}

// Actualizar el registro en la base de datos
$sql = "UPDATE registroprestamo SET numC = ?, fechaSolicitud = ?, fechaEntrega = ?, aula = ? WHERE idDispositivo = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    // Usar bind_param con los parámetros correctos
    $stmt->bind_param("sssss", $numC, $fechaSolicitud, $fechaEntrega, $aula, $idDispositivo);

    if ($stmt->execute()) {
        // Respuesta de éxito
        echo "Préstamo actualizado correctamente.";
    } else {
        echo "Error al actualizar el préstamo: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>
