<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo_electronico, contraseña, id_rol) VALUES (?, ?, ?, 1)")
        ->execute([$nombre_usuario, $correo, $contrasena]);

    echo "<script>alert('Usuario agregado correctamente'); window.location.href='modificaciones.php';</script>";
    exit;
}

header('Location: modificaciones.php');
exit;
?>