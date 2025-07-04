<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // Crear el nombre de la imagen automáticamente
    $imagen = $nombre_usuario . '.jpeg';

    // Puedes generar la fecha actual para 'creado_en' si la columna no tiene valor por defecto
    $fecha_creacion = date('Y-m-d H:i:s'); // Opcional si `creado_en` es NULL o auto

    try {
        $sql = "INSERT INTO usuarios (nombre_usuario, contraseña, correo_electronico, id_rol, creado_en, imagen) 
                VALUES (?, ?, ?, 1, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $nombre_usuario,
            $contrasena,
            $correo,
            $fecha_creacion,
            $imagen
        ]);

        echo "<script>alert('Usuario agregado correctamente'); window.location.href='modificaciones.php';</script>";
        exit;

    } catch (PDOException $e) {
        echo "Error al agregar usuario: " . $e->getMessage();
    }
}

header('Location: modificaciones.php');
exit;
?>