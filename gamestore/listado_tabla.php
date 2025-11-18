<?php
session_start();
require_once "backend/conexion.php";

$result = $conn->query("SELECT * FROM juegos ORDER BY id_juego");
$juegos = $result->fetch_all(MYSQLI_ASSOC);

$carrito = $_SESSION['carrito'] ?? [];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Listado (Tabla) – GameStore Digital</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<header class="header">
  <nav class="container nav">
    <div class="brand"><span class="dot"></span> GameStore Digital</div>
    <div class="nav-links">
      <a href="index.php">Inicio</a>
      <a href="listado_tabla.php" aria-current="page">Listado (Tabla)</a>
      <a href="listado_box.php">Listado (Box)</a>
      <a href="comprar.php">
        Comprar
        <?php if ($carrito): ?>
          <span class="tag" style="margin-left:4px;">
            <?= array_sum(array_column($carrito, 'cantidad')) ?>
          </span>
        <?php endif; ?>
      </a>
    </div>
  </nav>
</header>

<main class="container section">
  <h2>Listado en Tabla</h2>

  <div class="table-wrapper">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Plataforma</th>
          <th>Precio</th>
          <th>Ver / Carrito</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($juegos as $juego): ?>
          <tr>
            <td><?= $juego['id_juego'] ?></td>
            <td><?= htmlspecialchars($juego['titulo']) ?></td>
            <td><?= htmlspecialchars($juego['plataforma']) ?></td>
            <td>$<?= number_format($juego['precio'], 2, ',', '.') ?></td>
            <td>
              <a class="btn small secondary" href="producto.php?id=<?= $juego['id_juego'] ?>">Abrir</a>
              <a class="btn small" href="carrito.php?accion=agregar&id=<?= $juego['id_juego'] ?>">Carrito</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<footer class="footer">
  <div class="container row">
    <span class="small">© 2025 GameStore Digital</span>
    <span class="small">Soporte: contacto@gamestoredigital.com</span>
  </div>
</footer>
</body>
</html>
