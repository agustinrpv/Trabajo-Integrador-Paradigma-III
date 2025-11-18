<?php
session_start();
require_once "backend/conexion.php";

// Traigo algunos juegos para "Destacados"
$result = $conn->query("SELECT * FROM juegos ORDER BY id_juego LIMIT 3");
$juegos = $result->fetch_all(MYSQLI_ASSOC);

$carrito = $_SESSION['carrito'] ?? [];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>GameStore Digital – PS4/PS5</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<header class="header">
  <nav class="container nav">
    <div class="brand"><span class="dot"></span> GameStore Digital</div>
    <div class="nav-links">
      <a href="index.php" aria-current="page">Inicio</a>
      <a href="listado_tabla.php">Listado (Tabla)</a>
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

<main class="container">
  <section class="hero">
    <div class="card">
      <div>
        <span class="badge">PS4 • PS5 • Entregas digitales</span>
        <h1>Los mejores juegos, al mejor precio.</h1>
        <p>Catálogo curado de títulos para PlayStation 4 y 5. Comprá online y recibí tu licencia digital en minutos.</p>
        <div class="center">
          <a class="btn" href="listado_box.php">Ver catálogo</a>
          <a class="btn secondary" href="listado_tabla.php">Ver en tabla</a>
        </div>
      </div>
      <img src="assets/spiderman2.jpg" alt="Spider-Man 2"
           style="border-radius:12px;border:1px solid rgba(255,255,255,.08)">
    </div>
  </section>

  <section class="section">
    <h2>Destacados</h2>
    <div class="grid">
      <?php foreach ($juegos as $juego): ?>
        <article class="card">
          <img src="assets/<?= htmlspecialchars($juego['imagen']) ?>"
               alt="<?= htmlspecialchars($juego['titulo']) ?>">
          <div class="body">
            <h3><?= htmlspecialchars($juego['titulo']) ?></h3>
            <div class="meta">
              <span class="tag"><?= htmlspecialchars($juego['plataforma']) ?></span>
              <?php if (!empty($juego['genero'])): ?>
                <span class="tag"><?= htmlspecialchars($juego['genero']) ?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="footer">
            <span class="price">
              $<?= number_format($juego['precio'], 2, ',', '.') ?>
            </span>
            <div class="actions">
              <a class="btn secondary" href="producto.php?id=<?= $juego['id_juego'] ?>">Ver ficha</a>
              <a class="btn" href="carrito.php?accion=agregar&id=<?= $juego['id_juego'] ?>">
                Agregar al carrito
              </a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>
</main>

<footer class="footer">
  <div class="container row">
    <span class="small">© 2025 GameStore Digital</span>
    <span class="small">Soporte: contacto@gamestoredigital.com</span>
  </div>
</footer>
</body>
</html>
