<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Validar y obtener los datos enviados desde el formulario
$numControl = $_POST['numControl'];
$nombres = $_POST['nombres'];
$apPat = $_POST['apPat'];
$apMat = $_POST['apMat'];
$telefono = $_POST['telefono'];
$domicilio = $_POST['domicilio'];

// Verificar que todos los datos obligatorios estén presentes
if (!$numControl || !$nombres || !$apPat || !$domicilio) {
    die("Error: Por favor completa todos los campos obligatorios.");
}

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO alumnos (numControl, nombres, apPat, apMat, telefono, domicilio) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    // Vincular parámetros (corrigiendo la cantidad y tipos de datos)
    $stmt->bind_param("ssssss", $numControl, $nombres, $apPat, $apMat, $telefono, $domicilio);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Alumno registrado exitosamente.";
    } else {
        echo "Error al registrar al alumno: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>
