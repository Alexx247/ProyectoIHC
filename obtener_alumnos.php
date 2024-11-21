<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener los datos de la tabla alumnos
$sql = "SELECT numControl, nombres, apPat, apMat, telefono, domicilio, carrera FROM alumnos";
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Recorrer y mostrar los datos de cada fila
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='text-center'>" . $fila["numControl"] . "</td>";
        echo "<td class='text-center'>" . $fila["nombres"] . "</td>";
        echo "<td class='text-center'>" . $fila["apPat"] . "</td>";
        echo "<td class='text-center'>" . $fila["apMat"] . "</td>";
        echo "<td class='text-center'>" . $fila["telefono"] . "</td>";
        echo "<td class='text-center'>" . $fila["domicilio"] . "</td>";
        echo "<td class='text-center'>" . $fila["carrera"] . "</td>";
        echo "<td class='text-center'>" . "<button class='btn btn-warning btn-sm' onclick=\"mostrarEditarModal('" . $fila["numControl"] . "', '" . $fila["nombres"] . "', '" . $fila["apPat"] . "', '" . $fila["apMat"] . "', '" . $fila["telefono"] . "', '" . $fila["domicilio"] . "', '" . $fila["carrera"] . "')\">Editar</button> " . "</td>";
        echo "<td class='text-center'>" . "<button class='btn btn-danger btn-sm' onclick=\"eliminarAlumno('" . $fila["numControl"] . "')\">Eliminar</button>" . "</td>";
        echo "</tr>";
    }
} else {
    // Mensaje si no hay datos
    echo "<tr><td colspan='9'>No hay alumnos registrados actualmente</td></tr>";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>