<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al inicio de sesión
    header("Location: index.php");
    exit();
}

// Evitar que las páginas se almacenen en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
