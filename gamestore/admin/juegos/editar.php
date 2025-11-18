<?php
require_once "../../backend/conexion.php";

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM juegos WHERE id_juego = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$juego = $result->fetch_assoc();

if (!$juego) {
    die("Juego no encontrado");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $plataforma = $_POST['plataforma'];
    $genero = $_POST['genero'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen'];

    $stmt = $conn->prepare("UPDATE juegos SET titulo=?, plataforma=?, genero=?, precio=?, descripcion=?, imagen=? 
                            WHERE id_juego=?");
    $stmt->bind_param("sssdssi", $titulo, $plataforma, $genero, $precio, $descripcion, $imagen, $id);
    $stmt->execute();

    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar juego</title>
<link rel="stylesheet" href="../../css/styles.css">
</head>
<body>

<h2>Editar juego</h2>

<form method="POST">

    <label>Título:</label>
    <input type="text" name="titulo" value="<?= $juego['titulo'] ?>" required>

    <label>Plataforma:</label>
    <input type="text" name="plataforma" value="<?= $juego['plataforma'] ?>" required>

    <label>Género:</label>
    <input type="text" name="genero" value="<?= $juego['genero'] ?>" required>

    <label>Precio:</label>
    <input type="number" step="0.01" name="precio" value="<?= $juego['precio'] ?>" required>

    <label>Descripción:</label>
    <textarea name="descripcion" required><?= $juego['descripcion'] ?></textarea>

    <label>Imagen:</label>
    <input type="text" name="imagen" value="<?= $juego['imagen'] ?>" required>

    <button class="btn">Guardar cambios</button>
</form>

</body>
</html>
