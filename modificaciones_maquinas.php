<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $ip = $_POST['direccion_ip'];
    $usuario = $_POST['usuario_maquina'];
    $clave = $_POST['contraseña'];

    // Actualiza máquina
    $stmt = $pdo->prepare("UPDATE maquinas SET nombre = ?, direccion_ip = ? WHERE id = ?");
    $stmt->execute([$nombre, $ip, $id]);

    // Verifica si ya tiene credencial
    $check = $pdo->prepare("SELECT id FROM credenciales WHERE id_maquina = ?");
    $check->execute([$id]);
    if ($check->fetch()) {
        $stmt = $pdo->prepare("UPDATE credenciales SET usuario_maquina = ?, contraseña = ? WHERE id_maquina = ?");
        $stmt->execute([$usuario, $clave, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO credenciales (id_maquina, usuario_maquina, contraseña) VALUES (?, ?, ?)");
        $stmt->execute([$id, $usuario, $clave]);
    }

    header("Location: modificaciones.php");
}
?>
