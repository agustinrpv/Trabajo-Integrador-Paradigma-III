<?php
session_start();
require_once "backend/conexion.php";

$carrito = $_SESSION['carrito'] ?? [];
$total = 0;

// Procesar compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validaciones
    $nombre = trim($_POST['nombre']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $pago = trim($_POST['pago']);

    if ($nombre !== "" && $direccion !== "" && $telefono !== "" && $email !== "" && $pago !== "" && !empty($carrito)) {
        // Simulación de compra exitosa
        $_SESSION['carrito'] = []; // vacía carrito

        echo "<script>alert('¡Compra realizada con éxito! Gracias por tu pedido.'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error: completá todos los campos y asegurate de tener productos en el carrito.');</script>";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Formulario de compra – GameStore Digital</title>
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
      <a href="comprar.php" aria-current="page">
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
  <h2>Formulario de compra</h2>
  <p class="lead">Completá tus datos y revisá tu selección.</p>

  <!-- TABLA DEL CARRITO -->
  <div class="table-wrapper">
    <table class="table">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Plataforma</th>
          <th>Cantidad</th>
          <th>Precio unitario</th>
          <th>Subtotal</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($carrito): ?>
          <?php foreach ($carrito as $item): ?>
            <?php
              $subtotal = $item['precio'] * $item['cantidad'];
              $total += $subtotal;
            ?>
            <tr>
              <td><?= htmlspecialchars($item['titulo']) ?></td>
              <td><?= htmlspecialchars($item['plataforma']) ?></td>
              <td><?= $item['cantidad'] ?></td>
              <td>$<?= number_format($item['precio'], 2, ',', '.') ?></td>
              <td>$<?= number_format($subtotal, 2, ',', '.') ?></td>
              <td>
                <a class="btn small danger"
                   href="carrito.php?accion=eliminar&id=<?= $item['id'] ?>">
                  Eliminar
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align:center;">El carrito está vacío.</td>
          </tr>
        <?php endif; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" style="text-align:right;font-weight:bold">TOTAL:</td>
          <td>$<?= number_format($total, 2, ',', '.') ?></td>
          <td>
            <?php if ($carrito): ?>
              <a href="carrito.php?accion=vaciar" class="btn small danger">Vaciar carrito</a>
            <?php endif; ?>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>

  <!-- FORMULARIO SOLO SI HAY PRODUCTOS -->
  <?php if ($carrito): ?>
  <form class="form" action="" method="post">

    <label for="nombre">Nombre y apellido</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="direccion">Dirección</label>
    <input type="text" id="direccion" name="direccion" required>

    <label for="telefono">Teléfono</label>
    <input type="tel" id="telefono" name="telefono" required>

    <label for="email">Correo electrónico</label>
    <input type="email" id="email" name="email" required>

    <label for="pago">Medio de pago</label>
    <select id="pago" name="pago" required>
      <option value="">Seleccionar...</option>
      <option value="tarjeta">Tarjeta de crédito/débito</option>
      <option value="mercadopago">MercadoPago</option>
      <option value="paypal">PayPal</option>
      <option value="transferencia">Transferencia bancaria</option>
    </select>

    <button type="submit" class="btn">Finalizar compra</button>
    <a class="btn secondary" href="carrito.php?accion=vaciar">Vaciar carrito</a>

  </form>
  <?php endif; ?>

</main>

<footer class="footer">
  <div class="container row">
    <span class="small">© 2025 GameStore Digital</span>
    <span class="small">Soporte: contacto@gamestoredigital.com</span>
  </div>
</footer>
</body>
</html>
