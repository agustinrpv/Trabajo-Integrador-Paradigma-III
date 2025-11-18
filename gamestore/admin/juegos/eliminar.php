<?php
require_once "../../backend/conexion.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM juegos WHERE id_juego = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../index.php");
exit;
?>
