<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['index'])) {
        $index = intval($_POST['index']);
        $product = $_SESSION['cart'][$index];
    } else {
        header('Location: carrito.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $index = intval($_POST['index']);
    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    // Actualizar el producto en el carrito
    $_SESSION['cart'][$index]['nombre'] = $nombre;
    $_SESSION['cart'][$index]['precio'] = $precio;
    $_SESSION['cart'][$index]['cantidad'] = $cantidad;

    header('Location: carrito.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="carrito_styles.css">
    <title>Editar Producto - KICK IT WITH JJ</title>
</head>

<body>
    <?php include '../indice/header.php'; ?>

    <div class="edit-container">
        <h1>Editar Producto</h1>
        <form action="edit_cart.php" method="POST">
            <input type="hidden" name="index" value="<?php echo $index; ?>">

            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $product['nombre']; ?>" required>

            <label for="precio">Precio (€):</label>
            <input type="number" id="precio" name="precio" value="<?php echo $product['precio']; ?>" min="0" step="0.01" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="<?php echo $product['cantidad']; ?>" min="1" required>

            <button type="submit" name="save">Guardar Cambios</button>
        </form>
    </div>

    <?php include '../indice/footer.php'; ?>
</body>

</html>
