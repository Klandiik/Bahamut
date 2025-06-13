<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_maquina = $_POST['id_maquina'];

    $stmt = $conn->prepare("DELETE FROM permisos_usuarios_maquinas WHERE id_usuario = ? AND id_maquina = ?");
    $stmt->execute([$id_usuario, $id_maquina]);

    echo "<script>alert('Relacion de maquina elimina con usuario correctamente'); window.location.href='permisos.php';</script>";
    exit;
}
?>