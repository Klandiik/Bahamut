<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
session_start();
require_once("conexion.php"); // tu conexión PDO

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];

    try {
        $sql = "SELECT u.id, u.nombre_usuario, u.correo_electronico, u.contraseña, u.id_rol, r.nombre AS rol
                FROM usuarios u
                JOIN roles r ON u.id_rol = r.id
                WHERE u.correo_electronico = :correo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica contraseña: si usas hash, usa password_verify
            if (password_verify($contrasena, $usuario['contraseña']) || $contrasena === $usuario['contraseña']) {
                $_SESSION["id_rol"] = $usuario["id_rol"];
                $_SESSION["rol_usuario"] = $usuario["rol"];
                $_SESSION["correo_electronico"] = $usuario["correo_electronico"];
                $_SESSION["nombre"] = $usuario["nombre_usuario"];

                // Aquí el cambio importante para el ID de usuario
                $_SESSION["usuario_id"] = $usuario["id"];

                header("Location: index.php");
                exit;
            } else {
                echo "Contraseña incorrecta. <a href='login.php'>Volver</a>";
            }
        } else {
            echo "Correo no encontrado. <a href='login.php'>Volver</a>";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    header("Location: login.php");
    exit;
}

