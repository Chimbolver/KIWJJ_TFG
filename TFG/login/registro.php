<?php
session_start();
$error = ""; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = trim(htmlspecialchars($_POST['nombre']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $confirm_password = trim(htmlspecialchars($_POST['confirm_password']));
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    // Verificar si los campos están vacíos
    if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password) || empty($fecha_nacimiento)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Verificar edad mínima
        $fecha_actual = new DateTime();
        $fecha_nac = new DateTime($fecha_nacimiento);
        $edad = $fecha_actual->diff($fecha_nac)->y;

        if ($edad < 18) {
            $error = "Debes ser mayor de 18 años para registrarte.";
        } else {

            $conn = new mysqli('localhost', 'root', '', 'tfg');

            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            // Verificar si el correo ya está registrado
            $sql = "SELECT * FROM usuarios WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $error = "El email ya está registrado.";
            } else {
                // Insertar nuevo usuario
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO usuarios (nombre, email, contraseña, fecha_nacimiento) VALUES ('$nombre', '$email', '$hashed_password', '$fecha_nacimiento')";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['user'] = $email;
                    echo "<script>alert('Registro exitoso. ¡Bienvenido a KICK IT WITH JJ!');</script>";
                    echo "<script>window.location.href = '../indice/index.php';</script>";
                    exit;
                } else {
                    $error = "Error al registrar usuario: " . $conn->error;

                    // Registrar error en un archivo
                    $errorMessage = "[" . date("Y-m-d H:i:s") . "] Error al registrar usuario: " . $conn->error . "\n";
                    file_put_contents("error_log.txt", $errorMessage, FILE_APPEND);
                }
            }

            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - KICK IT WITH JJ</title>
    <link rel="stylesheet" href="styles_registro.css">
</head>
<body>

<a href="../indice/index.php"><img src="../imagenes/logo.png" alt="logo.png" class="logo"></a>
    <div class="registro-container">
        <h1 class="titulo-container">Registro</h1><br>
        <form method="POST" action="registro.php">
            <div class="input-group">
                <input type="text" name="nombre" required>
                <label>Nombre</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="input-group">
                <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" required onfocus="(this.type='date')"
                    onblur="(this.type='text')">
                <label>Fecha de Nacimiento</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" required>
                <label>Contraseña</label>
                <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
            </div>
            <div class="input-group">
                <input type="password" name="confirm_password" id="confirm_password" required>
                <label>Confirmar Contraseña</label>
                <span class="toggle-password" onclick="togglePassword('confirm_password', this)">👁️</span>
            </div>
            <button type="submit">Registrarse</button><br><br>
            <p class="texto-registro">¿Ya tienes cuenta?<a class="link_registrarse" href="login.php"> Inicia sesión</a>
            </p>

        </form>
        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
            <script>alert("<?php echo $error; ?>");</script>
        <?php endif; ?>
    </div>

    <script>
        function togglePassword(fieldId, icon) {
            const passwordInput = document.getElementById(fieldId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.textContent = "🔒";
            } else {
                passwordInput.type = "password";
                icon.textContent = "👁️";
            }
        }
    </script>
</body>

</html>
