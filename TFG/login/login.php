<?php
session_start();
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    if (empty($email)) {
        $error = "Debes introducir un email.";
    } elseif (empty($password)) {
        $error = "Debes introducir una contraseña.";
    } else {
        $conn = new mysqli('localhost', 'root', '', 'tfg');

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND contraseña = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            $_SESSION['user_name'] = $usuario['nombre']; 
            $_SESSION['user_email'] = $usuario['email'];
            $_SESSION['user_id'] = $usuario['id_usuario'];
            header("Location: ../indice/index.php");
        } else {
            $error = "Email o contraseña incorrectos.";
        }
        
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KICK IT WITH JJ - Login</title>
    <link rel="stylesheet" href="styles_login.css">
</head>

<body>
    <a href="../indice/index.php"><img src="../imagenes/logo.png" alt="logo.png" class="logo"></a>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <form method="POST" action="login.php">
            <div class="input-group">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" required>
                <label>Contraseña</label>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>
            <button type="submit">Entrar</button><br><br>
            <p>¿Aún no tienes cuenta?<a class="link_registrarse" href="registro.php"> Regístrate</a></p>
        </form>

        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.querySelector(".toggle-password");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.textContent = "🔒";
            } else {
                passwordInput.type = "password";
                toggleIcon.textContent = "👁️";
            }
        }
    </script>
</body>

</html>
