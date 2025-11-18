<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

require_once "../backend/conexion.php";

$sql = "SELECT id_juego, titulo, plataforma, precio FROM juegos ORDER BY id_juego ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Administración</title>
<link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<main class="container section">

<h2>Panel de Administración</h2>

<a class="btn btn-primary" href="juegos/agregar_juego.php">+ Agregar juego</a>
<a class="btn btn-secondary" href="logout.php">Cerrar sesión</a>

<br><br>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Plataforma</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row["id_juego"] ?></td>
            <td><?= $row["titulo"] ?></td>
            <td><?= $row["plataforma"] ?></td>
            <td>$<?= number_format($row["precio"], 2) ?></td>

            <td>
                <a class="btn btn-edit" 
                   href="juegos/editar.php?id=<?= $row['id_juego'] ?>">Editar</a>

                <a class="btn btn-delete" 
                   href="juegos/eliminar.php?id=<?= $row['id_juego'] ?>"
                   onclick="return confirm('¿Seguro que quieres eliminar este juego?');">
                   Eliminar
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</main>
</body>
</html>
