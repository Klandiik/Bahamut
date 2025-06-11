<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="inicio.css">
    <title>Login</title>
</head>

<body>
    <header>
    </header>
    <main>
        <section>
            <article>
                <?php
                session_start();

                // Verificar si el usuario ya está autenticado
                if (isset($_SESSION["nombre"])) {
                    header("Location: principal.php"); //Redireccionar a la página principal
                    exit();
                }
                // Mostrar el formulario de inicio de sesión si no está autenticado
                ?>
                <br>
                <div class="login-container">
                    <form action="validar.php" class="text on" method="post">
                        <input type="checkbox" class="input-check" id="input-check">
                        <label for="input-check" class="toggle">
                            <span class="text on">On</span>
                            <span class="text off">Off</span>
                        </label>
                        <div class="login-light"></div>
                        <h2>BAHAMUT</h2>
                        <div class="input-box">
                            <span class="icon">
                                <ion-icon name="mail"></ion-icon>
                            </span>
                            <input type="email" id="correo_electronico" name="correo_electronico" required="required">
                            <label>Correo</label>
                            <div class="input-line"></div>
                        </div>

                        <div class="input-box">
                            <span class="icon">
                                <ion-icon name="lock-closed"></ion-icon>
                            </span>
                            <input type="password" id="contrasena" name="contrasena" required="required">
                            <label>Contraseña</label>
                            <div class="input-line"></div>

                        </div>

                        <div class="recordarcon">

                            <a href="">¿Se te olvidó la contraseña?</a>
                        </div>
                        <div class="registro">
                            <p>¿No tienes una cuenta? <a href="registro.php">Registrate</a></p>
                        </div>
                            <input class="button" id="btn-registrar" type="submit" value="Conectarme">

                    </form>
            </article>
        </section>
    </main>
    <footer>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const toggle = document.getElementById("input-check");
            const registrarBtn = document.getElementById("btn-registrar");

            if (toggle && registrarBtn) {
                toggle.addEventListener("change", () => {
                    if (toggle.checked) {
                        registrarBtn.style.background = "var(--light-bacco)";
                        registrarBtn.style.boxShadow = "0 0 15px var(--light-bacco)";
                        registrarBtn.style.color = "var(--white-color)";
                    } else {
                        registrarBtn.style.background = "var(--white-color)";
                        registrarBtn.style.boxShadow = "none";
                        registrarBtn.style.color = "var(--body-color)";
                    }
                });
            }
        });
    </script>

</body>

</html>