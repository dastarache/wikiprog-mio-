z<?php
// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../controller/controlador.php?seccion=seccion2&error=not_logged_in");
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wikiprog";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el usuario_id de la sesión
$usuario_id = $_SESSION['usuario_id'];

// Obtener y validar datos del formulario
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$biografia = isset($_POST['biografia']) ? trim($_POST['biografia']) : '';

$errores = [];

if (empty($nombre)) {
    $errores[] = 'El nombre es obligatorio.';
}

if (empty($correo)) {
    $errores[] = 'El correo es obligatorio.';
} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El correo no es válido.';
}

if (empty($biografia)) {
    $biografia = null; // Permitir biografía vacía
}

// Manejo de la imagen de perfil
$directorio_destino = '../img_usuario/';
$nombre_archivo = '';

if (!empty($_FILES['perfil_imagen']['name'])) {
    $nombre_archivo = basename($_FILES['perfil_imagen']['name']);
    $ruta_archivo = $directorio_destino . $nombre_archivo;

    // Movemos el archivo de la carpeta temporal al destino final
    if (!move_uploaded_file($_FILES['perfil_imagen']['tmp_name'], $ruta_archivo)) {
        $errores[] = 'Error al subir la imagen.';
    }
}

if (count($errores) > 0) {
    $_SESSION['errores'] = $errores;
    header("Location: ../controller/controlador.php?seccion=seccion10");
    exit();
}

// Actualizar datos en la base de datos
$sql = "UPDATE usuario SET usuario = ?, correo = ?, biografia = ?, img_usuario = ? WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $nombre, $correo, $biografia, $nombre_archivo, $usuario_id);

if ($stmt->execute()) {
    $_SESSION['exito'] = 'Datos actualizados con éxito.';
} else {
    $_SESSION['errores'] = ['Error al actualizar los datos.'];
}

$stmt->close();
$conn->close();

header("Location: ../controller/controlador.php?seccion=seccion9");
exit();
?>
