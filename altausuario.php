<?php
try {
    $conexion = new mysqli('localhost', 'root', '', 'Bahamut');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre_usuario = $_POST["nombre_usuario"];  
        $contrasena = $_POST["contraseña"];
        $correo_electronico = $_POST["correo_electronico"];

        $id_rol = 1; // asignar un rol por defecto

        $sentenciaInsert = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, contraseña, correo_electronico, id_rol) VALUES (?, ?, ?, ?)");
        $sentenciaInsert->bind_param("sssi", $nombre_usuario, $contrasena, $correo_electronico, $id_rol);

        if ($sentenciaInsert->execute()) {
            echo "Usuario dado de alta con éxito.";
            echo "<br><a href='inicio.php'>Pulsa aquí para iniciar sesión</a>";
        } else {
            echo "Error al dar de alta al nuevo usuario: " . $sentenciaInsert->error;
            echo "<br><a href='registro.php'>¿Desea volver a registrarse?</a>";
        }
    } else {
        echo "Acceso no válido.";
    }
} catch (mysqli_sql_exception $excp) {
    die("Error en la base de datos: " . $excp->getMessage());
}
?>
