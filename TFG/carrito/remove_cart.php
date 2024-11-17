<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['index'])) {
    $index = $_POST['index'];
    
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindexar el carrito
    }

    $total = 0;
    foreach ($_SESSION['cart'] as $product) {
        $total += $product['precio'] * $product['cantidad'];
    }

    echo json_encode([
        'success' => true,
        'total' => number_format($total, 2)
    ]);
}
?>
