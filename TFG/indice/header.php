<?php
session_start();

// Inicializar carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../indice/header_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Header - KICK IT WITH JJ</title>
</head>

<body>
    <header class="header">
        <a href="../indice/index.php">
            <img src="../imagenes/logo_blanco.png" alt="KICK IT WITH JJ" class="logo">
        </a>
        <nav class="nav-menu">
            <button class="nav-toggle" onclick="toggleNavMenu()">☰</button>
            <ul>
                <li><a href="../indice/index.php">HOME</a></li>
                <li><a href="../paginas/productos.php">PRODUCTOS</a></li>
                <li><a href="../paginas/vender.php">VENDER</a></li>
                <li><a href="../paginas/subastas.php">SUBASTAS</a></li>
            </ul>
        </nav>
        <div class="user-section">
            <div class="cart-container">
                <div class="faa">
                    <a href="../carrito/carro.php" class="cart-icon">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                </div>
            </div>

            <?php if (isset($_SESSION['user_name'])): ?>
                <div class="user-info">
                    <span>Bienvenido, <?php echo $_SESSION['user_name']; ?></span>
                    <button class="dropdown-button" onclick="toggleDropdown()">▼</button>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <?php if (($_SESSION['user_name']) == "admin") {
                            echo "<a class='editar' href='../paginas/crear_subasta.php'>Crear subasta</a>";
                            echo "<a class='editar' href='../paginas/editar_productos.php'>Editar zapas</a>";
                        } ?>

                        <a class="editar" href="../indice/logout.php" onclick="return confirmLogout()">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="../login/login.php" class="login-icon">
                    <i class="fa fa-user-circle"></i>
                </a>
            <?php endif; ?>
        </div>
    </header>

    <script>
        function toggleNavMenu() {
            const navMenu = document.querySelector('.nav-menu');
            navMenu.classList.toggle('active');
        }

        function toggleDropdown() {
            const dropdownMenu = document.getElementById("dropdownMenu");
            dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
        }

        function confirmLogout() {
            return confirm("¿Estás seguro de que deseas cerrar sesión?");
        }

        // Cerrar el menú desplegable si se hace clic fuera de él
        window.onclick = function (event) {
            if (!event.target.matches('.dropdown-button')) {
                const dropdownMenu = document.getElementById("dropdownMenu");
                if (dropdownMenu && dropdownMenu.style.display === "block") {
                    dropdownMenu.style.display = "none";
                }
            }
        }
    </script>
</body>

</html>