<?php
// autor: christian adrian pereira 
// autor: pedro manuel merino garcia
// autor: noe jefferson chavarry llerenas

try {
    $conexion = new mysqli('localhost', 'root', '', 'Bahamut');
    if ($conexion->connect_error) {
        // Devolver error simple para el AJAX
        echo "Error de conexión a la base de datos.";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $correo = $_POST["correo"];
        $nuevaContrasena = $_POST["nueva_contrasena"];

        // Guardar la contraseña tal cual, sin hash (aunque NO recomendado en producción)
        $contrasenaPlano = $nuevaContrasena;

        $verificar = $conexion->prepare("SELECT id FROM usuarios WHERE correo_electronico = ?");
        $verificar->bind_param("s", $correo);
        $verificar->execute();
        $resultado = $verificar->get_result();

        if ($resultado->num_rows > 0) {
            $actualizar = $conexion->prepare("UPDATE usuarios SET `contraseña` = ? WHERE correo_electronico = ?");
            $actualizar->bind_param("ss", $contrasenaPlano, $correo);

            if ($actualizar->execute()) {
                echo "✔ Contraseña actualizada con éxito.";
            } else {
                echo "✖ Error al actualizar contraseña: " . $actualizar->error;
            }
        } else {
            echo "✖ Correo no encontrado. ¿Está registrado?";
        }
    } else {
        echo "Acceso inválido.";
    }
} catch (mysqli_sql_exception $excp) {
    echo "Error en la base de datos: " . $excp->getMessage();
}
?>
