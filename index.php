<?php
session_start();
require 'conexion.php';  // Incluimos la conexión con la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usuario = $_POST["usuario"];
  $password = $_POST["password"];

  // Verificamos si la conexión está definida correctamente
  if (!isset($conn)) {
    die("Error: la conexión no se estableció correctamente.");
  }

  // Usamos consultas preparadas con bindParam para evitar inyecciones SQL
  $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre_usuario = :usuario AND contraseña = :password");
  $stmt->bindParam(":usuario", $usuario);
  $stmt->bindParam(":password", $password);
  $stmt->execute();

  // Verificamos si encontramos el usuario
  $usuario_encontrado = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($usuario_encontrado) {
    $_SESSION['usuario'] = $usuario_encontrado['nombre_usuario'];
    $_SESSION['usuario_id'] = $usuario_encontrado['id']; // Guardar el ID del usuario en la sesión

    // Redirigir al panel si es correcto
    header("Location: principal.php");
    exit();
  } else {
    $mensaje = "Usuario o contraseña incorrectos";
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Christian Adrian Pereira">
  <meta name="author" content="Jefferson">
  <meta name="author" content="Pedro">
  <link rel="icon" href="img/favicon.ico">
  <link rel="stylesheet" href="css/login.css">
  <title>Login</title>
</head>

<body>
  <header>
  </header>
  <main>
    <section id="sec1">
      <figure>
        <img class="foto" src="img/logo_completo.png" alt="sin conexion">
      </figure>
    </section>
    <section id="sec2">
      <form id="loginForm" method="post" action="">
        <h1>Acceso a Bahamut</h1>
        <table>
          <tr>
            <td><label for="usuario">Usuario:</label></td>
            <td><input type="text" id="usuario" name="usuario" required></td>
          </tr>
          <tr>
            <td><label for="password">Contraseña:</label></td>
            <td><input type="password" id="password" name="password" required></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center;">
              <button type="submit">Iniciar sesión</button>
            </td>
          </tr>
        </table>
        <?php if (!empty($mensaje)): ?>
          <p style="color: red;"><?php echo $mensaje; ?></p>
        <?php endif; ?>
      </form>
    </section>
  </main>
  <footer>

  </footer>
</body>

</html>
