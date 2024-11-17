<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tfg');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    
    // Obtener el producto desde la base de datos
    $sql = "SELECT * FROM sneakers WHERE id_sneaker = $productId AND estado = 'Disponible'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        if ($product['stock'] > 0) {
            // Reducir el stock en la base de datos
            $newStock = $product['stock'] - 1;
            $sqlUpdate = "UPDATE sneakers SET stock = $newStock WHERE id_sneaker = $productId";
            $conn->query($sqlUpdate);

            // Añadir al carrito en la sesión
            $cartItem = [
                'id' => $product['id_sneaker'],
                'nombre' => $product['nombre_sneaker'],
                'precio' => $product['precio'],
                'cantidad' => 1
            ];

            if (isset($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];

                // Verificar si el producto ya está en el carrito
                $productExists = false;
                foreach ($cart as &$item) {
                    if ($item['id'] == $productId) {
                        $item['cantidad']++;
                        $productExists = true;
                        break;
                    }
                }

                if (!$productExists) {
                    $cart[] = $cartItem;
                }

                $_SESSION['cart'] = $cart;
            } else {
                $_SESSION['cart'] = [$cartItem];
            }

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'out_of_stock']);
        }
    } else {
        echo json_encode(['status' => 'error']);
    }
}

$conn->close();
?>
