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
  <title>Listado (Box) – GameStore Digital</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<header class="header">
  <nav class="container nav">
    <div class="brand"><span class="dot"></span> GameStore Digital</div>
    <div class="nav-links">
      <a href="index.php">Inicio</a>
      <a href="listado_tabla.php">Listado (Tabla)</a>
      <a href="listado_box.php" aria-current="page">Listado (Box)</a>
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
  <h2>Juegos Disponibles</h2>

  <?php foreach ($juegos as $juego): ?>
    <article class="card card-row">
      <img src="assets/<?= htmlspecialchars($juego['imagen']) ?>"
           alt="<?= htmlspecialchars($juego['titulo']) ?>"
           class="card-thumb">

      <div class="body">
        <h3><?= htmlspecialchars($juego['titulo']) ?></h3>
        <p><?= htmlspecialchars($juego['descripcion']) ?></p>
        <div class="meta">
          <span class="tag"><?= htmlspecialchars($juego['plataforma']) ?></span>
          <?php if (!empty($juego['genero'])): ?>
            <span class="tag"><?= htmlspecialchars($juego['genero']) ?></span>
          <?php endif; ?>
        </div>
      </div>

      <div class="footer">
        <span class="price">$<?= number_format($juego['precio'], 2, ',', '.') ?></span>
        <div class="actions">
          <a class="btn secondary" href="producto.php?id=<?= $juego['id_juego'] ?>">Ver más</a>
          <a class="btn" href="carrito.php?accion=agregar&id=<?= $juego['id_juego'] ?>">Agregar al carrito</a>
        </div>
      </div>
    </article>
  <?php endforeach; ?>
</main>

<footer class="footer">
  <div class="container row">
    <span class="small">© 2025 GameStore Digital</span>
    <span class="small">Soporte: contacto@gamestoredigital.com</span>
  </div>
</footer>
</body>
</html>
