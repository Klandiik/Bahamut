<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
session_start();

if (isset($_SESSION['nombre'])) {
    session_unset();
    session_destroy();
}

header('Location: inicio.php');
exit();
?>
