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

// Obtener los datos enviados desde el formulario
$idDispositivo = $_POST['idDispositivo'];
$numC = $_POST['numC'];
$fechaSolicitud = $_POST['fechaSolicitud'];
$fechaEntrega = $_POST['fechaEntrega'];
$aula = $_POST['aula'];

// Validar que la fecha de entrega no sea anterior a la fecha de solicitud
if (strtotime($fechaEntrega) < strtotime($fechaSolicitud)) {
    echo "Error: La fecha de entrega no puede ser anterior a la fecha de solicitud.";
    $conexion->close();
    exit;
}

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

// Validar si el dispositivo ya está en préstamo (en la tabla registroprestamo)
$sqlVerificarPrestamo = "SELECT idDispositivo FROM registroprestamo WHERE idDispositivo = ? AND fechaEntrega >= CURDATE()";
$stmtVerificarPrestamo = $conexion->prepare($sqlVerificarPrestamo);

if ($stmtVerificarPrestamo) {
    $stmtVerificarPrestamo->bind_param("i", $idDispositivo);
    $stmtVerificarPrestamo->execute();
    $resultadoPrestamo = $stmtVerificarPrestamo->get_result();

    if ($resultadoPrestamo->num_rows > 0) {
        echo "Error: El dispositivo ya está en préstamo y no puede ser solicitado nuevamente.";
        $stmtVerificarPrestamo->close();
        $conexion->close();
        exit;
    }
    $stmtVerificarPrestamo->close();
} else {
    echo "Error al preparar la consulta de validación de préstamo: " . $conexion->error;
    $conexion->close();
    exit;
}

// Iniciar la transacción
$conexion->begin_transaction();

try {
    // Insertar el préstamo en la tabla registroprestamo
    $sqlInsertarPrestamo = "INSERT INTO registroprestamo (idDispositivo, numC, fechaSolicitud, fechaEntrega, aula, idUsuario) 
                            VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsertarPrestamo = $conexion->prepare($sqlInsertarPrestamo);

    if (!$stmtInsertarPrestamo) {
        throw new Exception("Error al preparar la consulta de inserción de préstamo: " . $conexion->error);
    }

    $stmtInsertarPrestamo->bind_param("sisssi", $idDispositivo, $numC, $fechaSolicitud, $fechaEntrega, $aula, $idUsuario);
    if (!$stmtInsertarPrestamo->execute()) {
        throw new Exception("Error al ejecutar la inserción de préstamo: " . $stmtInsertarPrestamo->error);
    }

    $stmtInsertarPrestamo->close();

    // Insertar en la tabla historial sin verificación de duplicados
    $sqlInsertarHistorial = "INSERT IGNORE INTO historial (idDispositivo, numC, fechaSolicitud, fechaEntrega, aula, idUsuario) 
                             VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsertarHistorial = $conexion->prepare($sqlInsertarHistorial);

    if (!$stmtInsertarHistorial) {
        throw new Exception("Error al preparar la consulta de inserción en historial: " . $conexion->error);
    }

    $stmtInsertarHistorial->bind_param("sisssi", $idDispositivo, $numC, $fechaSolicitud, $fechaEntrega, $aula, $idUsuario);
    if (!$stmtInsertarHistorial->execute()) {
        throw new Exception("Error al ejecutar la inserción en historial: " . $stmtInsertarHistorial->error);
    }

    $stmtInsertarHistorial->close();

    // Confirmar la transacción
    $conexion->commit();
    echo "Préstamo y historial registrados exitosamente.";

} catch (Exception $e) {
    // Revertir los cambios si ocurre un error
    $conexion->rollback();
    echo "Error: " . $e->getMessage();
}

$conexion->close();
?>
