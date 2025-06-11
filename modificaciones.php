<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificaciones - Gestión de Máquinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 text-primary">Gestión de Máquinas y Credenciales</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Máquina</th>
                <th>IP</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT m.id, m.nombre, m.direccion_ip, c.usuario_maquina, c.contraseña
                FROM maquinas m
                LEFT JOIN credenciales c ON m.id = c.id_maquina
                ORDER BY m.id";
        $stmt = $pdo->query($sql);
        foreach ($stmt as $row):
        ?>
            <tr>
                <form method="POST" action="modificar_maquina.php">
                    <td><input type="text" name="nombre" value="<?= htmlspecialchars($row['nombre']) ?>" class="form-control" /></td>
                    <td><input type="text" name="direccion_ip" value="<?= htmlspecialchars($row['direccion_ip']) ?>" class="form-control" /></td>
                    <td><input type="text" name="usuario_maquina" value="<?= htmlspecialchars($row['usuario_maquina']) ?>" class="form-control" /></td>
                    <td><input type="text" name="contraseña" value="<?= htmlspecialchars($row['contraseña']) ?>" class="form-control" /></td>
                    <td>
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button class="btn btn-sm btn-primary">Guardar</button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>