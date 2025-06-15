<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="inicio.css" />
    <title>Login</title>

    <style>
        /* Estilo para la nube flotante */
        .mensaje-flotante {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #f44336;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            font-weight: bold;
            z-index: 9999;
            max-width: 300px;
            transition: opacity 0.5s ease;
        }
        .mensaje-flotante.exito {
            background: #4caf50;
        }
    </style>
</head>

<body>
    <header></header>
    <main>
        <section>
            <article>
                <?php
                session_start();

                if (isset($_SESSION["nombre"])) {
                    header("Location: index.php");
                    exit();
                }
                ?>

                <br>
                <div class="login-container">
                    <form id="formLogin" method="post" class="text on" autocomplete="off">
                        <input type="checkbox" class="input-check" id="input-check" />
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
                            <input type="email" id="correo_electronico" name="correo_electronico" required />
                            <label>Correo</label>
                            <div class="input-line"></div>
                        </div>

                        <div class="input-box">
                            <span class="icon">
                                <ion-icon name="lock-closed"></ion-icon>
                            </span>
                            <input type="password" id="contrasena" name="contrasena" required />
                            <label>Contraseña</label>
                            <div class="input-line"></div>
                        </div>

                        <div class="recordarcon">
                            <a href="registro_contrasena.php">¿Se te olvidó la contraseña?</a>
                        </div>
                        <input class="button" id="btn-registrar" type="submit" value="Conectarme" />
                    </form>
                </div>
            </article>
        </section>
    </main>
    <footer></footer>

    <!-- Contenedor para mensajes flotantes -->
    <div id="mensaje" class="mensaje-flotante" style="display:none;"></div>

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

            // AJAX para login
            const formLogin = document.getElementById('formLogin');
            const mensajeDiv = document.getElementById('mensaje');

            formLogin.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(formLogin);

                fetch('validar.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            mensajeDiv.classList.remove('error');
                            mensajeDiv.classList.add('exito');
                            mensajeDiv.textContent = data.message;
                            mensajeDiv.style.display = 'block';

                            // Redirigir después de 2 segundos
                            setTimeout(() => {
                                window.location.href = 'index.php';
                            }, 2000);
                        } else {
                            mensajeDiv.classList.remove('exito');
                            mensajeDiv.classList.add('error');
                            mensajeDiv.textContent = data.message;
                            mensajeDiv.style.display = 'block';

                            // Ocultar mensaje después de 4 segundos
                            setTimeout(() => {
                                mensajeDiv.style.display = 'none';
                            }, 4000);
                        }
                    })
                    .catch(() => {
                        mensajeDiv.classList.remove('exito');
                        mensajeDiv.classList.add('error');
                        mensajeDiv.textContent = "Error en la comunicación con el servidor.";
                        mensajeDiv.style.display = 'block';
                    });
            });
        });
    </script>
</body>

</html>
