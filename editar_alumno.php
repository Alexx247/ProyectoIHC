<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos del formulario de edición
$numControl = $_POST['numControl'];
$nombres = $_POST['nombres'];
$apPat = $_POST['apPat'];
$apMat = $_POST['apMat'];
$telefono = $_POST['telefono'];
$domicilio = $_POST['domicilio'];

// Actualizar el registro en la base de datos
$sql = "UPDATE alumnos SET nombres = ?, apPat = ?, apMat = ?, telefono = ?, domicilio = ? WHERE numControl = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    // Usar bind_param con los parámetros correctos
    $stmt->bind_param("sssssi", $nombres, $apPat, $apMat, $telefono, $domicilio, $numControl);

    if ($stmt->execute()) {
        // Respuesta de éxito
        echo "Alumno(a) actualizado correctamente.";
    } else {
        echo "Error al actualizar el alumno(a): " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>