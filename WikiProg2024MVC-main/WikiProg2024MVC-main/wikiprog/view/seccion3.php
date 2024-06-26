<div class="container">

  <br>
  <div class="contenedor_descripcion" style="background-color: #1a1924; ">
    <div class="row" style="height:20%;">
      <div class="col-md-6" style="display: flex;tex-aling:center;">
        <div class="col-md-6">
          <p>html</p>
        </div>
        <div class="col-md-6">
          <p>¿Ques html?</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="categoria" style="display: flex; padding:10px;text-align: end;">
          <p
            style="background-color: #4f40fa;  margin-right: 10px;border-radius: 5px;height: 100%;color:white;padding:10px">
            Diseño-código-base_de_datos</p>
          <p
            style="padding-left: 20px;margin-right: 10px; background-color: #4f40fa;border-radius: 5px;height: 100%;color:white;padding:10px">
            Nivel:alto</p>
          <a href="controlador.php?seccion=seccion1"
            style="padding-left: 20px;background-color: #4f40fa;border-radius: 5px;height: 100%;color:white;padding:10px;text-decoration: none;">Finalizar
          </a>

        </div>

      </div>
    </div>
  </div>
  <br>
  <div class="contenedorleccion">

    <div id="leccion" class="row" style="padding: 10px;">
      <div class="col-md-3 mx-1" style="background-color:#1a1924; padding:10px; border-radius:10px;">
        <input type="text" name="" id="" placeholder="Titulo De La Leccion" style="width: 100%;"> <br>
        <iframe width="100%" height="200px" src="https://www.youtube.com/embed/6V0ApntlAUw?si=1OU6hiIN0_LsPrgy"
          title="YouTube video player" frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <input type="text" placeholder="Descripción:" style="width: 100%;">
      </div>
      <div class="col-md-3 mx-1" style="background-color:#1a1924; padding:10px; border-radius:10px;">
        <input type="text" name="" id="" placeholder="Titulo De La Leccion" style="width: 100%;"> <br>
        <iframe width="100%" height="200px" src="https://www.youtube.com/embed/6V0ApntlAUw?si=1OU6hiIN0_LsPrgy"
          title="YouTube video player" frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <input type="text" placeholder="Descripción:" style="width: 100%;">
      </div>
      <div class="col-md-3 mx-1" style="background-color:#1a1924; padding:10px; border-radius:10px;">
        <input type="text" name="" id="" placeholder="Titulo De La Leccion" style="width: 100%;"> <br>
        <iframe width="100%" height="200px" src="https://www.youtube.com/embed/6V0ApntlAUw?si=1OU6hiIN0_LsPrgy"
          title="YouTube video player" frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <input type="text" placeholder="Descripción:" style="width: 100%;">
      </div>

    </div>
    <div class="comentario" style="color:white;">
      <?php
      // Datos de conexión a la base de datos
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "wikiprog";

      // Crear conexión
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Verificar conexión
      if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
      }

      // Función para obtener comentarios por lección_id
      function getCommentsByLessonId($leccion_id)
      {
        global $conn;

        // Preparar la consulta SQL
        $sql = "SELECT comentario_id, usuario_id, comentario, fecha, leccion_id FROM comentario WHERE leccion_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $leccion_id);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $result = $stmt->get_result();
        $comments = [];

        if ($result->num_rows > 0) {
          // Recorrer los resultados y almacenarlos en un array
          while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
          }
        }

        // Cerrar el statement
        $stmt->close();

        return $comments;
      }

      // Ejemplo de uso
      $leccion_id = 2; // Reemplaza con el ID de la lección deseada
      $comments = getCommentsByLessonId($leccion_id);

      // Mostrar los comentarios
      if (!empty($comments)) {
        foreach ($comments as $comment) {
          echo "Nombre: " . $comment['usuario_id'] . "<br>";
          echo "Comentario: " . $comment['comentario'] . "<br>";
          echo "Fecha: " . $comment['fecha'] . "<br>";
          echo "Nombre de la lección: " . $comment['leccion_id'] . "<br><br>";
        }
      } else {
        echo "No se encontraron comentarios para esta lección.";
      }

      // Cerrar la conexión a la base de datos
      $conn->close();
      ?>

    </div>
  </div>

</div>