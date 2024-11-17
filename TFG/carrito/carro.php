<?php
include '../indice/header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    if (isset($_COOKIE['cart'])) {
        $_SESSION['cart'] = json_decode($_COOKIE['cart'], true);
    } else {
        $_SESSION['cart'] = [];
    }
}

$conn = new mysqli('localhost', 'root', '', 'tfg');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
function saveCartToCookie() {
    setcookie('cart', json_encode($_SESSION['cart']), time() + (86400 * 30), "/"); // Expira en 30 días
}

if (isset($_POST['remove'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['cart'][$index])) {
        $productId = $_SESSION['cart'][$index]['id'];
        $cantidadEliminada = $_SESSION['cart'][$index]['cantidad'];

        $sqlUpdateStock = "UPDATE sneakers SET stock = stock + $cantidadEliminada WHERE id_sneaker = $productId";
        $conn->query($sqlUpdateStock);

        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        saveCartToCookie();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['update'])) {
    $index = $_POST['index'];
    $cantidad = intval($_POST['cantidad']);

    if (isset($_SESSION['cart'][$index]) && $cantidad > 0) {
        $productId = $_SESSION['cart'][$index]['id'];

        $sql = "SELECT stock FROM sneakers WHERE id_sneaker = $productId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $stockDisponible = $product['stock'];

            if ($cantidad <= ($stockDisponible + $_SESSION['cart'][$index]['cantidad'])) {
                $diferencia = $cantidad - $_SESSION['cart'][$index]['cantidad'];
                if ($diferencia <= $stockDisponible) {
                    $_SESSION['cart'][$index]['cantidad'] = $cantidad;

                    $sqlUpdateStock = "UPDATE sneakers SET stock = stock - $diferencia WHERE id_sneaker = $productId";
                    $conn->query($sqlUpdateStock);

                    saveCartToCookie();
                } else {
                    echo "<script>alert('La cantidad solicitada supera el stock disponible.');</script>";
                }
            } else {
                echo "<script>alert('La cantidad solicitada supera el stock disponible.');</script>";
            }
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="carrito_styles.css">
    <title>Carrito de Compras - KICK IT WITH JJ</title>
    <script>
        function updateCart(index) {
            const cantidad = document.getElementById('cantidad-' + index).value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    location.reload(); 
                }
            };
            xhr.send('update=true&index=' + index + '&cantidad=' + cantidad);
        }

        function removeCartItem(index) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    location.reload();
                }
            };
            xhr.send('remove=true&index=' + index);
        }
    </script>
</head>

<body>

    <div class="carta-container">
        <h1>Carrito de Compras</h1>
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $index => $product):
                        $productTotal = $product['precio'] * $product['cantidad'];
                        $total += $productTotal;
                    ?>
                    <tr id="cart-item-<?php echo $index; ?>">
                        <td><?php echo htmlspecialchars($product['nombre']); ?></td>
                        <td>€<?php echo number_format($product['precio'], 2); ?></td>
                        <td>
                            <?php echo $index; ?><?php echo $product['cantidad']; ?>
                          
                        </td>
                        <td id="product-total-<?php echo $index; ?>">€<?php echo number_format($productTotal, 2); ?></td>
                        <td>
                            <button onclick="removeCartItem(<?php echo $index; ?>)">Eliminar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-total">
                <h3 id="cart-total">Total: €<?php echo number_format($total, 2); ?></h3>
                <a href="checkout.php" class="checkout-button">Proceder al Pago</a>
            </div>
        <?php else: ?>
            <div class="empty-cart-message">
                <p>Tu carrito está vacío.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php include '../indice/footer.php'; ?>
</body>

</html>
