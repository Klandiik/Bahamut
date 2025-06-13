<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_maquina = $_POST['id_maquina'];
    $nivel_permiso = $_POST['nivel_permiso'];

    $stmt = $conn->prepare("UPDATE permisos_usuarios_maquinas 
                           SET nivel_permiso = ? 
                           WHERE id_usuario = ? AND id_maquina = ?");
    $stmt->execute([$nivel_permiso, $id_usuario, $id_maquina]);

    echo "<script>alert('Permisos guardados correctamente'); window.location.href='permisos.php';</script>";
    exit;
}
?>