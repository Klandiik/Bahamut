<?php
session_start();
try {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: modificaciones.php');
        exit();
    }

    $usuario = $_SESSION['usuario'];
    require 'conexion.php'; // Incluimos la conexión correctamente

    // Obtener el ID del usuario actual desde la sesión
    $usuario_id = $_SESSION['usuario_id'];
    // Consulta para obtener la imagen del usuario
    $sqlImagen = "SELECT imagen FROM usuarios WHERE id = :id";
    $stmtImagen = $conn->prepare($sqlImagen);
    $stmtImagen->execute([':id' => $usuario_id]);
    $imagenUsuario = $stmtImagen->fetchColumn();  // Esto obtiene el nombre de la imagen
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
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/principal.css">
        <title>Titan Fortress</title>
    </head>

    <body>
        <header>

        </header>
        <main>
            <div class="container">
                <aside id="menu">
                    <ol>
                        <li class="mn">
                            <a href="principal.php">
                                <img class="panel_l" src="img/logo.png" alt="Inicio">
                            </a>
                        </li>
                        <li>
                            <a href="usuarios.php">
                                <img class="panel_u" src="img/panel_usuarios3.png" alt="Usuarios">
                                <span class="menu-label">Usuarios</span>
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="conexiones.php">
                                <img class="panel_c" src="img/panel_conexiones.png" alt="Conexiones">
                                <span class="menu-label">Conexiones</span>
                            </a>
                            <ul class="dropdown">
                                <li><a href="#">Sub opción 1</a></li>
                                <li><a href="#">Sub opción 2</a></li>
                                <li><a "#">Sub opción 3</a></li>
                            </ul>
                        </li>
                    </ol>

                    <ol>
                        <li>
                            <form action="desconexion.php" method="post">
                                <button type="submit">
                                    <img class="panel_sup_d" src="img/panel_desconexion2.png" alt="Logout">
                                    <span class="menu-label">Logout</span>
                                </button>
                            </form>
                        </li>
                    </ol>
                </aside>


                <div id="box1">
                    <div class="usu">
                        <ol>
                            <li class="usuario-logo">
                                <a href="#">
                                    <img src="img/usuarios/<?php echo $imagenUsuario; ?>" alt="Logo usuario"
                                        class="foto_usuario">
                                </a>
                                <div class="submenu2">
                                    <div class="usuario-info">
                                        <span>Usuario: <?php echo $usuario; ?></span>
                                    </div>
                                    <form action="desconexion.php" method="post">
                                        <button type="submit" class="logout-btn">Cerrar sesión</button>
                                    </form>
                                </div>
                            </li>
                        </ol>
                    </div>

                </div>
            </div>
        </main>
        <footer>

        </footer>
    </body>

    </html>
    <?php
} catch (PDOException $e) {
    die("Error al consultar el rol del usuario: " . $e->getMessage());
}

?>