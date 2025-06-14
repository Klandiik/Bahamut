<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? ''; // sin la ñ
    $correo = $_POST['correo_electronico'] ?? '';
    $id_rol = 1; // Rol por defecto
    $imagen = $nombre_usuario . '.jpeg';

    try {
        // Hashear la contraseña
        $hashed_password = $contrasena;

        // luego usa :contrasena en la consulta:
        $sql = "INSERT INTO usuarios (nombre_usuario, contraseña, correo_electronico, id_rol, imagen)
        VALUES (:nombre_usuario, :contrasena, :correo_electronico, :id_rol, :imagen)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombre_usuario' => $nombre_usuario,
            ':contrasena' => $hashed_password,
            ':correo_electronico' => $correo,
            ':id_rol' => $id_rol,
            ':imagen' => $imagen
        ]);

        // Obtener ID del nuevo usuario
        $id_usuario = $conn->lastInsertId();

        // Obtener dinámicamente el ID de la máquina cuyo id = 0
        $stmtMaquina = $conn->prepare("SELECT id FROM maquinas WHERE id = 0 LIMIT 1");
        $stmtMaquina->execute();
        $maquina = $stmtMaquina->fetch(PDO::FETCH_ASSOC);

        if ($maquina && isset($maquina['id'])) {
            $id_maquina = $maquina['id'];

            // Insertar el permiso por defecto
            $sqlPermiso = "INSERT INTO permisos_usuarios_maquinas (id_usuario, id_maquina, nivel_permiso)
                           VALUES (:id_usuario, :id_maquina, :nivel_permiso)";
            $stmtPermiso = $conn->prepare($sqlPermiso);
            $stmtPermiso->execute([
                ':id_usuario' => $id_usuario,
                ':id_maquina' => $id_maquina,
                ':nivel_permiso' => 'ningun permiso'
            ]);

            echo "✅ Usuario creado correctamente con permiso por defecto.";
            header("Location: inicio.php");
        } else {
            echo "⚠️ Usuario creado, pero no se encontró la máquina con ID 0 para asignar permiso.";
        }
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>