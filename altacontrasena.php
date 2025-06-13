<?php
try {
    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'Bahamut');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $correo = $_POST["correo"];
        $nuevaContrasena = $_POST["nueva_contrasena"];

        // Hashear la nueva contraseña
        $nuevaContrasenaHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        // Verificar si el correo existe
        $verificar = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $verificar->bind_param("s", $correo);
        $verificar->execute();
        $resultado = $verificar->get_result();

        if ($resultado->num_rows > 0) {
            // Actualizar contraseña
            $actualizar = $conexion->prepare("UPDATE usuarios SET contrasena = ? WHERE correo = ?");
            $actualizar->bind_param("ss", $nuevaContrasenaHash, $correo);

            if ($actualizar->execute()) {
                echo "Contraseña actualizada con éxito.";
                echo "<br><a href='login.php'>Iniciar sesión</a>";
            } else {
                echo "Error al actualizar contraseña: " . $actualizar->error;
            }
        } else {
            echo "Correo no encontrado. ¿Está registrado?";
        }
    } else {
        echo "Acceso inválido.";
    }
} catch (mysqli_sql_exception $excp) {
    die("Error en la base de datos: " . $excp->getMessage());
}
?>
