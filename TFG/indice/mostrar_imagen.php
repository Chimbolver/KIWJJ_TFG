<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'tfg');

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del producto
$id_sneaker = intval($_GET['id_sneaker']);

// Consulta para obtener la imagen
$sql = "SELECT imagen_url FROM sneakers WHERE id_sneaker = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_sneaker);
$stmt->execute();
$stmt->bind_result($imagen);
$stmt->fetch();
$stmt->close();
$conn->close();

// Si hay datos en $imagen, muestra el contenido binario
if ($imagen) {
    header("Content-Type: image/jpeg"); // Cambia a image/png o image/gif según el formato
    echo $imagen;
} else {
    // Imagen por defecto si no existe
    header("Content-Type: image/jpeg");
    readfile("default.jpg");
}
?>
