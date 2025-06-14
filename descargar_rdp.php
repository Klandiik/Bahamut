
<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: inicio.php");
    exit;
}

// Obtener el nombre de usuario desde la sesión
$nombreUsuario = $_SESSION['nombre'];

// Obtener el ID del usuario logueado
$stmtUser = $conn->prepare("SELECT id FROM usuarios WHERE nombre_usuario = :nombre");
$stmtUser->execute([':nombre' => $nombreUsuario]);
$usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}

$id_usuario = $usuario['id'];

if (!isset($_GET['id'])) {
    echo "ID de máquina no especificado.";
    exit;
}

$id_maquina = (int) $_GET['id'];

// Verificar que el usuario tenga permiso para conectarse
$stmtPermiso = $conn->prepare("SELECT nivel_permiso FROM permisos_usuarios_maquinas 
    WHERE id_usuario = :id_usuario AND id_maquina = :id_maquina");
$stmtPermiso->execute([
    ':id_usuario' => $id_usuario,
    ':id_maquina' => $id_maquina
]);

$permiso = $stmtPermiso->fetch(PDO::FETCH_ASSOC);

if (!$permiso || !in_array($permiso['nivel_permiso'], ['conectar', 'administrar'])) {
    echo "No tienes permiso para conectarte a esta máquina.";
    exit;
}

// Obtener la IP y el usuario de la máquina
$sql = "SELECT m.direccion_ip, c.usuario_maquina FROM maquinas m
        LEFT JOIN credenciales c ON c.id_maquina = m.id
        WHERE m.id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id_maquina]);
$info = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$info) {
    echo "Máquina no encontrada.";
    exit;
}

$direccion_ip = $info['direccion_ip'];
$usuario_maquina = $info['usuario_maquina'];

$rdpContent = <<<RDP
screen mode id:i:2
use multimon:i:0
desktopwidth:i:1280
desktopheight:i:720
session bpp:i:32
winposstr:s:0,3,0,0,800,600
full address:s:$direccion_ip
username:s:$usuario_maquina
compression:i:1
keyboardhook:i:2
audiocapturemode:i:0
videoplaybackmode:i:1
connection type:i:2
networkautodetect:i:1
bandwidthautodetect:i:1
displayconnectionbar:i:1
autoreconnection enabled:i:1
authentication level:i:2
prompt for credentials:i:1
negotiate security layer:i:1
remoteapplicationmode:i:0
alternate shell:s:
shell working directory:s:
disable wallpaper:i:1
disable full window drag:i:1
disable menu anims:i:1
disable themes:i:0
disable cursor setting:i:0
bitmapcachepersistenable:i:1
RDP;

header('Content-Type: application/x-rdp');
header('Content-Disposition: attachment; filename="conexion_maquina_' . $id_maquina . '.rdp"');
header('Content-Length: ' . strlen($rdpContent));

echo $rdpContent;
exit;
