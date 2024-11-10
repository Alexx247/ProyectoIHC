<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener los datos de la tabla registroprestamo
$sql = "SELECT idDispositivo, numC, fechaSolicitud, fechaEntrega, aula FROM registroprestamo";
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Recorrer y mostrar los datos de cada fila
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $fila["idDispositivo"] . "</td>";
        echo "<td>" . $fila["numC"] . "</td>";
        echo "<td>" . $fila["fechaSolicitud"] . "</td>";
        echo "<td>" . $fila["fechaEntrega"] . "</td>";
        echo "<td>" . $fila["aula"] . "</td>";
        echo "</tr>";
    }
} else {
    // Mensaje si no hay datos
    echo "<tr><td colspan='5'>No hay préstamos registrados actualmente</td></tr>";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>