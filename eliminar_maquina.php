<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn->prepare("DELETE FROM maquinas WHERE id = ?")
        ->execute([$id]);

    echo "<script>alert('Maquina eliminada correctamente'); window.location.href='modificaciones.php';</script>";
    exit;
}
?>