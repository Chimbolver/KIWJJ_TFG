<?php
session_start();

// Verificar si el carrito tiene productos
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "Tu carrito está vacío. Añade productos antes de proceder al pago.";
    exit;
}
if (!isset($_SESSION['user_id'])) {
    
   
    header('Location: ../login/login.php');
    exit;
    
}

// Calcular el total desde el carrito
$total = 0;
foreach ($_SESSION['cart'] as $product) {
    $total += $product['precio'] * $product['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <script src="https://www.paypal.com/sdk/js?client-id=AbxlCyKkthvLSNTahiNEtiTSHxsMlm8e2EIt91MsBLdwhS9kgPDLJw4wSYfRwsnTXJ0-rUQvSVWsx7_Q&currency=EUR"></script>
    <link rel="stylesheet" href="../estilos/completado.css">
    <style>
    /* General Styles */
    body {
        font-family: Georgia, 'Times New Roman', Times, serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4; /* Fondo suave */
        color: #333; /* Texto legible */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    h1 {
        font-size: 1.5rem;
        color: #3e3e3e; /* Tono marrón oscuro */
        text-align: center;
    }

    p {
        font-size: 1.2rem;
        margin: 20px 0;
        color: #3e3e3e;
    }

    /* Container for PayPal Button */
    #paypal-button-container {
        margin-top: 20px;
    }

    /* Back Button */
    .btn-back {
        display: inline-block;
        margin-top: 30px;
        padding: 12px 25px;
        font-size: 1rem;
        font-weight: bold;
        text-decoration: none;
        color: #fff;
        background-color: #3e3e3e; /* Botón marrón oscuro */
        border-radius: 25px;
        transition: background-color 0.3s ease, transform 0.3s ease;
        text-align: center;
    }

    .btn-back:hover {
        background-color: #cfe2a5; /* Hover color verde claro */
        color: #3e3e3e;
        transform: scale(1.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        h1 {
            font-size: 1.2rem;
        }

        p {
            font-size: 1rem;
        }

        .btn-back {
            font-size: 0.9rem;
            padding: 10px 20px;
        }
    }

    @media (max-width: 480px) {
        h1 {
            font-size: 1rem;
        }

        p {
            font-size: 0.8rem;
        }

        .btn-back {
            font-size: 0.8rem;
            padding: 8px 15px;
        }
    }
</style>

</head>
<body>
    <h1>Elige el método de pago:</h1>
    <p>Total: €<?= number_format($total, 2) ?></p>
    <div id="paypal-button-container"></div>
    <a href="../carrito/carro.php" class="btn-back">Volver al carrito</a>  
    <script>
        paypal.Buttons({
            style: {
                shape: 'pill',
                label: 'pay',
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= number_format($total, 2, '.', '') ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    fetch('completar_pago.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ orderID: data.orderID })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Compra completada con éxito');
                            window.location.href = 'completado.php';
                        } else {
                            alert('Error al completar la compra: ' + data.message);
                        }
                    });
                });
            },
            onCancel: function(data) {
                alert("Pago cancelado");
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
