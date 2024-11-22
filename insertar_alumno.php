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
    die("Error: Por favor completa todos los campos obligatorios.");
}

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO alumnos (numControl, nombres, apPat, apMat, telefono, domicilio, carrera) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssssss", $numControl, $nombres, $apPat, $apMat, $telefono, $domicilio, $carrera);
    
    if ($stmt->execute()) {
        echo "Alumno(a) agregado correctamente.";
    } else {
        echo "Error al agregar el alumno(a): " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>