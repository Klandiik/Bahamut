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
                <form action="altacontrasena.php" method="post">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required placeholder="Introduce un nombre de usuario">
                    <br>

                    <label for="contrasena">Contraseña:</label>
                    <input type="password" name="contrasena" id="contrasena" required placeholder="Introduce Contraseña">
                    <br>

                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" name="correo" id="correo" required placeholder="Introduce un correo electrónico"> 
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