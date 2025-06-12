<?php
session_start(); //Creamos una sesion

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenemos los datos del formulario con los nuevos nombres
    $correo = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];

    try {
        // Establecemos la conexión a la BD
        $conexion = new mysqli('localhost', 'root','', 'bahamut');
        // Controlamos los errores 
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Preparacion consulta SQL
        $sentenciaSelect = "SELECT id_rol, correo_electronico, contraseña FROM usuarios WHERE correo_electronico = ? AND contraseña = ?";
        $stmt = $conexion->prepare($sentenciaSelect);
        $stmt->bind_param("ss", $correo, $contrasena);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Ver si hay resultado
        if ($resultado->num_rows > 0) {
            // Si la contraseña y el correo coinciden, obtenemos el ID del usuario y lo almacenamos en una sesión
            $usuarioDatos = $resultado->fetch_assoc();
            $_SESSION["id_rol"] = $usuarioDatos["id_rol"];
            $_SESSION["correo_electronico"] = $usuarioDatos["correo_electronico"];
            
            // Redirige a la página principal
            header("Location: principal.php");
            exit();
            
        } else {
            // Si no coincide contraseña y correo, mostramos un mensaje de error
            echo "Error: Correo electrónico o contraseña incorrectos";
            echo '<a href="login.php">Volver a inicio de sesión</a>';
        }
        $conexion->close();
    
    } catch (mysqli_sql_exception $excp) {
        if ($conexion->connect_errno) {
            die("Falló la conexión: " . $conexion->connect_error);
        } else {
            die('Algo ha fallado en la BBDD: ' . $conexion->error);
        }
    }
} else {
    // Si no se ha enviado el formulario, redirige a la página de inicio de sesión
    header("Location: login.php");
    exit();
}
?>
