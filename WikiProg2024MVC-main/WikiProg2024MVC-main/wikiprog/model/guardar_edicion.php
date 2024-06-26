<?php
// Verificación de petición POST para asegurar que los datos se están enviando correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificación básica para asegurar que se ha proporcionado un id de usuario válido
    if (!isset($_POST['usuario_id']) || !is_numeric($_POST['usuario_id'])) {
        die('Parámetro de ID inválido.');
    }

    // Obtener y sanitizar los datos del formulario
    $usuario_id = $_POST['usuario_id'];
    $usuario_nombre = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $usuario_correo = htmlspecialchars($_POST['correo'], ENT_QUOTES, 'UTF-8');
    $usuario_rango_id = $_POST['rango'];

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "wikiprog");

    // Verificar si la conexión es exitosa
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Consulta SQL para actualizar los datos del usuario
    $sql = "UPDATE usuario SET usuario = '$usuario_nombre', correo = '$usuario_correo', rango_id = $usuario_rango_id WHERE usuario_id = $usuario_id";

    // Ejecución de la consulta
    if ($conexion->query($sql) === TRUE) {
        // Redirigir de vuelta a la página principal o a donde sea apropiado después de editar
        header("Location: ../controller/controlador.php?seccion=seccion6");
        exit();
    } else {
        echo "Error al actualizar usuario: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
} else {
    // Si no es una petición POST, redirigir a alguna página de error o a donde sea apropiado
    header("Location: ../controller/controlador.php?seccion=seccion6");
    exit();
}
?>
