<?php
include 'Conexion.php';

// Obtener el ID del dispositivo a eliminar
$data = json_decode(file_get_contents('php://input'), true); // Recibir los datos en formato JSON
$numControl = $data['numControl']; // Obtener el N.C desde el JSON

// Eliminar el registro de la base de datos
$sql = "DELETE FROM alumnos WHERE numControl = ?"; // Usar sentencia preparada

$stmt = $conexion->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $numControl); // Enlazar el parámetro
    if ($stmt->execute()) {
        echo "Alumno(a) eliminado correctamente";
    } else {
        echo "Error al eliminar el alumno(a): " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>
