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
                <form action="altaUsuario.php" method="post">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required placeholder="Introduce un nombre de usuario">
                    <br>
                    <label for="correo">Correo Eléctronico:</label>
                    <input type="email" name="correo" id="correo" required pattern=".*@.*"
                        placeholder="Introduce un correo eléctronico">

                    <br>
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" name="contrasena" id="contrasena" required
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{10,}$" minlength="10"
                        placeholder="Introduce Contraseña">
                    <br>

                    <input class="boton" type="submit" value="Actualizar">
                </form>
            </article>
        </section>
    </main>
    <footer>
    </footer>
</body>

</html>