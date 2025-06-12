<?php
try {
    include 'conexion.php';
    session_start();

    if (!isset($_SESSION['nombre'])) {
        header("Location: inicio.php");
        exit;
    }

    $nombreUsuario = $_SESSION['nombre'];

    // Obtener el id del usuario
    $sql = "SELECT id FROM usuarios WHERE nombre_usuario = :nombre_usuario";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':nombre_usuario' => $nombreUsuario]);
    $usuario_id = $stmt->fetchColumn();

    if (!$usuario_id) {
        // Usuario no encontrado en BD, redirigir o manejar error
        header("Location: inicio.php");
        exit;
    }

    //PARTE DE LA MAQUINA
    // Validar que viene el parámetro id
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "ID de máquina no especificado.";
        exit;
    }

    $id_maquina = intval($_GET['id']); // Sanitizar id


    // Consulta los datos de la máquina y sus credenciales
    $sql = "SELECT m.nombre, m.direccion_ip, m.descripcion, c.usuario_maquina, c.contraseña
                FROM maquinas m
                LEFT JOIN credenciales c ON c.id_maquina = m.id
                WHERE m.id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id_maquina]);
    $maquina = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$maquina) {
        echo "No se encontró la máquina con ID $id_maquina.";
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TitanFortress</title>
        <link rel="stylesheet" href="css/index.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="stylesheet" href="css/usuarios.css">
    </head>

    <body>
        <div class="wrapper w-100 d-flex align-items-start justify-content-between bg-black">
            <!--Navegador Vertical ¡-->
            <nav class="sidebar position-relative">
                <div class="sidebar-content w-100">
                    <div class="scrollbar-container h-100 w-100 d-flex justify-content-center flex-column">
                        <a href="#"
                            class="sidebar-brand d-flex justify-content-center align-items-center gap-1 py-2 text-center">
                            <img src="img/logo.png" alt="titan" class="logo">
                            <span class="align-middel me-3 text-uppercase text-while fw-bold fs-9 p-2">TitanFortress</span>
                        </a>
                        <ul class="sidebar-nav position-relative w-100">
                            <li class="sidebar-header">Navegacion</li>
                            <li class="sidebar-item">
                                <a href="producto.php" class="sidebar-link" data-bs-toggle="collapse" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-house" viewBox="0 0 16 16">
                                        <path
                                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                    </svg>
                                    <span class="align-middel"><a href="index.php">Inicio</a></span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="producto.php" class="sidebar-link" data-bs-toggle="collapse" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-globe" viewBox="0 0 16 16">
                                        <path
                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z" />
                                    </svg>
                                    <span class="align-middel">Sobre Nosotros</span>
                                </a>
                            </li>
                            <li class="sidebar-header">Servicios</li>
                            <li class="sidebar-item">
                                <a href="producto.php" class="sidebar-link" data-bs-toggle="collapse" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-diagram-3-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zm-6 8A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm6 0A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm6 0a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5z" />
                                    </svg>
                                    <span class="align-middel"><a href="conexionesMaquina.php">Conexiones</a></span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="producto.php" class="sidebar-link" data-bs-toggle="collapse" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pc-display" viewBox="0 0 16 16">
                                        <path
                                            d="M8 1a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1zm1 13.5a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0m2 0a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0M9.5 1a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM9 3.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5M1.5 2A1.5 1.5 0 0 0 0 3.5v7A1.5 1.5 0 0 0 1.5 12H6v2h-.5a.5.5 0 0 0 0 1H7v-4H1.5a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5H7V2z" />
                                    </svg>
                                    <span class="align-middel">Maquinas</span>
                                </a>
                            </li>
                            <li class="sidebar-header"><?= htmlspecialchars($nombreUsuario) ?></li>
                            <li class="sidebar-item">
                                <a href="producto.php" class="sidebar-link" data-bs-toggle="collapse" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-gear-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                    </svg>
                                    <span class="align-middel"><a href="modificaciones.php">Modificaciones</a></span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="producto.php" class="sidebar-link" data-bs-toggle="collapse" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person-gear" viewBox="0 0 16 16">
                                        <path
                                            d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                    </svg>
                                    <span class="align-middel">Permisos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="sidebar-item logout-item">
                    <a href="#" class="sidebar-link" aria-expanded="false">
                        <i class="bi bi-box-arrow-left width=24 height=24"></i>
                        <span class="align-middle"><a href="desconexion.php">Desconectarse</a></span>
                    </a>
                </div>
            </nav>
            <div class="main">
                <!--Navegador horizontal ¡-->
                <nav
                    class="navbar-main d-flex justify-content-between align-items-center p-4 navbar navbar-expand navbar-light">
                    <span class="sidebar-toggle d-flex align-items-center fs-4">
                        <i class="bi bi-border-width" id=toggle></i>
                    </span>
                    <div class="navbar-collapse collapse">
                        <div class="navbar-align navbar-nav ms-auto">
                            <!--Mensajes ¡-->
                            <div class="me-2 nav-item dropdown d-flex position-relative">
                                <a id="element" class="d-flex align-items-center nav-link nav-icon dropdown-toggle"
                                    aria-expanded="true">
                                    <div class="position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-chat" viewBox="0 0 16 16">
                                            <path
                                                d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                        </svg>
                                        <span class="indicator">2</span>
                                    </div>
                                </a>
                                <div class="dropdown-menu-lg py-0 dropdown-menu dropdown-menu-end" data-bs-popper="static">
                                    <div class="w-100 position-relative text-center dropdown-menu-header">2 Nuevos Mensajes
                                    </div>
                                    <div class="list-group d-flex g-5">
                                        <div class="list-group-item">
                                            <div class="align-items-center g-0 row">
                                                <div class="col-2">
                                                    <img class="avatar img-fluid rounded.circle"
                                                        src="img/usuarios/admin.jpeg" alt="Christian">
                                                </div>
                                                <div class="ps-2 col-10">
                                                    <div class="dropdown-menu-header p-0 fw-500">Chritian</div>
                                                    <p class="text-muted small mt-1">
                                                        ¿Como va la pagina?, ¿has progresado?.
                                                    </p>
                                                    <div class="text-muted small mt-1">
                                                        Hace 15 min
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="align-items-center g-0 row">
                                                <div class="col-2">
                                                    <img class="avatar img-fluid rounded.circle"
                                                        src="img/usuarios/usuario1.jpeg" alt="Pedro">
                                                </div>
                                                <div class="ps-2 col-10">
                                                    <div class="dropdown-menu-header p-0 fw-500">Pedro</div>
                                                    <p class="text-muted small mt-1">
                                                        No veas, tremenda batalla he tenido en el baño.
                                                    </p>
                                                    <div class="text-muted small mt-1">
                                                        Hace 40 min
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100 position-relative text-center dropdown-menu-footer">Ver todos los
                                        mensajes</div>
                                </div>
                            </div>
                            <!--Notificaciones ¡-->
                            <div class="me-2 nav-item dropdown d-flex position-relative">
                                <a id="element" class="d-flex align-items-center nav-link nav-icon dropdown-toggle"
                                    aria-expanded="true">
                                    <div class="position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-bell-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                                        </svg>
                                    </div>
                                </a>
                                <div class="dropdown-menu-lg py-0 dropdown-menu dropdown-menu-end" data-bs-popper="static">
                                    <div class="w-100 position-relative text-center dropdown-menu-header">2 Nuevos
                                        notificaciones</div>
                                    <div class="list-group d-flex g-5">
                                        <div class="list-group-item">
                                            <div class="align-items-center g-0 row">
                                                <div class="col-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-exclamation-circle"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                        <path
                                                            d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                                    </svg>
                                                </div>
                                                <div class="ps-2 col-10">
                                                    <div class="dropdown-menu-header p-0 fw-500">Actulizacion completada
                                                    </div>
                                                    <p class="text-muted small mt-1">
                                                        La pagina se ha actualizado a la ultima version 1.2
                                                    </p>
                                                    <div class="text-muted small mt-1">
                                                        Hace 30 min
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="align-items-center g-0 row">
                                                <div class="col-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                                    </svg>
                                                </div>
                                                <div class="ps-2 col-10">
                                                    <div class="dropdown-menu-header p-0 fw-500">Conexión desde la IP
                                                        192.123.1.1</div>
                                                    <div class="text-muted small mt-1">
                                                        Hace 1 hora
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="align-items-center g-0 row">
                                                <div class="col-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-house-add" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h4a.5.5 0 1 0 0-1h-4a.5.5 0 0 1-.5-.5V7.207l5-5 6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z" />
                                                        <path
                                                            d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 1 0 1 0v-1h1a.5.5 0 1 0 0-1h-1v-1a.5.5 0 0 0-.5-.5" />
                                                    </svg>
                                                </div>
                                                <div class="ps-2 col-10">
                                                    <div class="dropdown-menu-header p-0 fw-500">Nueva conexión</div>
                                                    <div class="text-muted small mt-1">
                                                        Hace 12 horas
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100 position-relative text-center dropdown-menu-footer">Ver todas las
                                        notificaciones</div>

                                </div>
                            </div>
                            <!--Idiomas ¡-->
                            <a href="#" type="button" class="nav-icon modes nav-link d-flex align-items-center"></a>
                            <div class="me-2 nav-item dropdown d-flex position-relative">
                                <a id="element"
                                    class="nav-flag d-flex align-items-center nav-icon nav-link  dropdown-toggle"
                                    aria-expanded="true">
                                    <div class="position-relative">
                                        <img src="img/españa.webp" alt="" class="img-fluid">
                                    </div>
                                </a>
                                <div class="dropdown-menu-lg py-0 dropdown-menu dropdown-menu-end" data-bs-popper="static"
                                    aria-labelledby="element" style="width: 150px;">
                                    <a href="#" class="dropdown-item">
                                        <img src="img/españa.webp" alt="espana" width="20" class="align-middle me-1">
                                        <span class="align-middle">España</span>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <img src="img/Ingles.webp" alt="ingles" width="20" class="align-middle me-1">
                                        <span class="align-middle">Ingles</span>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <img src="img/aleman.webp" alt="aleman" width="20" class="align-middle me-1">
                                        <span class="align-middle">Aleman</span>
                                    </a>
                                </div>
                            </div>
                            <!--Usuario ¡-->
                            <div class="nav-item dropdown nav-item-user">
                                <span class="d-inline-block d-sm-none nav-icon" aria-expanded="true">
                                    <a href="#" class="nav-link dropdown-toggle" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-person-gear" viewBox="0 0 16 16">
                                            <path
                                                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                        </svg>
                                    </a>
                                </span>
                                <span class="d-none d-sm-inline-block nav-icon" aria-expanded="true">
                                    <a href="#" class="nav-link dropdown-toggle" aria-expanded="false">
                                        <img src="img/usuarios/admin.jpeg" alt="admin"
                                            class="avatar img-fluid rounded-circle me-1" width="40" height="40">
                                        <span><?= htmlspecialchars($nombreUsuario) ?></span>
                                    </a>
                                </span>

                                <div class="dropdown dropdown-menu dropdown-menu3 dropdown-menu-end" data-bs-popper=static
                                    style="width: auto;">
                                    <a href="#" class="dropdown-item" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                                        </svg>
                                        Perfil
                                    </a>
                                    <a href="#" class="dropdown-item" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                                        </svg>
                                        Nose
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item">
                                        Configuraciones y privacidad
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        Ayuda
                                    </a>
                                    <a href="desconexion.php">Desconectarse</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="content">
                    <div class="p-0 container-fluid">
                        <div class="mb-2 mb-xl-2 row">
                            <div class="d-none d-sm-block col-auto">
                            </div>
                            <div class="ms-auto text-end mt-n1 col-auto">
                                <div class="d-inline me-2 dropdown">
                                    <button type="button" class="nav-icon bg-white shadow-sm dropdown-toggle btn btn-light"
                                        aria-expanded="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-person-gear" viewBox="0 0 16 16">
                                            <path
                                                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                        </svg>
                                        <span style="font-size: .9rem;">Hoy</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item">
                                            Activo
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            Otro Activo
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            Algo más aquí
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            Enlace separado
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex w-100">
                                <div class="illustration flex-fill card border-0" style="background-color: #e0eafc;">
                                    <div class="p-0 d-flex flex-fill card-body">
                                        <ul>
                                            <li><h3>Detalles de la máquina: <?= htmlspecialchars($maquina['nombre']) ?></h3></li>
                                            <li><strong>Dirección IP:</strong>
                                                <?= htmlspecialchars($maquina['direccion_ip']) ?></li>
                                            <li><strong>Descripción:</strong>
                                                <?= htmlspecialchars($maquina['descripcion']) ?></li>
                                            <li><strong>Usuario Máquina:</strong>
                                                <?= htmlspecialchars($maquina['usuario_maquina']) ?></li>
                                            <li><strong>Contraseña:</strong> <?= htmlspecialchars($maquina['contraseña']) ?>
                                            </li>
                                        </ul>

                                    </div>
                                    <div>
                                        <ol><li><p><a href="conexionesMaquina.php">Volver</a></p></li></ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="footer bg-white py-3">
                    <div class="container-fluid">
                        <div class="text-muted row">
                            <div class="text-start d-flex col-6">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item"><a href="#" class="text-muted">Support</a></li>
                                    <li class="list-inline-item"><a href="#" class="text-muted">Centro de ayuda</a></li>
                                    <li class="list-inline-item"><a href="#" class="text-muted">Política de privacidad</a>
                                    </li>
                                    <li class="list-inline-item"><a href="#" class="text-muted">Términos y condiciones</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-end col-6">
                                <p class="mb-0">Copyright © 2025 Tintan Fortress - All rights reserved <a href="#"
                                        class="text-muted">DataSphere</a></p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
            integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
            crossorigin="anonymous"></script>
        <script src="js/navegador.js"></script>
        <script>
            const toggle = document.getElementById('toggle');
            const sidebar = document.querySelector('.sidebar');
            const main = document.querySelector('.main');

            toggle.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
            })

        </script>
    </body>

    </html>
    <?php
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage()); // Si ocurre un error, muestra un mensaje adecuado
}
?>