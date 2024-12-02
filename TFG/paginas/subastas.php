<?php
include("../indice/header.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {

    header("location:../login/login.php");
}

// Conectar a la Base de Datos
$conn = new mysqli('localhost', 'root', '', 'tfg');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejar las pujas de los usuarios
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pujar'])) {
    $id_subasta = intval($_POST['id_subasta']);
    $cantidad = floatval($_POST['cantidad']);
    $id_usuario = $_SESSION['user_id']; // ID del usuario logueado

    // Verificar que la subasta exista y esté activa
    $sql_check_subasta = "SELECT * FROM subastas WHERE id_subasta = ? AND estado = 'Activa'";
    $stmt = $conn->prepare($sql_check_subasta);
    $stmt->bind_param("i", $id_subasta);
    $stmt->execute();
    $result_subasta = $stmt->get_result();

    if ($result_subasta->num_rows > 0) {
        $subasta = $result_subasta->fetch_assoc();
        $precio_actual = $subasta['precio_actual'];
        $precio_maximo = 10000; // Limitar la puja máxima a 10,000 euros

        // Verificar que la cantidad ingresada sea lógica
        if ($cantidad <= 0) {
            echo "<script>alert('La cantidad debe ser mayor que cero.');</script>";
        } elseif ($cantidad <= $precio_actual) {
            echo "<script>alert('La cantidad debe ser mayor que la oferta actual.');</script>";
        } elseif ($cantidad > $precio_maximo) {
            echo "<script>alert('La cantidad no debe superar los 10,000 euros.');</script>";
        } else {
            // Actualizar la subasta con la nueva puja
            $sql_update_puja = "UPDATE subastas SET precio_actual = ?, id_ganador = ? WHERE id_subasta = ?";
            $stmt_update = $conn->prepare($sql_update_puja);
            $stmt_update->bind_param("dii", $cantidad, $id_usuario, $id_subasta);

            if ($stmt_update->execute()) {
                echo "<script>alert('¡Puja realizada con éxito!'); window.location.href='subastas.php';</script>";
            } else {
                echo "<script>alert('Error al realizar la puja');</script>";
            }
        }
    } else {
        echo "<script>alert('La subasta no está disponible o ha finalizado.');</script>";
    }
}

// Obtener las subastas activas
$sql_subastas_activas = "SELECT s.*, sn.nombre_sneaker, sn.imagen_url, u.nombre AS pujador_nombre
                         FROM subastas s
                         JOIN sneakers sn ON s.id_sneaker = sn.id_sneaker
                         LEFT JOIN usuarios u ON s.id_ganador = u.id_usuario
                         WHERE s.estado = 'Activa'";
$result_subastas_activas = $conn->query($sql_subastas_activas);

// Obtener las subastas finalizadas
$sql_subastas_finalizadas = "SELECT s.*, sn.nombre_sneaker, sn.imagen_url, u.nombre AS ganador_nombre
                             FROM subastas s
                             JOIN sneakers sn ON s.id_sneaker = sn.id_sneaker
                             LEFT JOIN usuarios u ON s.id_ganador = u.id_usuario
                             WHERE s.estado = 'Finalizada'";
$result_subastas_finalizadas = $conn->query($sql_subastas_finalizadas);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="subastas_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>Subastas Activas y Finalizadas - KICK IT WITH JJ</title>
</head>

<body>

    <div class="texto-zapas"><h1>Subastas Activas</h1></div>
    <?php if ($result_subastas_activas->num_rows > 0): ?>
        <div class="contenedor-subastas">
        <?php while ($subasta = $result_subastas_activas->fetch_assoc()): ?>
           
                <div class="auction-container">
                    <h2 class="auction-title"><?php echo htmlspecialchars($subasta['nombre_sneaker']); ?></h2>
                    <img src="../imagenes/<?php echo htmlspecialchars($subasta['imagen_url']); ?>"
                        alt="<?php echo htmlspecialchars($subasta['nombre_sneaker']); ?>" class="auction-image">
                    <div class="auction-info">Precio Inicial:
                        <span>€<?php echo number_format($subasta['precio_inicial'], 2); ?></span>
                    </div>
                    <div class="auction-info">Precio Actual: <span
                            id="precio-actual-<?php echo $subasta['id_subasta']; ?>">€<?php echo number_format($subasta['precio_actual'], 2); ?></span>
                    </div>
                    <div class="auction-info">Pujador Actual: <span
                            id="pujador-actual-<?php echo $subasta['id_subasta']; ?>"><?php echo htmlspecialchars($subasta['pujador_nombre'] ?? 'Nadie aún'); ?></span>
                    </div>
                    <div class="auction-info">Estado de Subasta:
                        <span><?php echo htmlspecialchars($subasta['estado']); ?></span>
                    </div>
                    <form class="auction-form" method="POST">
                        <input type="hidden" name="id_subasta" value="<?php echo $subasta['id_subasta']; ?>">
                        <input type="number" step="0.01" name="cantidad" placeholder="Monto a pujar" required>
                        <button type="submit" name="pujar">Participar</button>
                    </form>
                </div>
            
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No hay subastas activas en este momento.</p>
    <?php endif; ?>

    <div class="texto-zapas"><h1>Subastas Finalizadas</h1></div>
    <?php if ($result_subastas_finalizadas->num_rows > 0): ?>
        <table class="auction-table">
            <thead>
                <tr>
                    <th>Nombre de la Zapatilla</th>
                    <th>Precio Inicial</th>
                    <th>Precio Final</th>
                    <th>Ganador</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($subasta = $result_subastas_finalizadas->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($subasta['nombre_sneaker']); ?></td>
                        <td>€<?php echo number_format($subasta['precio_inicial'], 2); ?></td>
                        <td>€<?php echo number_format($subasta['precio_actual'], 2); ?></td>
                        <td><?php echo htmlspecialchars($subasta['ganador_nombre'] ?? 'Sin ganador'); ?></td>
                        <td><?php echo htmlspecialchars($subasta['estado']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <br>
        </table>
    <?php else: ?>
        <p>No hay subastas finalizadas en este momento.</p>
    <?php endif; ?>

    <?php include("../indice/footer.php") ?>
</body>

</html>

<style>
    .auction-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .auction-table th,
    .auction-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    .auction-table th {
        background-color: #7a6e5d;
        color: #f5f5f0;
    }

    .auction-image-table {
        width: 100px;
        height: auto;
        border-radius: 10px;
    }
</style>