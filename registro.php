<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Registrar Usuario</title>
</head>
<body>
    <header>Página de registro</header>
    <main>
        <section>
            <article>
                <form action="altaUsuario.php" method="post">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre_usuario" id="nombre_usuario" required placeholder="Introduce un nombre de usuario">
                    <br>
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" name="contraseña" id="contraseña" placeholder="Introduce Contraseña">
                    <br>
                    <label for="correo">Correo Eléctronico:</label>
                    <input type="email" name="correo_electronico" id="correo_electronico" required pattern=".*@.*" placeholder="Introduce un correo eléctronico"> 
                    <br>
                    <input class="boton" type="submit" value="Registrarme">
                </form>
            </article>
        </section>
    </main>
    <footer>
    </footer>
</body>
</html>