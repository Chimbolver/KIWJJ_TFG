<!-- header.php -->
<?php
 $conn = new mysqli('localhost', 'root', '', 'tfg');

 if ($conn->connect_error) {
     die("Error de conexión: " . $conn->connect_error);
 }

session_start();
?>

<header class="header">
    <div class="logo">
        <a href="index.php"><img src="../login/logo.png" alt="Logo de KICK IT WITH JJ"></a>
    </div>
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="tienda.php">Tienda</a></li>
            <li><a href="subastas.php">Subastas</a></li>
            <li><a href="raffles.php">Raffles</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="administrar.php">Administrar</a></li>
            <?php endif; ?>
        </ul>
        <div class="cta">
            <?php if (isset($_SESSION['nombre'])): ?>
                <span class="welcome-msg">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</span>
                <a href="logout.php" class="button">Cerrar Sesión</a>
            <?php else: ?>
                <a href="../login/login.php" class="button">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
        <div class="hamburger" onclick="toggleMenu()">☰</div>
    </nav>
</header>
