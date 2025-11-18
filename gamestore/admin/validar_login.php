<?php
session_start();
require_once "../backend/conexion.php";

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT id_admin, usuario, password_hash 
        FROM usuarios_admin 
        WHERE usuario = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id_admin, $usuario_db, $password_hash);
$stmt->fetch();

if ($stmt->num_rows == 1 && password_verify($password, $password_hash)) {
    $_SESSION["admin"] = $usuario_db;
    header("Location: index.php");
    exit;
}

header("Location: login.php?error=1");
exit;
?>
