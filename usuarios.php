<?php
session_start();
try {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: index.php');
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
        <link rel="stylesheet" href="css/usuarios.css">
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
                            <img class="panel_c" src="img/panel_conexiones.png" alt="Conexiones" style="border: 1px solid red;">

                                <img class="panel_c" src="img/panel_conexiones.png" alt="Conexiones">
                                <span class="menu-label">Conexiones</span>
                            </a>
                            <ul class="dropdown">
                                <li><a href="#">Sub opción 1</a></li>
                                <li><a href="#">Sub opción 2</a></li>
                                <li><a href="#">Sub opción 3</a></li>
                            </ul>
                        </li>
                    </ol>
                </aside>


                <div id="box1">
                    <div class="usu">
                    <ol>
                        <li class="usuario-logo">
                            <a href="#">
                                <img src="img/usuarios/<?php echo $imagenUsuario; ?>" alt="Logo usuario" class="foto_usuario">
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
                    <h2 class='tit1'>Usuarios Titan Fortress</h2>
                    <br>
                    <?php
                    // Verificar el rol del usuario
                    $sqlRol = "SELECT id_rol FROM usuarios WHERE id = :id";
                    $stmtRol = $conn->prepare($sqlRol);
                    $stmtRol->execute([':id' => $usuario_id]);
                    $rol = $stmtRol->fetchColumn();

                    echo "<div class='contenido'>";

                    // Consultar según el rol del usuario
                    if ($rol == 3) { // Administrador
                        $sql = "SELECT u.nombre_usuario, m.nombre AS maquina, c.usuario_maquina, c.contraseña
                            FROM usuarios u
                            JOIN permisos_usuarios_maquinas pum ON pum.id_usuario = u.id
                            JOIN maquinas m ON m.id = pum.id_maquina
                            JOIN credenciales c ON c.id_maquina = m.id";
                    } elseif ($rol == 2) { // Usuario con permisos específicos
                        echo "<h2>Credenciales de máquinas permitidas</h2>";
                        $sql = "SELECT m.nombre AS maquina, c.usuario_maquina, c.contraseña
                            FROM permisos_usuarios_maquinas pum
                            JOIN maquinas m ON m.id = pum.id_maquina
                            JOIN credenciales c ON c.id_maquina = m.id
                            WHERE pum.id_usuario = :id AND pum.nivel_permiso = 'ver_credenciales'";
                    } else { // Usuario normal
                        echo "<h2>Máquinas con permiso</h2>";
                        $sql = "SELECT m.nombre AS maquina, m.direccion_ip, m.descripcion
                            FROM permisos_usuarios_maquinas pum
                            JOIN maquinas m ON m.id = pum.id_maquina
                            WHERE pum.id_usuario = :id";
                    }

                    // Preparar y ejecutar la consulta correspondiente
                    try {
                        $stmt = $conn->prepare($sql);

                        // Solo pasamos el parámetro si la consulta lo requiere
                        if ($rol == 3) {
                            $stmt->execute(); // Para el administrador no se pasa parámetro
                        } else {
                            $stmt->execute([':id' => $usuario_id]); // Para otros roles, pasamos el parámetro :id
                        }

                        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Mostrar los resultados en una tabla
                        if ($resultados) {
                            echo "<table class='tabla_resultados'>";
                            echo "<thead>
                                <tr>
                                    <th>Nombre Usuario</th>
                                    <th>Máquina</th>
                                    <th>Usuario Máquina</th>
                                    <th>Contraseña</th>
                                </tr>
                              </thead>";
                            echo "<tbody>";
                            foreach ($resultados as $fila) {
                                echo "<tr>";
                                foreach ($fila as $valor) {
                                    echo "<td>$valor</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<p>No hay datos para mostrar.</p>";
                        }
                    } catch (PDOException $e) {
                        echo "Error al ejecutar la consulta: " . $e->getMessage();
                    }

                    echo "</div>";
                    ?>

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

pedrito
