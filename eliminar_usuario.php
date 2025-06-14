<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn->prepare("DELETE FROM usuarios WHERE id = ?")
        ->execute([$id]);

    echo "<script>alert('Usuario eliminado correctamente'); window.location.href='modificaciones.php';</script>";
    exit;
}
?>
