<?php
// Verificación básica para asegurar que se ha proporcionado un id válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Parámetro de ID inválido.');
}

$id_usuario = $_GET['id'];

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "wikiprog");

// Verificar si la conexión es exitosa
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta SQL para obtener los datos del usuario por su ID
$sql = "SELECT usuario_id, usuario, correo, rango_id FROM usuario WHERE usuario_id = $id_usuario";

// Ejecución de la consulta
$resultado = $conexion->query($sql);

// Verificar si se encontró el usuario
if ($resultado->num_rows == 1) {
    // Obtener los datos del usuario
    $fila = $resultado->fetch_assoc();
    $usuario_id = $fila['usuario_id'];
    $usuario_nombre = $fila['usuario'];
    $usuario_correo = $fila['correo'];
    $usuario_rango_id = $fila['rango_id'];

    // Aquí puedes colocar el formulario de edición
    // Por ejemplo, un formulario básico para editar nombre y correo
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Editar Usuario</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h2>Editar Usuario</h2>
            <form action="../model/guardar_edicion.php" method="POST">
                <input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>">
                <div class="form-group">
                    <label for="usuario">Nombre de Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario_nombre); ?>" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario_correo); ?>" required>
                </div>
                <div class="form-group">
                    <label for="rango">Rango:</label>
                    <select class="form-control" id="rango" name="rango" required>
                        <option value="1" <?php if ($usuario_rango_id == 1) echo "selected"; ?>>Usuario</option>
                        <option value="2" <?php if ($usuario_rango_id == 2) echo "selected"; ?>>Administrador</option>
                        <option value="3" <?php if ($usuario_rango_id == 3) echo "selected"; ?>>Evaluador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="../controller/controlador.php?seccion=seccion6" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </body>
    </html>
    <?php

} else {
    echo "Usuario no encontrado.";
}

// Cerrar la conexión
$conexion->close();
?>
