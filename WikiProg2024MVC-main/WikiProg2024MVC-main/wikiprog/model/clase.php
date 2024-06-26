<?php
/**
 * Clase Login para manejar operaciones relacionadas con usuarios en la base de datos.
 * 
 * Esta clase permite registrar nuevos usuarios y recuperar datos de usuarios existentes.
 * 
 * @version 1.0
 * @autor Pablo Alexander Mondragon Acevedo
 * @autor Keiner Yamith Tarache Parra
 */
class Login
{
    /**
     * Registra un nuevo usuario en la base de datos.
     *
     * @param string $usuario El nombre de usuario.
     * @param string $correo La dirección de correo electrónico del usuario.
     * @param string $contraseña La contraseña del usuario.
     * @param int $rango_id El identificador del rango o rol del usuario.
     * @return void
     */
    public static function registrar($usuario, $correo, $contraseña, $rango_id)
    {
        // Conexión a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "wikiprog");

        // Consulta SQL para insertar un nuevo usuario en la tabla 'tb_usuarios'
        $sql = "INSERT INTO tb_usuarios(usuario, correo, contraseña, rango_id) VALUES ('$usuario', '$correo', '$contraseña', '$rango_id')";

        // Ejecución de la consulta
        $consulta = $conexion->query($sql);

        // Redirección si la consulta se ejecuta correctamente
        if ($consulta) {
            header("location: ../controller/controlador.php?seccion=seccion6");
        }
    }

    /**
     * Recupera y muestra los datos de todos los usuarios registrados en la base de datos.
     *
     * @return string Cadena de texto con los datos de todos los usuarios.
     */
    public static function ver()
    {
        // Variable para almacenar la salida
        $salida = "";
    
        // Conexión a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "wikiprog");
    
        // Verificar si la conexión es exitosa
        if (!$conexion) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
    
        // Consulta SQL para seleccionar todos los usuarios de la tabla 'usuario'
        $sql = "SELECT usuario_id, usuario, correo, contraseña, rango_id FROM usuario";
    
        // Ejecución de la consulta
        $consulta = $conexion->query($sql);
    
        // Verificar si la consulta fue exitosa
        if (!$consulta) {
            die("Error en la consulta: " . $conexion->error);
        }
    
    // Construcción de la tabla HTML con los datos de los usuarios
    $salida = '<div class="container-fluid" style="max-width:400vh;">';
    $salida .= '<div class="table-responsive">';
    $salida .= '<table class="table table-striped table-hover table-bordered">';
    $salida .= '<thead class="table-dark">';
    $salida .= '<tr>';
    $salida .= '<th scope="col">Usuario</th>';
    $salida .= '<th scope="col">Correo</th>';
    $salida .= '<th scope="col">Rango</th>';
    $salida .= '<th scope="col">Editar</th>';
    $salida .= '<th scope="col">Eliminar</th>';
    $salida .= '</tr>';
    $salida .= '</thead>';
    $salida .= '<tbody>';
    
        while ($fila = $consulta->fetch_assoc()) {
            $usuario_id = $fila['usuario_id']; // Obtener el id del usuario
    
            // Asignar texto correspondiente al rango_id
            $rango_texto = isset($fila["rango_id"]) ? 
                ($fila["rango_id"] == 1 ? "Usuario" : 
                ($fila["rango_id"] == 2 ? "Administrador" : 
                ($fila["rango_id"] == 3 ? "Evaluador" : "Desconocido"))) 
                : "Desconocido";
    
            $salida .= '<tr>';
            $salida .= '<td>' . htmlspecialchars($fila['usuario'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['correo'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . $rango_texto . '</td>';
            $salida .= '<td><a href="../controller/controlador.php?seccion=seccion13&id=' . $usuario_id . '" class="btn btn-primary btn-sm">Editar</a></td>';
            $salida .= '<td><a href="../model/eliminar.php?id=' . $usuario_id . '" class="btn btn-danger btn-sm">Eliminar</a></td>';
            $salida .= '</tr>';
        }
    
        $salida .= '</tbody>';
        $salida .= '</table>';
        $salida .= '</div>'; // Cerrar el div table-responsive
        $salida .= '</div>'; // Cerrar el div container-fluid
    
        // Cerrar la conexión
        $conexion->close();
    
        // Retornar la salida
        return $salida;
    }
    
    
    
}
?>