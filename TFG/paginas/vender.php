<?php
include "../indice/header.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    
   
    header('Location: ../login/login.php');
    exit;
    
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tfg";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['delete_id'])) {
    $nombre = $_POST['nombre'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $talla = $_POST['talla'] ?? '';
    $condicion = $_POST['condicion'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $id_usuario = $_SESSION['user_id'];



    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $imagenNombre = basename($imagen['name']);
        $imagenTipo = strtolower(pathinfo($imagenNombre, PATHINFO_EXTENSION));

        $extensionesPermitidas = ['png', 'jpg', 'jpeg'];

        if (in_array($imagenTipo, $extensionesPermitidas)) {
            $rutaDestino = "../imagenes/" . uniqid() . '.' . $imagenTipo;

            if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                $sql = "INSERT INTO sneakers (id_usuario, nombre_sneaker, marca, talla, condicion, precio, descripcion, imagen_url, estado) 
                        VALUES ('$id_usuario', '$nombre', '$marca', '$talla', '$condicion', '$precio', '$descripcion', '$rutaDestino', 'Disponible')";

                if ($conn->query($sql) === TRUE) {
                    $id_sneaker = $conn->insert_id;

                    $sqlRelacion = "INSERT INTO sneakers_usuarios (id_sneaker, id_usuario) VALUES ('$id_sneaker', '$id_usuario')";
                    $conn->query($sqlRelacion);

                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            echo "Tipo de archivo no permitido. Solo se permiten imágenes PNG y JPG.";
        }
    } else {
        echo "Error en la subida de la imagen.";
    }
}

$sqlSneakers = "SELECT s.* FROM sneakers s 
                JOIN sneakers_usuarios su ON s.id_sneaker = su.id_sneaker 
                WHERE su.id_usuario = '{$_SESSION['user_id']}'";
$result = $conn->query($sqlSneakers);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vender_styles.css">
    <title>Vender Zapatillas - KICK IT WITH JJ</title>
</head>


<body>

    <div class="vender-container"><br><br>
        <h1 class="vender-header">Vende tus Zapatillas</h1>
        <form class="vender-form" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre de la Zapatilla:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required>
            </div>

            <div class="form-group">
                <label for="talla">Talla:</label>
                <input type="text" id="talla" name="talla" required>
            </div>

            <div class="form-group">
                <label for="condicion">Condición:</label>
                <select id="condicion" name="condicion" required>
                    <option value="Nuevo">Nuevo</option>
                    <option value="Usado">Usado</option>
                </select>
            </div>

            <div class="form-group">
                <label for="precio">Precio (€):</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen (PNG, JPG):</label>
                <input type="file" id="imagen" name="imagen" accept=".png, .jpg, .jpeg" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>

            <button type="submit">Subir Zapatilla</button>
        </form>

        <h2> Tus zapatillas </h2>
        <div class="sneakers-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="sneaker-card">';
                    echo '<img src="' . $row["imagen_url"] . '" alt="' . $row["nombre_sneaker"] . '">';
                    echo '<h3>' . $row["nombre_sneaker"] . '</h3>';
                    echo '<p>Marca: ' . $row["marca"] . '</p>';
                    echo '<p>Talla: ' . $row["talla"] . '</p>';
                    echo '<p>Precio: €' . number_format($row["precio"], 2) . '</p>';
                    echo '<form action="" method="POST" class="delete-form" onsubmit="return confirmarEliminacion();">';
                    echo '<input type="hidden" name="delete_id" value="' . $row["id_sneaker"] . '">';
                    echo '<button type="submit" class="delete-button">Eliminar</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<p>No has subido ninguna zapatilla todavía.</p>';
            }
            ?>

        </div>
    </div>
  <?php include '../indice/footer.php'; ?>
</body>
<script>
    function confirmarEliminacion() {
        return confirm("¿Estás seguro de que deseas eliminar esta zapatilla?");
    }

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($id_sneaker)) { ?>
        alert("Zapatilla agregada correctamente.");
    <?php } ?>
</script>

</html>
<?php
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sqlDelete = "DELETE FROM sneakers WHERE id_sneaker = '$delete_id'";
    if ($conn->query($sqlDelete) === TRUE) {
        $sqlDeleteRelacion = "DELETE FROM sneakers_usuarios WHERE id_sneaker = '$delete_id'";
        $conn->query($sqlDeleteRelacion);
        echo "<script>alert('Zapatilla eliminada exitosamente.'); window.location.href = window.location.href;</script>";
    } else {
        echo "Error al eliminar la zapatilla: " . $conn->error;
    }
}
$conn->close();
?>