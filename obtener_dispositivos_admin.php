<?php
include 'Conexion.php';

// Consulta SQL para obtener los datos de la tabla dispositivos
$sql = "SELECT idDispositivo, nombre, marca, estado, descripcion FROM inventario";
$resultado = $conexion->query($sql);

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

// Cerrar la conexión a la base de datos
$conexion->close();
?>