<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Admin - Login</title>
<link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<main class="container section">
<h2>Iniciar sesión (Admin)</h2>

<form action="validar_login.php" method="POST" class="form">
    
    <label>Usuario:</label>
    <input type="text" name="usuario" required>

    <label>Contraseña:</label>
    <input type="password" name="password" autocomplete="off" required>

    <button class="btn">Ingresar</button>
</form>
</main>
</body>
</html>
