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

// Consulta SQL para obtener los datos del usuario incluyendo la ruta de la imagen
$sql = "SELECT usuario, correo, biografia, img_usuario, rango_id FROM usuario WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Mostrar los datos del usuario
    while ($row = $result->fetch_assoc()) {
        // Verificar si existe 'rango_id' en $row antes de usarlo
        $rango_texto = isset($row["rango_id"]) ? 
        ($row["rango_id"] == 1 ? "Usuario" : 
        ($row["rango_id"] == 2 ? "Administrador" : 
        ($row["rango_id"] == 3 ? "Evaluador" : "Desconocido"))) 
        : "Desconocido";
        
        echo "<div class='container'>";
        echo "<div class='container_titulo'>";
        echo "<div class='row'>";
        echo "<div class='col-md-3'>";
        echo "<div class='circulo'><img src='../img_usuario/" . htmlspecialchars($row["img_usuario"]) . "' alt='Imagen de perfil' width='100%' height='100%' class='circulo'></div>";
        echo "</div>";
        echo "<div class='col-md-3'>";
        echo "<p>Nombre de usuario: " . htmlspecialchars($row["usuario"]) . "</p><br>";
        echo "<p>Rango: " . htmlspecialchars($rango_texto) . "</p>";
        echo "</div>";
        echo "<div class='col-md-3'>";

        echo "</div>";
        echo "<div class='col-md-3'>";
        echo "<button type='button' id='eliminarCuentaBtn' onclick='abrirModal()'>Eliminar Cuenta</button>";
        echo "<button type='button' style='margin-left: 5px;'><a href='controlador.php?seccion=seccion10' style='text-decoration: none; color: white;'>Editar Perfil</a></button>";
        echo "</div>";
        echo "<div id='myModal' class='modal'>";
        echo "<div class='modal-content'>";
        echo "<span class='close' onclick='cerrarModal()'>&times;</span>";
        echo "<p>¿Seguro que quieres eliminar la cuenta?</p>";
        echo "<form method='POST' action='../model/eliminar_perfil.php'>";
        echo "<button type='submit' id='siBtn'>Sí</button>";
        echo "</form>";
        echo "<button id='noBtn' onclick='cerrarModal()'>No</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<br><br>";
        echo "</div>";
        echo "<div class='container_usuario'>";
        echo "<div class='row'>";
        echo "<div class='col-md-3'>";
        echo "<h5 style='color: white;'>Información del usuario</h5>";
        echo "</div>";
        echo "<div class='col-md-9'>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<div class='container_proyecto'>";
        echo "<div class='row'>";
        echo "<div class='col-md-5 d-flex flex-column align-items-start'>";
        echo "<div id='columna1' class='kj'>";
        echo "<h5 style='color: white; text-align: center;'>Datos</h5>";
        echo "<p style='color: white;'>Biografía: " . htmlspecialchars($row["biografia"]) . "</p>";
        echo "<p style='color: white;'>Correo : " . htmlspecialchars($row["correo"]) . "</p>";
        echo "</div>";
        echo "</div>";
        echo "<div class='col-md-7 d-flex flex-column align-items-center'>";
        echo "<div id='columna2' class='div'>";
        echo "<h5 style='color: white; text-align: center;'>Cargar mi proyecto </h5>";
        echo "<form action='../model/actualizar_datos.php' method='POST' enctype='multipart/form-data'>";
        echo "<textarea id='proyectoTextArea' class='w-75' style='margin-left: 70px;' cols='15' rows='8'></textarea><br>";
        echo "<center>";
        echo "<button type='submit' class='btn btn-primary mt-2'>Enviar</button>";
        echo "</center>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "0 resultados";
}

$stmt->close();
$conn->close();
?>
<script>
function abrirModal() {
    document.getElementById('myModal').style.display = "block";
}

function cerrarModal() {
    document.getElementById('myModal').style.display = "none";
}
</script>
