<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['index']) && isset($_POST['cantidad'])) {
    $index = $_POST['index'];
    $cantidad = intval($_POST['cantidad']);
    
    if (isset($_SESSION['cart'][$index]) && $cantidad > 0) {
        $_SESSION['cart'][$index]['cantidad'] = $cantidad;

        $productTotal = $_SESSION['cart'][$index]['precio'] * $cantidad;
        $total = 0;

        foreach ($_SESSION['cart'] as $product) {
            $total += $product['precio'] * $product['cantidad'];
        }

        echo json_encode([
            'productTotal' => number_format($productTotal, 2),
            'total' => number_format($total, 2)
        ]);
    }
}
?>
