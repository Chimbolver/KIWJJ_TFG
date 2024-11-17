<?php
session_start();

// Guardar el carrito en una cookie antes de cerrar sesión, si existe
if (isset($_SESSION['cart'])) {
    setcookie('cart', json_encode($_SESSION['cart']), time() + (86400 * 30), "/"); // Guardar el carrito por 30 días
}

// Vaciar la sesión
$_SESSION = array();

// Eliminar las cookies de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión y redirigir
session_destroy();
header("Location: ../indice/index.php");
exit;
?>
