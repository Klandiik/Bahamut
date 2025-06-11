<?php
try {
    // Conexión
    $conexion = new mysqli('localhost', 'Admin', 'Clave_00', 'Empresa');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar que el formulario se envió por POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = $_POST["nombre"];
        $contrasena = $_POST["contrasena"];
        $correo = $_POST["correo"];
        $telefono = $_POST["telefono"];

        // Hashear la contraseña antes de guardarla
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Preparar y ejecutar el INSERT
        $sentenciaInsert = $conexion->prepare("INSERT INTO usuarios (nombre, contrasena, correo, telefono) VALUES (?, ?, ?, ?)");
        $sentenciaInsert->bind_param("ssss", $nombre, $contrasenaHash, $correo, $telefono);

        if ($sentenciaInsert->execute()) {
            echo "Usuario dado de alta con éxito.";
            echo "<br><a href='login.php'>Pulsa aquí para iniciar sesión</a>";
        } else {
            echo "Error al dar de alta al nuevo usuario: " . $sentenciaInsert->error;
            echo "<br><a href='registrar.php'>¿Desea volver a registrarse?</a>";
        }
    } else {
        echo "Acceso no válido.";
    }
} catch (mysqli_sql_exception $excp) {
    die("Error en la base de datos: " . $excp->getMessage());
}
?>
