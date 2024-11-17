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