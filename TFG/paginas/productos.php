<?php  
include '../indice/header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli('localhost', 'root', '', 'tfg');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener la marca seleccionada
$marcaSeleccionada = isset($_GET['marca']) ? $_GET['marca'] : '';

// Consulta principal con filtro por marca
$sqlSneakers = "SELECT * FROM sneakers WHERE estado = 'Disponible' AND id_sneaker NOT IN (SELECT id_sneaker FROM sneakers_usuarios)";
if ($marcaSeleccionada) {
    $sqlSneakers .= " AND marca = ?";
}
$stmtSneakers = $conn->prepare($sqlSneakers);
if ($marcaSeleccionada) {
    $stmtSneakers->bind_param("s", $marcaSeleccionada);
}
$stmtSneakers->execute();
$resultSneakers = $stmtSneakers->get_result();

// Consulta para zapatillas de usuarios
$sqlSneakersUsuarios = "SELECT s.*, u.nombre as usuario_nombre FROM sneakers_usuarios su 
                        JOIN sneakers s ON su.id_sneaker = s.id_sneaker 
                        JOIN usuarios u ON su.id_usuario = u.id_usuario 
                        WHERE s.estado = 'Disponible'";
if ($marcaSeleccionada) {
    $sqlSneakersUsuarios .= " AND s.marca = ?";
}
$stmtSneakersUsuarios = $conn->prepare($sqlSneakersUsuarios);
if ($marcaSeleccionada) {
    $stmtSneakersUsuarios->bind_param("s", $marcaSeleccionada);
}
$stmtSneakersUsuarios->execute();
$resultSneakersUsuarios = $stmtSneakersUsuarios->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="productos_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Productos - KICK IT WITH JJ</title>
    <style>
        .product-card {
            background-color: #f5f5f0;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 300px;
            transition: transform 0.4s, box-shadow 0.4s, opacity 0.5s;
            opacity: 0.8;
            animation: slideUp 1s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            opacity: 1;
            transition: transform 0.4s, box-shadow 0.4s, opacity 0.4s ease-in-out;
        }

        .product-card img {
            width: 100%;
            height: 180px;
            transition: transform 0.4s ease-in-out;
        }

        .product-card:hover img {
            transform: scale(1.1);
        }

        .add-to-cart {
            background-color: #7a6e5d;
            color: #f5f5f0;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .add-to-cart:hover {
            background-color: #f0ece6;
            color: #3e3e3e;
            transform: scale(1.1);
        }

        .add-to-cart.disabled {
            background-color: #ccc;
            color: #999;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <!-- Formulario de filtro -->
    <div class="filter-container" style="text-align:center; margin-bottom:20px;">
        <form method="GET">
            <label for="marca">Filtrar por marca:</label>
            <select name="marca" id="marca">
                <option value="">Todas</option>
                <option value="NIKE" <?php echo $marcaSeleccionada === 'NIKE' ? 'selected' : ''; ?>>NIKE</option>
                <option value="PUMA" <?php echo $marcaSeleccionada === 'PUMA' ? 'selected' : ''; ?>>PUMA</option>
                <option value="ADIDAS" <?php echo $marcaSeleccionada === 'ADIDAS' ? 'selected' : ''; ?>>ADIDAS</option>
                <option value="BALENCIAGA" <?php echo $marcaSeleccionada === 'BALENCIAGA' ? 'selected' : ''; ?>>BALENCIAGA</option>
                <option value="RICK OWENS" <?php echo $marcaSeleccionada === 'RICK OWENS' ? 'selected' : ''; ?>>RICK OWENS</option>
                <option value="NEW BALANCE" <?php echo $marcaSeleccionada === 'NEW BALANCE' ? 'selected' : ''; ?>>NEW BALANCE</option>
            </select>
            <button type="submit">Aplicar</button>
        </form>
    </div>

    <div class="texto-zapas"><h2 style="text-align:center;">Sneakers Disponibles</h2></div>
    <div class="product-container">

        <?php while ($row = $resultSneakers->fetch_assoc()): ?>
            <div class="product-card" id="product-<?php echo $row['id_sneaker']; ?>">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen_url']); ?>" alt="<?php echo $row['nombre_sneaker']; ?>">
                <div class="product-info">
                    <h3><?php echo $row['nombre_sneaker']; ?></h3>
                    <p>Marca: <?php echo $row['marca']; ?></p>
                    <p>Talla: <?php echo $row['talla']; ?></p>
                    <p>Precio: €<?php echo $row['precio']; ?></p>
                    <p id="stock-<?php echo $row['id_sneaker']; ?>">Stock: <?php echo $row['stock']; ?></p>
                    <button class="add-to-cart" id="button-<?php echo $row['id_sneaker']; ?>" onclick="addToCart(<?php echo $row['id_sneaker']; ?>)">Añadir al Carrito</button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <script>
        function addToCart(productId) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../carrito/add_to_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText.trim());
                    if (response.status === 'success') {
                        alert('Producto añadido al carrito');

                        // Reducir el stock visualmente
                        const stockElement = document.getElementById('stock-' + productId);
                        let currentStock = parseInt(stockElement.innerText.split(': ')[1]);
                        currentStock -= 1;
                        stockElement.innerText = 'Stock: ' + currentStock;

                        // Deshabilitar el botón si el stock llega a 0
                        if (currentStock <= 0) {
                            const button = document.getElementById('button-' + productId);
                            button.classList.add('disabled');
                            button.innerText = 'Agotado';
                            button.disabled = true;
                        }
                    } else if (response.status === 'out_of_stock') {
                        alert('No hay suficiente stock disponible');
                    } else {
                        alert('Hubo un problema al añadir el producto al carrito');
                    }
                }
            };

            xhr.send("product_id=" + productId);
        }
    </script>

    <?php include '../indice/footer.php'; ?>
</body>

</html>

<?php
$stmtSneakers->close();
$stmtSneakersUsuarios->close();
$conn->close();
?>
