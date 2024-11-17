<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="checkout_styles.css">
    <title>Checkout - KICK IT WITH JJ</title>
</head>

<body>
    <?php include '../indice/header.php'; ?>

    <div class="checkout-container">
        <h1>Resumen del Pedido</h1>
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <div class="checkout-summary">
                <table class="checkout-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $product):
                            $productTotal = $product['precio'] * $product['cantidad'];
                            $total += $productTotal;
                        ?>
                        <tr>
                            <td><?php echo $product['nombre']; ?></td>
                            <td>€<?php echo number_format($product['precio'], 2); ?></td>
                            <td><?php echo $product['cantidad']; ?></td>
                            <td>€<?php echo number_format($productTotal, 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="checkout-total">
                    <h3>Total a Pagar: €<?php echo number_format($total, 2); ?></h3>
                </div>
                <button class="confirm-order-button" onclick="confirmOrder()">Confirmar Pedido</button>
            </div>
        <?php else: ?>
            <p>No hay productos en tu carrito.</p>
        <?php endif; ?>
    </div>

    <script>
        function confirmOrder() {
            alert("Pedido confirmado. ¡Gracias por comprar con KICK IT WITH JJ!");
            window.location.href = "index.php";
            <?php unset($_SESSION['cart']); ?>
        }
    </script>

    <?php include '../indice/footer.php'; ?>
</body>

</html>
