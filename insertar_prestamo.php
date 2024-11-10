<?php
// Configuración de la conexión
$servidor = "localhost:3307";
$usuario = "root"; 
$contraseña = ""; 
$basedatos = "gestioninventario";

// Conectar a la base de datos
$conexion = new mysqli($servidor, $usuario, $contraseña, $basedatos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos enviados desde el formulario
$idDispositivo = $_POST['idDispositivo'];
$numC = $_POST['numC'];
$fechaSolicitud = $_POST['fechaSolicitud'];
$fechaEntrega = $_POST['fechaEntrega'];
$aula = $_POST['aula'];

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO registroprestamo (idDispositivo, numC, fechaSolicitud, fechaEntrega, aula) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssss", $idDispositivo, $numC, $fechaSolicitud, $fechaEntrega, $aula);

    if ($stmt->execute()) {
        echo "Préstamo registrado exitosamente.";
    } else {
        echo "Error al registrar el préstamo: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conexion->error;
}

$conexion->close();
?>