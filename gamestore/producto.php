<?php
session_start();
require_once "backend/conexion.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM juegos WHERE id_juego = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$juego = $stmt->get_result()->fetch_assoc();

if (!$juego) {
    die("Juego no encontrado.");
}

$carrito = $_SESSION['carrito'] ?? [];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($juego['titulo']) ?> – GameStore Digital</title>
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
  <article class="card card-producto">
    <img src="assets/<?= htmlspecialchars($juego['imagen']) ?>"
         alt="<?= htmlspecialchars($juego['titulo']) ?>"
         class="card-thumb-lg">

    <div class="body">
      <h1><?= htmlspecialchars($juego['titulo']) ?></h1>
      <p><strong>Plataforma:</strong> <?= htmlspecialchars($juego['plataforma']) ?></p>
      <?php if (!empty($juego['genero'])): ?>
        <p><strong>Género:</strong> <?= htmlspecialchars($juego['genero']) ?></p>
      <?php endif; ?>
      <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($juego['descripcion'])) ?></p>
      <p style="margin-top:1rem;font-size:1.2rem;">
        <strong>Precio: </strong>
        $<?= number_format($juego['precio'], 2, ',', '.') ?>
      </p>

      <div class="actions" style="margin-top:1rem;">
        <a class="btn" href="carrito.php?accion=agregar&id=<?= $juego['id_juego'] ?>">Agregar al carrito</a>
        <a class="btn secondary" href="listado_box.php">Volver al catálogo</a>
      </div>
    </div>
  </article>
</main>

<footer class="footer">
  <div class="container row">
    <span class="small">© 2025 GameStore Digital</span>
    <span class="small">Soporte: contacto@gamestoredigital.com</span>
  </div>
</footer>
</body>
</html>
