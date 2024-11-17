<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el ID del dispositivo a eliminar
$data = json_decode(file_get_contents('php://input'), true); // Recibir los datos en formato JSON
$idDispositivo = $data['idDispositivo']; // Obtener el idDispositivo desde el JSON

// Eliminar el registro de la base de datos
$sql = "DELETE FROM registroprestamo WHERE idDispositivo = ?"; // Usar sentencia preparada

$stmt = $conexion->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $idDispositivo); // Enlazar el parámetro
    if ($stmt->execute()) {
        echo "Préstamo eliminado correctamente";
    } else {
        echo "Error al eliminar el préstamo: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>
