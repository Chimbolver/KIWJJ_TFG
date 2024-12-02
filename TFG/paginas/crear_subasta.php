<?php
include("../indice/header.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado y si es 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['user_name'] !== 'admin') {
    die("Acceso denegado: solo el administrador puede acceder a esta página.");
}

// Conectar a la Base de Datos
$conn = new mysqli('localhost', 'root', '', 'tfg');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejar la actualización del estado de la subasta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['finalizar_subasta'])) {
    $id_subasta = intval($_POST['id_subasta']);
    if ($id_subasta > 0) {
        $sql_finalizar_subasta = "UPDATE subastas SET estado = 'Finalizada' WHERE id_subasta = ?";
        $stmt = $conn->prepare($sql_finalizar_subasta);
        $stmt->bind_param("i", $id_subasta);
        if ($stmt->execute()) {
            echo "<script>alert('Subasta finalizada exitosamente'); window.location.href='crear_subasta.php';</script>";
        } else {
            echo "<script>alert('Error al finalizar la subasta');</script>";
        }
    }
}

// Obtener las zapatillas que están disponibles para subasta
$sql_sneakers = "SELECT * FROM sneakers WHERE estado = 'Disponible'";
$result_sneakers = $conn->query($sql_sneakers);

// Manejar el formulario de creación de subasta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_subasta'])) {
    $id_sneaker = $_POST['id_sneaker'];
    $precio_inicial = floatval($_POST['precio_inicial']);

    if ($id_sneaker && $precio_inicial > 0) {
        // Insertar la nueva subasta en la base de datos
        $sql_insert_subasta = "INSERT INTO subastas (id_sneaker, precio_inicial, precio_actual, estado) VALUES (?, ?, ?, 'Activa')";
        $stmt = $conn->prepare($sql_insert_subasta);
        $stmt->bind_param("idd", $id_sneaker, $precio_inicial, $precio_inicial);

        if ($stmt->execute()) {
            echo "<script>alert('Subasta creada exitosamente'); window.location.href='crear_subasta.php';</script>";
        } else {
            echo "<script>alert('Error al crear la subasta');</script>";
        }
    } else {
        echo "<script>alert('Por favor, completa todos los campos correctamente.');</script>";
    }
}

// Manejar el borrado de subasta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_subasta'])) {
    $id_subasta = intval($_POST['id_subasta']);
    if ($id_subasta > 0) {
        $sql_delete_subasta = "DELETE FROM subastas WHERE id_subasta = ?";
        $stmt = $conn->prepare($sql_delete_subasta);
        $stmt->bind_param("i", $id_subasta);
        if ($stmt->execute()) {
            echo "<script>alert('Subasta eliminada exitosamente'); window.location.href='crear_subasta.php';</script>";
        } else {
            echo "<script>alert('Error al eliminar la subasta');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="crear_sub_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>Editar Subastas - KICK IT WITH JJ</title>
</head>

<body>
    <div class="contenedor-form">
        <div class="form-container">
            <h2 class="form-title">Crear Nueva Subasta</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="id_sneaker">Seleccionar Zapatilla:</label>
                    <select name="id_sneaker" id="id_sneaker" required>
                        <option value="">-- Selecciona una zapatilla --</option>
                        <?php if ($result_sneakers->num_rows > 0): ?>
                            <?php while ($sneaker = $result_sneakers->fetch_assoc()): ?>
                                <option value="<?php echo $sneaker['id_sneaker']; ?>">
                                    <?php echo htmlspecialchars($sneaker['nombre_sneaker']) . " (Talla: " . htmlspecialchars($sneaker['talla']) . ")"; ?>
                                </option>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <option value="" disabled>No hay zapatillas disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio_inicial">Precio Inicial (€):</label>
                    <input type="number" step="0.01" name="precio_inicial" id="precio_inicial"
                        placeholder="Introduce el precio inicial" required>
                </div>
                <button type="submit" name="crear_subasta">Crear Subasta</button>
            </form>
        </div>
    </div>
    <div class="contenedor-form">
        <div class="auction-list">
            <h2 class="form-title">Subastas Activas</h2>
            <div class="auction-items-container">
                <?php
                // Conectar a la Base de Datos nuevamente para obtener las subastas activas
                $conn = new mysqli('localhost', 'root', '', 'tfg');

                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                $sql_subastas_activas = "SELECT s.id_subasta, sn.nombre_sneaker, s.precio_actual FROM subastas s JOIN sneakers sn ON s.id_sneaker = sn.id_sneaker WHERE s.estado = 'Activa'";
                $result_subastas_activas = $conn->query($sql_subastas_activas);

                if ($result_subastas_activas->num_rows > 0):
                    while ($subasta = $result_subastas_activas->fetch_assoc()): ?>
                        <div class="auction-item">
                            <span><?php echo htmlspecialchars($subasta['nombre_sneaker']); ?> - Precio Actual:
                                €<?php echo number_format($subasta['precio_actual'], 2); ?></span>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id_subasta" value="<?php echo $subasta['id_subasta']; ?>">
                                <button type="submit" name="finalizar_subasta"
                                    onclick="return confirm('¿Estás seguro de que deseas finalizar esta subasta?');">Finalizar</button>
                                <button type="submit" name="eliminar_subasta"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta subasta?');">Eliminar</button>
                            </form>
                        </div>
                    <?php endwhile;
                else: ?>
                    <p>No hay subastas activas en este momento.</p>
                <?php endif;

                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <?php include("../indice/footer.php"); ?>
</body>

</html>
