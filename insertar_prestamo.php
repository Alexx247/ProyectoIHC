<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Error: No se ha iniciado sesión.");
}

// Obtener el idUsuario desde la sesión
$idUsuario = $_SESSION['usuario_id'];

// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos enviados desde el formulario
$idDispositivo = $_POST['idDispositivo'];
$numC = $_POST['numC'];
$fechaSolicitud = $_POST['fechaSolicitud'];
$fechaEntrega = $_POST['fechaEntrega'];
$aula = $_POST['aula'];

// Validar que el numC exista en la tabla de alumnos
$sqlVerificarAlumno = "SELECT numControl FROM alumnos WHERE numControl = ?";
$stmtVerificar = $conexion->prepare($sqlVerificarAlumno);

if ($stmtVerificar) {
    $stmtVerificar->bind_param("s", $numC);
    $stmtVerificar->execute();
    $resultado = $stmtVerificar->get_result();

    if ($resultado->num_rows === 0) {
        echo "Error: El número de control no existe en la base de datos.";
        $stmtVerificar->close();
        $conexion->close();
        exit;
    }
    $stmtVerificar->close();
} else {
    echo "Error al preparar la consulta de validación de alumno: " . $conexion->error;
    $conexion->close();
    exit;
}

// Validar que el idDispositivo exista en la tabla inventario
$sqlVerificarDispositivo = "SELECT idDispositivo FROM inventario WHERE idDispositivo = ?";
$stmtVerificarDispositivo = $conexion->prepare($sqlVerificarDispositivo);

if ($stmtVerificarDispositivo) {
    $stmtVerificarDispositivo->bind_param("i", $idDispositivo);
    $stmtVerificarDispositivo->execute();
    $resultadoDispositivo = $stmtVerificarDispositivo->get_result();

    if ($resultadoDispositivo->num_rows === 0) {
        echo "Error: El ID del dispositivo no existe en la base de datos.";
        $stmtVerificarDispositivo->close();
        $conexion->close();
        exit;
    }
    $stmtVerificarDispositivo->close();
} else {
    echo "Error al preparar la consulta de validación de dispositivo: " . $conexion->error;
    $conexion->close();
    exit;
}

// Insertar el préstamo en la tabla registroprestamo
$sqlInsertar = "INSERT INTO registroprestamo (idDispositivo, numC, fechaSolicitud, fechaEntrega, aula, idUsuario) VALUES (?, ?, ?, ?, ?, ?)";
$stmtInsertar = $conexion->prepare($sqlInsertar);

if ($stmtInsertar) {
    $stmtInsertar->bind_param("sisssi", $idDispositivo, $numC, $fechaSolicitud, $fechaEntrega, $aula, $idUsuario);

    if ($stmtInsertar->execute()) {
        echo "Préstamo registrado exitosamente.";
    } else {
        echo "Error al registrar el préstamo: " . $stmtInsertar->error;
    }

    $stmtInsertar->close();
} else {
    echo "Error al preparar la consulta de inserción: " . $conexion->error;
}

$conexion->close();
?>
