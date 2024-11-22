<?php
include 'Conexion.php';

// Recibir datos del formulario de edición
$numControl = $_POST['numControl'];
$nombres = $_POST['nombres'];
$apPat = $_POST['apPat'];
$apMat = $_POST['apMat'];
$telefono = $_POST['telefono'];
$domicilio = $_POST['domicilio'];
$carrera = $_POST['carrera'];

// Actualizar el registro en la base de datos
<<<<<<< HEAD
$sql = "UPDATE alumnos SET nombres = ?, apPat = ?, apMat = ?, telefono = ?, domicilio = ?, carrera = ? WHERE numControl = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssssssi", $nombres, $apPat, $apMat, $telefono, $domicilio, $carrera, $numControl);
=======
$sql = "UPDATE alumnos SET nombres = ?, apPat = ?, apMat = ?, telefono = ?, domicilio = ? WHERE numControl = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    // Usar bind_param con los parámetros correctos
    $stmt->bind_param("sssssi", $nombres, $apPat, $apMat, $telefono, $domicilio, $numControl);
>>>>>>> 32fd89ab8e42ea0f4261536ee9245ace05be2dd9

    if ($stmt->execute()) {
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