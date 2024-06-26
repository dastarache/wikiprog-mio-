<?php
/**
 * Controlador principal de la aplicación.
 *
 * Este archivo gestiona el enrutamiento y la seguridad de las secciones del sitio web.
 *
 * PHP version 7.4
 *
 * @category Controlador
 * @package  WikiProg
 * @version  1.0
 * @author   Pablo Alexander Mondragon Acevedo
 *           Keiner Yamith Tarache Parra
 */

// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener la sección de la URL, si no está presente, se usa 'seccion1' como predeterminada
$seccion = $_GET['seccion'] ?? 'seccion1';
// Obtener el ID de usuario de la sesión, si no está iniciada, se establece como vacío
$usuario_id = $_SESSION['usuario_id'] ?? '';

// Redirigir a la página de inicio de sesión si no ha iniciado sesión y trata de acceder a una sección restringida
$public_sections = ['seccion5', 'seccion2']; // Agregar aquí las secciones públicas
if (empty($usuario_id) && !in_array($seccion, $public_sections)) {
    header("Location: controlador.php?seccion=seccion2");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($seccion); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Estilos -->
    <link rel="icon" href="../css/img/logo.png" type="image/png">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Google Tag Manager -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GQJG3209SE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-GQJG3209SE');
    </script>
</head>

<body>

<!-- Barra de navegación -->
<?php if ($seccion !== 'seccion2'): ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="controlador.php?seccion=seccion1">WikiProg</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="controlador.php?seccion=seccion1">Explorar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="controlador.php?seccion=seccion2">Visual Code</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="controlador.php?seccion=seccion3">Foro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="controlador.php?seccion=seccion4">Cursos</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../css/img/usuario.png" alt="Usuario" class="img-fluid" style="width: 30px;">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion2"><b>Iniciar Sesión</b></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><b>ESTADO</b>
                                <?php echo isset($_SESSION['usuario_id']) ? 'Activo' : 'Inactivo'; ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion9">Tu Perfil</a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion6">Lista De Usuarios</a></li>
                            <li><a class="dropdown-item" href="video.html">Tus Cursos</a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion12">Tu Nube</a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion5"><b>Registro</b></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion10">Configuración</a></li>
                            <li><a class="dropdown-item" href="controlador.php?seccion=seccion11">Ayuda</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
<?php endif; ?>



    <!-- Contenido de la sección -->
    <div class="container" style="margin-top:10px;">
        <?php include ($seccion . ".php"); ?>
    </div>

    <!-- Pie de página -->
    <div class="container">
        <footer>
            <p>© WikiProg 2024</p>
        </footer>
    </div>

    <!-- JavaScript -->
    <script src="../js/perfil.js"></script>
    <script src="../js/buscarCurso"></script>
    <script src="../js/funciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

</body>

</html>