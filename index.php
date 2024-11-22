<?php
include 'Conexion.php';

// Iniciar sesión
session_start();

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    // Verificar si el usuario existe y la contraseña es correcta
    // Verificar si el usuario existe y la contraseña es correcta
    if ($usuario && $password == $usuario['contrasena']) {
        // La contraseña es correcta
        $_SESSION['usuario_id'] = $usuario['idUsuario'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_privilegio'] = $usuario['privilegio'];
        
        // Redirigir dependiendo del privilegio
        if ($_SESSION['usuario_privilegio'] == 'administrador') {
            header("Location: inicio_admin.php");
        } else {
            header("Location: inicio_usuario.php");
        }
        exit();
    } else {
        // Mostrar mensaje de error si las credenciales son incorrectas
        $error = "Correo o contraseña incorrectos.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="my-login.css">
</head>

<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                        <img src="img/TecSurNay.png" alt="logo">
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Inicio de sesión</h4>
                            <!-- Mostrar error si las credenciales son incorrectas -->
                            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                            <form method="POST" class="my-login-validation" novalidate="">
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input id="email" type="email" class="form-control" name="email" required autofocus>
                                    <div class="invalid-feedback">
                                        Correo electrónico inválido
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña
                                        <a href="forgot.html" class="float-right">¿Olvidaste tu contraseña?</a>
                                    </label>
                                    <input id="password" type="password" class="form-control" name="password" required data-eye>
                                    <div class="invalid-feedback">
                                        Contraseña requerida
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                                        <label for="remember" class="custom-control-label">Recuérdame</label>
                                    </div>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Iniciar sesión
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; 2024 Gestión de Inventario &mdash; Instituto Tecnológico del Sur de Nayarit
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="my-login.js"></script>
</body>
</html>
