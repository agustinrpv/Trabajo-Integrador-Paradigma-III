<?php
require_once "../../backend/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $plataforma = $_POST['plataforma'];
    $genero = $_POST['genero'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen'];

    $stmt = $conn->prepare("INSERT INTO juegos (titulo, plataforma, genero, precio, descripcion, imagen) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdss", $titulo, $plataforma, $genero, $precio, $descripcion, $imagen);
    $stmt->execute();

    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agregar juego</title>
<link rel="stylesheet" href="../../css/styles.css">
</head>
<body>

<h2>Agregar nuevo juego</h2>

<form method="POST">
    <label>Título:</label>
    <input type="text" name="titulo" required>

    <label>Plataforma:</label>
    <input type="text" name="plataforma" required>

    <label>Género:</label>
    <input type="text" name="genero" required>

    <label>Precio:</label>
    <input type="number" step="0.01" name="precio" required>

    <label>Descripción:</label>
    <textarea name="descripcion" required></textarea>

    <label>Nombre de la imagen (ej: gow-ragnarok.jpg):</label>
    <input type="text" name="imagen" required>

    <button class="btn">Guardar</button>
</form>

</body>
</html>
