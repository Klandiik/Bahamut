<?php
session_start(); //CReamos una sesion

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenemos los datos del formulario
    $usuario = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    try {
        // Establecemos la conexión a la BD
        $conexion = new mysqli('localhost', 'root','', 'bahamut');
        // Controlamos los errores 
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Preparacion consulta SQL
        $sentenciaSelect = "SELECT ID_usuario, nombre, contrasena FROM usuarios WHERE nombre = ? AND contrasena = ?";
        $stmt = $conexion->prepare($sentenciaSelect);
        $stmt->bind_param("ss", $usuario, $contrasena);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Ver si hay resultado
        if ($resultado->num_rows > 0) {
            // Si la contraseña y el nombre de usuario coiciden , obtenemos el ID del usuario y lo almacenamos en unaa sesión
            $usuarioDatos = $resultado->fetch_assoc();
            $_SESSION["ID_usuario"] = $usuarioDatos["ID_usuario"];
            $_SESSION["nombre"] = $usuarioDatos["nombre"];
            
            // Redirige a la página principal
            header("Location: principal.php");
            exit();
            
        } else {
            // Si no coincide contraseña y nombre de usuario, mostramos un mensaje de error
            echo "Error: Nombre de usuario o contraseña incorrectos";
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
