<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$usuario_id = $_SESSION['usuario_id'];

// Obtener imagen
$stmtImagen = $conn->prepare("SELECT imagen FROM usuarios WHERE id = :id");
$stmtImagen->execute([':id' => $usuario_id]);
$imagenUsuario = $stmtImagen->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Máquinas y Credenciales</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/principal.css">
</head>
<body>
    <div class="container">
        <!-- Menú lateral -->
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
                        <li><a href="#">Sub opción 3</a></li>
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

        <!-- Usuario -->
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

        <!-- Contenido principal -->
        <div class="contenido-principal">
            <h2>Listado de Máquinas y Credenciales</h2>

            <?php
            $stmt = $conn->query("SELECT m.nombre, m.direccion_ip, m.descripcion, c.usuario_maquina, c.contraseña
                                  FROM maquinas m
                                  LEFT JOIN credenciales c ON m.id = c.id_maquina");

            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>Máquina</th><th>IP</th><th>Descripción</th><th>Usuario</th><th>Contraseña</th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['nombre']}</td>
                        <td>{$row['direccion_ip']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>{$row['usuario_maquina']}</td>
                        <td>{$row['contraseña']}</td>
                      </tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
</body>
</html>
