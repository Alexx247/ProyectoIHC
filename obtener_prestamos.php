<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Error: No se ha iniciado sesión.");
}

// Obtener el idUsuario desde la sesión
$idUsuario = $_SESSION['usuario_id'];

include 'Conexion.php';

// Consulta SQL para obtener los datos de los préstamos realizados por el usuario
$sql = "SELECT idDispositivo, numC, fechaSolicitud, fechaEntrega, aula 
        FROM registroprestamo 
        WHERE idUsuario = ?"; // Filtrar por el idUsuario

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario); // Usamos "i" porque idUsuario es un entero
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Recorrer y mostrar los datos de cada fila
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='text-center'>" . $fila["idDispositivo"] . "</td>";
        echo "<td class='text-center'>" . $fila["numC"] . "</td>";
        echo "<td class='text-center'>" . $fila["fechaSolicitud"] . "</td>";
        echo "<td class='text-center'>" . $fila["fechaEntrega"] . "</td>";
        echo "<td class='text-center'>" . $fila["aula"] . "</td>";
        echo "<td class='text-center'>" . "<button class='btn btn-warning btn-sm' onclick=\"mostrarEditarModal('" . $fila["idDispositivo"] . "', '" . $fila["numC"] . "', '" . $fila["fechaSolicitud"] . "', '" . $fila["fechaEntrega"] . "', '" . $fila["aula"] . "')\">Editar</button> " . "</td>";
        echo "<td class='text-center'>" . "<button class='btn btn-danger btn-sm' onclick=\"eliminarPrestamo('" . $fila["idDispositivo"] . "')\">Eliminar</button>" . "</td>";
        echo "</tr>";
    }
} else {
    // Mensaje si no hay datos
    echo "<tr><td colspan='7'>No hay préstamos registrados actualmente</td></tr>";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
