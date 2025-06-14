<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_maquina = $_POST['id_maquina'];
    $nivel_permiso = $_POST['nivel_permiso'];

    $stmt = $conn->prepare("INSERT INTO permisos_usuarios_maquinas (id_usuario, id_maquina, nivel_permiso)
                           VALUES (?, ?, ?)");
    $stmt->execute([$id_usuario, $id_maquina, $nivel_permiso]);

    echo "<script>alert('Nueva maquina asignada correctamente'); window.location.href='permisos.php';</script>";
    exit;
}
?>