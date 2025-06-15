<?php
// autor: christian adrian pereira 
// autor: pedro manuel merino garcia
// autor: noe jefferson chavarry llerenas

session_start();
require_once("conexion.php"); // conexión PDO

header('Content-Type: application/json; charset=utf-8');

$response = ["success" => false, "message" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['correo_electronico'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    try {
        $sql = "SELECT u.id, u.nombre_usuario, u.correo_electronico, u.contraseña, u.id_rol, r.nombre AS rol
                FROM usuarios u
                JOIN roles r ON u.id_rol = r.id
                WHERE u.correo_electronico = :correo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica contraseña (considera que puede estar en hash o plano)
            if (password_verify($contrasena, $usuario['contraseña']) || $contrasena === $usuario['contraseña']) {
                $_SESSION["id_rol"] = $usuario["id_rol"];
                $_SESSION["rol_usuario"] = $usuario["rol"];
                $_SESSION["correo_electronico"] = $usuario["correo_electronico"];
                $_SESSION["nombre"] = $usuario["nombre_usuario"];
                $_SESSION["usuario_id"] = $usuario["id"];

                $response["success"] = true;
                $response["message"] = "✔ Inicio de sesión correcto. Redirigiendo...";
            } else {
                $response["message"] = "✖ Contraseña incorrecta.";
            }
        } else {
            $response["message"] = "✖ Correo no encontrado.";
        }
    } catch (PDOException $e) {
        $response["message"] = "Error en la base de datos.";
    }
} else {
    $response["message"] = "Acceso inválido.";
}

echo json_encode($response);
exit;
?>
