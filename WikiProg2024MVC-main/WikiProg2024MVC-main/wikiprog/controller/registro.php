<?php
/**
 * Procesamiento del formulario de registro de usuarios.
 *
 * Este archivo se encarga de gestionar la conexión a la base de datos,
 * validar los datos del formulario de registro, proteger contra inyecciones SQL,
 * verificar la existencia del usuario o correo en la base de datos, y realizar
 * la inserción del nuevo usuario si no existe previamente, además de validar
 * la aceptación de términos y condiciones.
 *
 * PHP version 7.4
 *
 * @category Procesamiento
 * @package  WikiProg
 * @version  1.0
 * @author   Pablo Alexander Mondragon Acevedo
 *           Keiner Yamith Tarache Parra
 */

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wikiprog";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Obtener los datos del formulario de registro
$user = $_POST['username'];
$email = $_POST['email'];
$bio = $_POST['biografia'];
$pass = $_POST['password'];

// Proteger contra inyecciones SQL
$user = $conn->real_escape_string($user);
$email = $conn->real_escape_string($email);
$bio = $conn->real_escape_string($bio);
$pass = $conn->real_escape_string($pass);

// Verificar si se aceptaron los términos y condiciones
if (!isset($_POST['terminos'])) {
    // Mostrar un mensaje de error y redirigir o manejar el error según la lógica de la aplicación
    echo "Debes aceptar los términos y condiciones para registrarte.";
    exit; // Detener la ejecución del script
}

// Verificar si el usuario ya existe en la base de datos
$sql = "SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Usuario o correo ya están en uso
    echo "El nombre de usuario o el correo ya están en uso";
} else {
    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuario (usuario, correo, biografia, contraseña, rango_id) VALUES ('$user', '$email', '$bio', '$pass', 1)";
    
    if ($conn->query($sql) === TRUE) {
        // Registro exitoso, redirigir a la página de inicio de sesión
        echo "Registro exitoso. Puedes iniciar sesión ahora.";
        header("Location: ../index.php");
    } else {
        // Error al insertar en la base de datos
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
