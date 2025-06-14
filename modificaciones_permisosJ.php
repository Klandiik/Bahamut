<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_maquina = $_POST['id_maquina'];
    $permiso = $_POST['nivel_permiso'];

    $stmt = $conn->prepare("UPDATE permisos_usuarios_maquinas SET nivel_permiso = ? WHERE id_usuario = ? AND id_maquina = ?");
    $stmt->execute([$permiso, $id_usuario, $id_maquina]);

    header("Location: permisosJ.php");
}
?>
