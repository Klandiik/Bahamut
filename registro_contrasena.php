<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cambio de Contraseña</title>
    <meta name="author" content="christian adrian pereira" />
    <meta name="author" content="pedro manuel merino garcia" />
    <meta name="author" content="noe jefferson chavarry llerenas" />
    <link rel="stylesheet" href="inicio.css" />
    <link rel="stylesheet" href="contrasena.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
</head>

<body>

    <!-- ✅ FORMULARIO -->
    <div class="login-container">
        <form action="altacontrasena.php" id="formContrasena" method="post">
            <!-- ✅ MODO ON/OFF -->
            <input type="checkbox" class="input-check" id="input-check" />
            <label for="input-check" class="toggle">
                <span class="text on">On</span>
                <span class="text off">Off</span>
            </label>
            <div class="login-light"></div>
            <h2>BAHAMUT</h2>

            <!-- ✅ Email -->
            <div class="input-box">
                <span class="icon">
                    <ion-icon name="mail"></ion-icon>
                </span>
                <input type="email" name="correo" id="correo" required />
                <label for="correo">Correo Electrónico</label>
                <span class="input-line"></span>
            </div>

            <!-- ✅ Nueva contraseña -->
            <div class="input-box">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" name="nueva_contrasena" id="nueva_contrasena" required />
                <label for="nueva_contrasena">Nueva Contraseña</label>
                <span class="input-line"></span>
            </div>

            <!-- ✅ Botón que reacciona al modo -->
            <input class="button" id="btn-registrar" type="submit" value="Actualizar Contraseña" />

            <div class="registro">
                <p><a href="inicio.php">Volver al inicio de sesión</a></p>
            </div>
        </form>
    </div>

    <!-- Contenedor para mensaje flotante -->
    <div id="mensaje" class="mensaje-flotante" style="display:none;"></div>

    <!-- ✅ Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- ✅ Script de efecto ON/OFF -->
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

        // AJAX para enviar el formulario y mostrar mensaje flotante
        document.getElementById('formContrasena').addEventListener('submit', function (e) {
            e.preventDefault(); // evitar submit normal

            const form = this;
            const formData = new FormData(form);
            const mensajeDiv = document.getElementById('mensaje');

            fetch('altacontrasena.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    // Checar si el mensaje contiene la palabra "Error" para poner color rojo
                    if (data.toLowerCase().includes('error') || data.toLowerCase().includes('no encontrado')) {
                        mensajeDiv.classList.add('error');
                    } else {
                        mensajeDiv.classList.remove('error');
                    }

                    mensajeDiv.innerHTML = data + '<br><a href="inicio.php" style="color: #fff; text-decoration: underline;">Iniciar sesión</a>';
                    mensajeDiv.style.display = 'block';

                    // Ocultar el mensaje después de 5 segundos
                    setTimeout(() => {
                        mensajeDiv.style.display = 'none';
                    }, 5000);
                })
                .catch(error => {
                    mensajeDiv.classList.add('error');
                    mensajeDiv.innerHTML = 'Error en la comunicación con el servidor.';
                    mensajeDiv.style.display = 'block';
                });
        });
    </script>

</body>

</html>
