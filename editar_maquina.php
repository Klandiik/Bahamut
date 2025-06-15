<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $ip = $_POST['ip'];
    $puerto = $_POST['puerto'];
    $descripcion = $_POST['descripcion'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $conn->prepare("UPDATE maquinas SET nombre = ?, direccion_ip = ?, puerto = ? ,descripcion = ? WHERE id = ?")
        ->execute([$nombre, $ip, $puerto , $descripcion, $id]);

    $conn->prepare("UPDATE credenciales SET usuario_maquina = ?, contraseña = ? WHERE id_maquina = ?")
        ->execute([$usuario, $contrasena, $id]);

    echo "<script>alert('Maquina editado correctamente'); window.location.href='modificaciones.php';</script>";
    exit;
}
?>