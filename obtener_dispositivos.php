<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Inicia sesión para obtener el idUsuario
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die("Error: No se ha identificado al usuario.");
}

$idUsuario = $_SESSION['usuario_id'];  // Obtiene el idUsuario desde la sesión

// Consulta SQL para obtener los dispositivos del usuario actual
$sql = "SELECT idDispositivo, nombre, marca, estado, descripcion 
        FROM inventario 
        WHERE idUsuario = ?"; // Filtra por idUsuario

// Preparar la consulta
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);  // Vincula el parámetro de idUsuario
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Recorrer y mostrar los datos de cada fila
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='text-center'>" . $fila["idDispositivo"] . "</td>";
        echo "<td class='text-center'>" . $fila["nombre"] . "</td>";
        echo "<td class='text-center'>" . $fila["marca"] . "</td>";
        echo "<td class='text-center'>" . $fila["estado"] . "</td>";
        echo "<td class='text-center'>" . $fila["descripcion"] . "</td>";
        echo "<td class='text-center'>" . "<button class='btn btn-warning btn-sm' onclick=\"mostrarEditarModal('" . $fila["idDispositivo"] . "', '" . $fila["nombre"] . "', '" . $fila["marca"] . "', '" . $fila["estado"] . "', '" . $fila["descripcion"] . "')\">Editar</button> " . "</td>";
        echo "<td class='text-center'>" . "<button class='btn btn-danger btn-sm' onclick=\"eliminarDispositivo('" . $fila["idDispositivo"] . "')\">Eliminar</button>" . "</td>";
        echo "</tr>";
    }
} else {
    // Mensaje si no hay datos
    echo "<tr><td colspan='7'>No hay dispositivos registrados actualmente</td></tr>";
}

// Cerrar la conexión y el statement
$stmt->close();
$conexion->close();
?>
