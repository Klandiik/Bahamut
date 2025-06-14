<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: inicio.php");
    exit;
}

$nombreUsuario = $_SESSION['nombre'] ?? null;
$usuario_id = $_SESSION['usuario_id'];
$rol = $_SESSION['rol_usuario'] ?? 'usuario';

// Definir variable para el menú
$isAdmin = ($rol === 'administrador');

// Luego tu consulta según rol
if ($isAdmin) {
    $sql = "SELECT m.id AS id_maquina, m.nombre AS maquina, m.direccion_ip, m.puerto,
                   c.usuario_maquina, c.contraseña
            FROM maquinas m
            LEFT JOIN credenciales c ON c.id_maquina = m.id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
} else {
    // Lo que ya tienes para usuarios normales
    $sql = "SELECT m.id AS id_maquina, m.nombre AS maquina, m.direccion_ip, m.puerto, m.descripcion,
                   pum.nivel_permiso, c.usuario_maquina, c.contraseña
            FROM permisos_usuarios_maquinas pum
            JOIN maquinas m ON m.id = pum.id_maquina
            LEFT JOIN credenciales c ON c.id_maquina = m.id
            WHERE pum.id_usuario = :id_usuario";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id_usuario' => $usuario_id]);
}

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);


//imagen
$usuario_id = $_SESSION['usuario_id']; // con "usuario_id", no "id_usuario"

$sqlImagen = "SELECT imagen FROM usuarios WHERE id = :id";
$stmtImagen = $conn->prepare($sqlImagen);
$stmtImagen->execute([':id' => $usuario_id]);
$imagenUsuario = $stmtImagen->fetchColumn();
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
                        <span class="align-middle me-3 text-uppercase text-white fw-bold fs-9 p-2">TitanFortress</span>
                    </a>

                    <ul class="sidebar-nav position-relative w-100">
                        <li class="sidebar-header">Navegación</li>

                        <li class="sidebar-item">
                            <a href="index.php" class="sidebar-link">
                                <i class="bi bi-house"></i>
                                <span class="align-middle">Inicio</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="sobre_nosotros.php" class="sidebar-link">
                                <i class="bi bi-diagram-3-fill"></i>
                                <span class="align-middle">Sobre Nosotros</span>
                            </a>
                        </li>

                        <li class="sidebar-header">Servicios</li>

                        <li class="sidebar-item">
                            <a href="conexionesMaquina.php" class="sidebar-link">
                                <i class="bi bi-diagram-3-fill"></i>
                                <span class="align-middle">Conexiones</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="usuarios.php" class="sidebar-link">
                                <i class="bi bi-people-fill"></i>
                                <span class="align-middle">Usuarios</span>
                            </a>
                        </li>

                        <?php if ($isAdmin): ?>
                            <li class="sidebar-header"><?= htmlspecialchars($nombreUsuario) ?></li>

                            <li class="sidebar-item">
                                <a href="modificaciones.php" class="sidebar-link">
                                    <i class="bi bi-gear-fill"></i>
                                    <span class="align-middle">Modificaciones</span>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="permisos.php" class="sidebar-link">
                                    <i class="bi bi-person-gear"></i>
                                    <span class="align-middle">Permisos</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="sidebar-item logout-item">
                <a href="desconexion.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span class="align-middle">Desconectarse</span>
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
                                    <img src="img/usuarios/<?= $imagenUsuario ?>" class="imgUSU">
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
                                <a href="desconexion.php" class="dropdown-item">
                                    Desconectarse
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="p-0 container-fluid">
                    <div class="mb-2 mb-xl-2 row">
                        <div class="d-none d-sm-block col-auto">
                            <h3>Conexiones a Maquinas</h3>
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
                                    <div class="contenido">
                                        <h2>Máquinas asignadas</h2>

                                        <?php if ($resultados): ?>
                                            <table class="tabla_resultados">
                                                <thead>
                                                    <tr>
                                                        <th>Dirección IP</th>
                                                        <th>Puerto</th>
                                                        <th>Hostname</th>
                                                        <th>Usuario Máquina</th>
                                                        <th>Contraseña</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($resultados as $i => $m): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($m['direccion_ip'] ?? '-') ?></td>
                                                            <td><?= htmlspecialchars($m['puerto'] ?? '-') ?></td>
                                                            <td><?= htmlspecialchars($m['maquina'] ?? '-') ?></td>

                                                            <?php if ($rol === 'administrador' || (isset($m['nivel_permiso']) && ($m['nivel_permiso'] === 'ver_credenciales' || $m['nivel_permiso'] === 'administrar'))): ?>
                                                                <td><?= htmlspecialchars($m['usuario_maquina'] ?? '-') ?></td>
                                                                <td>
                                                                    <span id="pass<?= $i ?>" style="display: none;">
                                                                        <?= htmlspecialchars($m['contraseña'] ?? '') ?>
                                                                    </span>
                                                                    <button id="btn<?= $i ?>" onclick="verPassword(<?= $i ?>)"
                                                                        class="boton_ver">VER</button>
                                                                    <span id="timer<?= $i ?>"
                                                                        style="margin-left:10px; display:none; color:#a41515;"></span>
                                                                </td>
                                                            <?php else: ?>
                                                                <td colspan="2" style="text-align:center; color: #888;">No
                                                                    autorizado</td>
                                                            <?php endif; ?>

                                                            <td>
                                                                <a href="detallesMaquina.php?id=<?= htmlspecialchars($m['id_maquina']) ?>"
                                                                    class="btn btn-info">Ver</a>

                                                                <?php if (
                                                                    $rol === 'administrador' ||
                                                                    (isset($m['nivel_permiso']) &&
                                                                        ($m['nivel_permiso'] === 'conectar' || $m['nivel_permiso'] === 'administrar')
                                                                    )
                                                                ): ?>
                                                                    <a href="descargar_rdp.php?id=<?= htmlspecialchars($m['id_maquina']) ?>"
                                                                        class="btn btn-success">Conectar</a>
                                                                <?php else: ?>
                                                                    <span class="text-muted">Sin permiso</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p>No hay máquinas asignadas.</p>
                                        <?php endif; ?>

                                        <script>
                                            function verPassword(index) {
                                                const passSpan = document.getElementById(`pass${index}`);
                                                const btn = document.getElementById(`btn${index}`);
                                                const timer = document.getElementById(`timer${index}`);

                                                let seconds = 5;
                                                timer.textContent = `Ocultando en ${seconds}s`;
                                                timer.style.display = "inline";
                                                passSpan.style.display = "inline";
                                                btn.style.display = "none";

                                                const interval = setInterval(() => {
                                                    seconds--;
                                                    if (seconds > 0) {
                                                        timer.textContent = `Ocultando en ${seconds}s`;
                                                    } else {
                                                        clearInterval(interval);
                                                        passSpan.style.display = "none";
                                                        btn.style.display = "inline";
                                                        timer.style.display = "none";
                                                    }
                                                }, 1000);
                                            }
                                        </script>

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
                                    <li class="list-inline-item"><a href="#" class="text-muted">Política de
                                            privacidad</a>
                                    </li>
                                    <li class="list-inline-item"><a href="#" class="text-muted">Términos y
                                            condiciones</a>
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