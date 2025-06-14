<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
       <meta name="author" content="christian adrian pereira">
    <meta name="author" content="pedro manuel merino garcia">
    <meta name="author" content="noe jefferson chavarry llerenas">
    <title>Registrar Usuario</title>
</head>

<body>
    <header>Cambio de contraseña</header>
    <main>
        <section>
            <article>
                <form action="altacontrasena.php" method="post">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" name="correo" id="correo" required placeholder="Introduce tu correo electrónico">
                    <br>

                    <label for="nueva_contrasena">Nueva Contraseña:</label>
                    <input type="password" name="nueva_contrasena" id="nueva_contrasena" required placeholder="Introduce nueva contraseña">
                    <br>

                    <input class="boton" type="submit" value="Actualizar Contraseña">
                </form>
            </article>
        </section>
    </main>
    <footer>
    </footer>
</body>

</html>