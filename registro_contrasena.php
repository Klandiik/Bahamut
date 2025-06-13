<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Registrar Usuario</title>
</head>

<body>
    <header>Cambio de contraseña</header>
    <main>
        <section>
            <article>
    <form action="procesar_restablecer.php" method="post">
        <label for="correo">Correo electrónico:</label>
        <input type="email" name="correo" id="correo" required placeholder="Tu correo registrado"><br>

        <label for="nueva_contrasena">Nueva contraseña:</label>
        <input type="password" name="nueva_contrasena" id="nueva_contrasena" required
               placeholder="Introduce nueva contraseña"><br>

        <input type="submit" value="Actualizar contraseña">
    </form>
            </article>
        </section>
    </main>
    <footer>
    </footer>
</body>

</html>