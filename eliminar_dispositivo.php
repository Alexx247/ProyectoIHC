<?php
include 'verificar_sesion.php';

include 'Conexion.php';
// Obtener el ID del dispositivo a eliminar
$data = json_decode(file_get_contents('php://input'), true); // Recibir los datos en formato JSON
$idDispositivo = $data['idDispositivo']; // Obtener el N.C desde el JSON


// Preparar la consulta SQL
$sql = "DELETE FROM inventario WHERE idDispositivo = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $idDispositivo);
    if ($stmt->execute()) {
        echo "Dispositivo eliminado con éxito";
    } else {
        echo "Error al eliminar el dispositivo: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conexion->error;
}

$conexion->close();
?>