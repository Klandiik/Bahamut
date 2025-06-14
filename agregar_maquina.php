<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $ip = $_POST['ip'];
    $descripcion = $_POST['descripcion'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $conn->prepare("INSERT INTO maquinas (nombre, direccion_ip, descripcion) VALUES (?, ?, ?)")
        ->execute([$nombre, $ip, $descripcion]);
    $id_maquina = $conn->lastInsertId();

    $conn->prepare("INSERT INTO credenciales (id_maquina, usuario_maquina, contraseña) VALUES (?, ?, ?)")
        ->execute([$id_maquina, $usuario, $contrasena]);

    echo "<script>alert('Maquina agregado correctamente'); window.location.href='modificaciones.php';</script>";
    exit;
}
?>