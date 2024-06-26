// cursos de inicio
document.addEventListener('DOMContentLoaded', function () {
    fetch('../model/get_courses.php')
        .then(response => response.json())
        .then(data => {
            const cursosContainer = document.getElementById('cursos-container');
            const cursoTemplate = document.getElementById('curso-template').innerHTML;

            data.forEach(curso => {
                // Crear un contenedor temporal para usar el innerHTML
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = cursoTemplate;

                const cursoDiv = tempDiv.firstElementChild;

                // Reemplazar contenido
                cursoDiv.querySelector('.titulo-curso').textContent = curso.titulo_curso;
                cursoDiv.querySelector('.descripcion-curso').textContent = curso.descripcion;
                cursoDiv.querySelector('.like-button').onclick = () => likeCurso(cursoDiv);
                cursoDiv.querySelector('.dislike-button').onclick = () => dislikeCurso(cursoDiv);
                cursoDiv.querySelector('.ver-lecciones-link').href = `../view/seccion7.php?curso_id=${curso.curso_id}`;

                cursosContainer.appendChild(cursoDiv);
            });
        })
        .catch(error => {
            console.error('Error fetching courses:', error);
        });
});


// cargar lecciones
function cargarLecciones(cursoId) {
    fetch(`../model/get_lessons.php?curso_id=${cursoId}`)
        .then(response => response.json())
        .then(data => {
            const leccionesContainer = document.getElementById('lecciones-container');
            leccionesContainer.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevas lecciones

            data.forEach(leccion => {
                const leccionDiv = document.createElement('div');
                leccionDiv.className = 'leccion';

                const titulo = document.createElement('h2');
                titulo.textContent = leccion.titulo_leccion;

                const contenido = document.createElement('p');
                contenido.textContent = leccion.contenido;

                const fecha = document.createElement('p');
                fecha.textContent = `Fecha: ${leccion.fecha_registro}`;

                leccionDiv.appendChild(titulo);
                leccionDiv.appendChild(contenido);
                leccionDiv.appendChild(fecha);
                leccionesContainer.appendChild(leccionDiv);
            });
        })
        .catch(error => {
            console.error('Error fetching lessons:', error);
        });
}

// agregar leccion 
function cargarLecciones(cursoId) {
    fetch(`../model/get_lessons.php?curso_id=${cursoId}`)
        .then(response => response.json())
        .then(data => {
            const leccionesContainer = document.getElementById('lecciones-container');
            leccionesContainer.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevas lecciones

            data.forEach(leccion => {
                const leccionDiv = document.createElement('div');
                leccionDiv.className = 'leccion';

                const titulo = document.createElement('h2');
                titulo.textContent = leccion.titulo_leccion;

                const contenido = document.createElement('p');
                contenido.textContent = leccion.contenido;

                const fecha = document.createElement('p');
                fecha.textContent = `Fecha: ${leccion.fecha_registro}`;

                leccionDiv.appendChild(titulo);
                leccionDiv.appendChild(contenido);
                leccionDiv.appendChild(fecha);
                leccionesContainer.appendChild(leccionDiv);
            });
        })
        .catch(error => {
            console.error('Error fetching lessons:', error);
        });
}

function agregarLeccion() {
    const leccionesDiv = document.getElementById('lecciones');

    // Crear el HTML de la nueva lección
    const nuevaLeccionHTML = `
      <div class="col-md-12 mt-3">
          <div class="bg-dark p-3 rounded">
              <div class="form-group mb-3">
                  <label for="titulo_leccion" class="form-label">Título de la lección</label>
                  <input type="text" class="form-control" name="titulo_leccion[]" placeholder="Título de la lección" required>
              </div>
              <div class="form-group mb-3">
                  <label for="contenido_leccion" class="form-label">Descripción</label>
                  <textarea class="form-control" name="contenido_leccion[]" placeholder="Descripción" required></textarea>
              </div>
              <div class="form-group mb-3">
                  <label for="archivo_leccion" class="form-label">Archivo de la lección</label>
                  <input type="file" class="form-control" name="archivo_leccion[]" required>
              </div>
              <button type="button" class="btn btn-danger" onclick="eliminarLeccion(this)">Eliminar lección</button>
          </div>
      </div>
  `;

    // Convertir el HTML a un elemento DOM
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = nuevaLeccionHTML.trim();

    // Agregar la nueva lección al contenedor
    leccionesDiv.appendChild(tempDiv.firstChild);
}

function eliminarLeccion(button) {
    const leccion = button.parentElement.parentElement;
    leccion.remove();
}

function eliminarCurso() {
    if (confirm("¿Estás seguro de que deseas eliminar el curso? Esta acción no se puede deshacer.")) {
        // Aquí puedes agregar la lógica para eliminar el curso
    }
}