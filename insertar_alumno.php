<?php
include 'Conexion.php';

// Validar y obtener los datos enviados desde el formulario
$numControl = $_POST['numControl'];
$nombres = $_POST['nombres'];
$apPat = $_POST['apPat'];
$apMat = $_POST['apMat'];
$telefono = $_POST['telefono'];
$domicilio = $_POST['domicilio'];
$carrera = $_POST['carrera'];

// Verificar que todos los datos obligatorios estén presentes
if (!$numControl || !$nombres || !$apPat || !$domicilio || !$carrera) {
    echo "Error: Por favor completa todos los campos obligatorios.";
    exit;
}

// Verificar si el alumno ya está registrado
$sqlVerificar = "SELECT * FROM alumnos WHERE numControl = ?";
$stmtVerificar = $conexion->prepare($sqlVerificar);

if (!$stmtVerificar) {
    echo "Error al preparar la consulta de verificación: " . $conexion->error;
    exit;
}

$stmtVerificar->bind_param("s", $numControl);
$stmtVerificar->execute();
$resultado = $stmtVerificar->get_result();

if ($resultado->num_rows > 0) {
    // Si el alumno ya está registrado
    echo "Error: El alumno con número de control $numControl ya está registrado.";
    $stmtVerificar->close();
    $conexion->close();
    exit;
}

// Cerrar la consulta de verificación
$stmtVerificar->close();

// Preparar y ejecutar la consulta de inserción
$sqlInsertar = "INSERT INTO alumnos (numControl, nombres, apPat, apMat, telefono, domicilio, carrera) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmtInsertar = $conexion->prepare($sqlInsertar);

if (!$stmtInsertar) {
    echo "Error al preparar la consulta de inserción: " . $conexion->error;
    exit;
}

$stmtInsertar->bind_param("sssssss", $numControl, $nombres, $apPat, $apMat, $telefono, $domicilio, $carrera);

if ($stmtInsertar->execute()) {
    echo "Alumno(a) agregado correctamente.";
} else {
    echo "Error al agregar el alumno(a): " . $stmtInsertar->error;
}

// Cerrar la consulta de inserción y la conexión
$stmtInsertar->close();
$conexion->close();
?>
