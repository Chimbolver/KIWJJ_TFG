<?php
include("../indice/header.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_name'] !== 'admin') {
    die("Acceso denegado: solo el administrador puede acceder a esta página.");
}

$conn = new mysqli('localhost', 'root', '', 'tfg');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_producto'])) {
    $nombre_sneaker = $_POST['nombre_sneaker'];
    $marca = $_POST['marca'];
    $talla = $_POST['talla'];
    $condicion = $_POST['condicion'];
    $precio = floatval($_POST['precio']);
    $descripcion = $_POST['descripcion'];
    $stock = intval($_POST['stock']);
    $imagen = $_FILES['imagen'];

    // Verificar que se subió una imagen
    if ($imagen['error'] === UPLOAD_ERR_OK) {
        $imagenData = file_get_contents($imagen['tmp_name']); // Convierte la imagen a binario
        $sql_insert_producto = "INSERT INTO sneakers (nombre_sneaker, marca, talla, condicion, precio, descripcion, stock, imagen_url, estado) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Disponible')";
        $stmt = $conn->prepare($sql_insert_producto);
        $stmt->bind_param("ssssdiss", $nombre_sneaker, $marca, $talla, $condicion, $precio, $descripcion, $stock, $imagenData);

        if ($stmt->execute()) {
            echo "<script>alert('Producto creado exitosamente'); window.location.href='editar_productos.php';</script>";
        } else {
            echo "<script>alert('Error al crear el producto');</script>";
        }
    } else {
        echo "<script>alert('Error al subir la imagen.');</script>";
    }
}

// Manejar el borrado de producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_producto'])) {
    $id_sneaker = intval($_POST['id_sneaker']);
    if ($id_sneaker > 0) {
        $sql_delete_producto = "DELETE FROM sneakers WHERE id_sneaker = ?";
        $stmt = $conn->prepare($sql_delete_producto);
        $stmt->bind_param("i", $id_sneaker);
        if ($stmt->execute()) {
            echo "<script>alert('Producto eliminado exitosamente'); window.location.href='editar_productos.php';</script>";
        } else {
            echo "<script>alert('Error al eliminar el producto');</script>";
        }
    }
}

// Manejar la edición de producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar_producto'])) {
    $id_sneaker = intval($_POST['id_sneaker']);
    $nombre_sneaker = $_POST['nombre_sneaker'];
    $marca = $_POST['marca'];
    $talla = $_POST['talla'];
    $condicion = $_POST['condicion'];
    $precio = floatval($_POST['precio']);
    $descripcion = $_POST['descripcion'];

    if ($id_sneaker > 0 && $nombre_sneaker && $marca && $talla && $condicion && $precio > 0) {
        $sql_update_producto = "UPDATE sneakers SET nombre_sneaker = ?, marca = ?, talla = ?, condicion = ?, precio = ?, descripcion = ? WHERE id_sneaker = ?";
        $stmt = $conn->prepare($sql_update_producto);
        $stmt->bind_param("ssssdsi", $nombre_sneaker, $marca, $talla, $condicion, $precio, $descripcion, $id_sneaker);

        if ($stmt->execute()) {
            echo "<script>alert('Producto actualizado exitosamente'); window.location.href='editar_productos.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar el producto');</script>";
        }
    } else {
        echo "<script>alert('Por favor, completa todos los campos correctamente.');</script>";
    }
}

// Obtener todos los productos
$sql_productos = "SELECT * FROM sneakers";
$result_productos = $conn->query($sql_productos);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editar_productos_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>Editar Productos - KICK IT WITH JJ</title>
</head>

<body>
    <div class="contenedor-form">
        <div class="form-container">
            <h2 class="form-title">Agregar Nuevo Producto</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre_sneaker">Nombre del Producto:</label>
                    <input type="text" name="nombre_sneaker" id="nombre_sneaker" required>
                </div>
                <div class="form-group">
                    <label for="marca">Marca:</label>
                    <input type="text" name="marca" id="marca" required>
                </div>
                <div class="form-group">
                    <label for="talla">Talla:</label>
                    <input type="text" name="talla" id="talla" required>
                </div>
                <div class="form-group">
                    <label for="condicion">Condición:</label>
                    <select name="condicion" id="condicion" required>
                        <option value="Nuevo">Nuevo</option>
                        <option value="Usado">Usado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio">Precio (€):</label>
                    <input type="number" step="0.01" name="precio" id="precio" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="number" name="stock" id="stock" required>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen:</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*" required>
                </div>
                <button type="submit" name="crear_producto">Agregar Producto</button>
            </form>
        </div>
    </div>
    <div class="contenedor-form">
        <div class="product-list">
            <h2 class="form-title">Productos Disponibles</h2>
            <?php if ($result_productos->num_rows > 0): ?>
                <?php while ($producto = $result_productos->fetch_assoc()): ?>
                    <div class="product-item">
                        <form method="POST">
                            <input type="hidden" name="id_sneaker" value="<?php echo $producto['id_sneaker']; ?>">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" name="nombre_sneaker"
                                    value="<?php echo htmlspecialchars($producto['nombre_sneaker']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Marca:</label>
                                <input type="text" name="marca" value="<?php echo htmlspecialchars($producto['marca']); ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Talla:</label>
                                <input type="text" name="talla" value="<?php echo htmlspecialchars($producto['talla']); ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Condición:</label>
                                <select name="condicion" required>
                                    <option value="Nuevo" <?php echo $producto['condicion'] === 'Nuevo' ? 'selected' : ''; ?>>
                                        Nuevo</option>
                                    <option value="Usado" <?php echo $producto['condicion'] === 'Usado' ? 'selected' : ''; ?>>
                                        Usado</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Precio (€):</label>
                                <input type="number" step="0.01" name="precio"
                                    value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción:</label>
                                <textarea name="descripcion"
                                    rows="4"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                            </div>
                            <button type="submit" name="editar_producto">Editar</button>
                            <button type="submit" name="eliminar_producto"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay productos disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include("../indice/footer.php"); ?>
</body>

</html>