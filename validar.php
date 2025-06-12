<?php
session_start();
require_once("conexion.php"); // Aquí ya usas PDO correctamente

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];

    try {
        // Consulta solo por correo
        $sql = "SELECT id, nombre_usuario, correo_electronico, contraseña, id_rol FROM usuarios WHERE correo_electronico = :correo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Comparar contraseña ingresada con la almacenada (si está en texto plano, será igual)
            if (password_verify($contrasena, $usuario['contraseña']) || $contrasena === $usuario['contraseña']) {
                $_SESSION["id_rol"] = $usuario["id_rol"];
                $_SESSION["correo_electronico"] = $usuario["correo_electronico"];
                $_SESSION["nombre"] = $usuario["nombre_usuario"];
                $_SESSION["id_usuario"] = $usuario["id"];

                header("Location: principal.php");
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
?>
