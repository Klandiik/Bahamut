<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Permisos de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-success">Permisos de Usuarios sobre Máquinas</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Máquina</th>
                <th>Permiso</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT p.id_usuario, p.id_maquina, p.nivel_permiso,
                       u.nombre_usuario, u.correo_electronico,
                       m.nombre AS maquina
                FROM permisos_usuarios_maquinas p
                JOIN usuarios u ON p.id_usuario = u.id
                JOIN maquinas m ON p.id_maquina = m.id
                ORDER BY u.id, m.id";
        $stmt = $conn->query($sql);
        foreach ($stmt as $row):
        ?>
            <tr>
                <form method="POST" action="modificaciones_permisosJ.php">
                    <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                    <td><?= htmlspecialchars($row['correo_electronico']) ?></td>
                    <td><?= htmlspecialchars($row['maquina']) ?></td>
                    <td>
                        <select name="nivel_permiso" class="form-select">
                            <option <?= $row['nivel_permiso'] === 'conectar' ? 'selected' : '' ?>>conectar</option>
                            <option <?= $row['nivel_permiso'] === 'ver_credenciales' ? 'selected' : '' ?>>ver_credenciales</option>
                            <option <?= $row['nivel_permiso'] === 'administrar' ? 'selected' : '' ?>>administrar</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="id_usuario" value="<?= $row['id_usuario'] ?>">
                        <input type="hidden" name="id_maquina" value="<?= $row['id_maquina'] ?>">
                        <button class="btn btn-sm btn-success">Actualizar</button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
