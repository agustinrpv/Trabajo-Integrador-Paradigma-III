<?php
session_start();
require_once "backend/conexion.php";

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$accion = $_GET['accion'] ?? '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

switch ($accion) {

    case 'agregar':
        if ($id > 0) {

            // Si ya está en el carrito, aumento cantidad
            if (isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id]['cantidad']++;
            } else {
                // Lo busco en la BD
                $stmt = $conn->prepare("SELECT * FROM juegos WHERE id_juego = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $juego = $stmt->get_result()->fetch_assoc();

                if ($juego) {
                    $_SESSION['carrito'][$id] = [
                        'id'         => $juego['id_juego'],
                        'titulo'     => $juego['titulo'],
                        'plataforma' => $juego['plataforma'],
                        'precio'     => $juego['precio'],
                        'cantidad'   => 1,
                    ];
                }
            }
        }
        header("Location: comprar.php");
        exit;

    case 'eliminar':
        if ($id > 0 && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
        header("Location: comprar.php");
        exit;

    case 'vaciar':
        $_SESSION['carrito'] = [];
        header("Location: comprar.php");
        exit;

    default:
        header("Location: comprar.php");
        exit;
}
