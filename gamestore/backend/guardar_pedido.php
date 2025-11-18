<?php
header("Content-Type: application/json; charset=utf-8");
require_once "conexion.php";

$nombre = $_POST["nombre"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$email = $_POST["email"];
$id_metodo = $_POST["pago"];
$id_juego = $_POST["producto"];
$cantidad = 1;

$stmt = $conn->prepare("INSERT INTO clientes (nombre, direccion, telefono, email) VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $nombre, $direccion, $telefono, $email);
$stmt->execute();
$id_cliente = $stmt->insert_id;
$stmt->close();

$stmt = $conn->prepare("SELECT precio FROM juegos WHERE id_juego=?");
$stmt->bind_param("i", $id_juego);
$stmt->execute();
$stmt->bind_result($precio);
$stmt->fetch();
$stmt->close();

$total = $cantidad * $precio;

$stmt = $conn->prepare("INSERT INTO pedidos (id_cliente, id_metodo, total) VALUES (?,?,?)");
$stmt->bind_param("iid", $id_cliente, $id_metodo, $total);
$stmt->execute();
$id_pedido = $stmt->insert_id;
$stmt->close();

$stmt = $conn->prepare("INSERT INTO detalle_pedidos (id_pedido, id_juego, cantidad, precio_unitario) VALUES (?,?,?,?)");
$stmt->bind_param("iiid", $id_pedido, $id_juego, $cantidad, $precio);
$stmt->execute();
$stmt->close();

echo json_encode(["ok"=>1, "pedido"=>$id_pedido]);
?>
