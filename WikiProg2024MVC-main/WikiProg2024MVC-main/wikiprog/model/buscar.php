<?php
/**
 * Script para buscar cursos en la base de datos y devolver resultados en formato JSON.
 * 
 * Este script recibe un parámetro GET 'q' que contiene el término de búsqueda.
 * Realiza una consulta a la base de datos para buscar cursos cuyo título o descripción
 * contenga el término de búsqueda. Luego, devuelve los resultados encontrados en formato JSON.
 * 
 * @version 1.0
 * @author Tu Nombre
 */

// Configuración de la conexión a la base de datos
$servername = "localhost";  // Servidor de la base de datos
$username = "root";         // Usuario de la base de datos
$password = "";             // Contraseña de la base de datos
$dbname = "wikiprog";       // Nombre de la base de datos

// Crear conexión a la base de datos usando mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión ha fallado
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener el término de búsqueda desde el parámetro GET 'q'
$searchTerm = $_GET['q'] ?? '';

// Preparar la consulta SQL para buscar cursos por título o descripción que contenga el término de búsqueda
$sql = "SELECT curso_id, titulo_curso, descripcion FROM curso WHERE titulo_curso LIKE ? OR descripcion LIKE ?";
$stmt = $conn->prepare($sql);

// Preparar los parámetros de búsqueda para evitar SQL injection
$searchTerm = "%{$searchTerm}%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);

// Ejecutar la consulta
$stmt->execute();

// Obtener resultados de la consulta
$result = $stmt->get_result();

$courses = array();

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Recorrer cada fila de resultados y guardar en un array
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();

// Establecer encabezado para indicar que se devolverá JSON
header('Content-Type: application/json');

// Devolver los datos en formato JSON
echo json_encode($courses);
?>
