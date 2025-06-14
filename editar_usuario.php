<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $conn->prepare("UPDATE usuarios SET nombre_usuario = ?, correo_electronico = ?, contraseña = ? WHERE id = ?")
        ->execute([$nombre_usuario, $correo, $contrasena, $id]);

    echo "<script>alert('Usuario editado correctamente'); window.location.href='modificaciones.php';</script>";
    exit;
}

header('Location: modificaciones.php');
exit;
?>