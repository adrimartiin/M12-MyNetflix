// Variables globales para el manejo de likes
let currentPeliculaId = null;
let currentPeliculaImg = null;

function initializePeliculaListeners() {
    const peliculaImgs = document.querySelectorAll('.pelicula-img');
    const modal = new bootstrap.Modal(document.getElementById('peliculaModal'));

    peliculaImgs.forEach(img => {
        img.addEventListener('click', function() {
            const titulo = this.getAttribute('data-titulo');
            const descripcion = this.getAttribute('data-descripcion');
            const director = this.getAttribute('data-director');
            const ano = this.getAttribute('data-ano');
            const likes = this.getAttribute('data-likes');
            currentPeliculaId = this.getAttribute('data-id');
            currentPeliculaImg = this;

            document.getElementById('peliculaModalLabel').textContent = titulo;
            document.getElementById('modalDescripcion').textContent = descripcion;
            document.getElementById('modalDirector').textContent = director;
            document.getElementById('modalAno').textContent = ano;
            document.getElementById('modalLikes').textContent = likes;

            // Cambiar el ícono del corazón según el estado del like
            const likeIcon = document.getElementById('likeIcon');
            const likeButtonText = document.getElementById('likeButtonText');
            if (this.getAttribute('data-liked') === 'true') {
                likeIcon.classList.remove('fa-regular');
                likeIcon.classList.add('fa-solid');
                likeButtonText.textContent = 'Quitar Like';
            } else {
                likeIcon.classList.remove('fa-solid');
                likeIcon.classList.add('fa-regular');
                likeButtonText.textContent = 'Dar Like';
            }

            modal.show();
        });
    });
}

// Asegurarse de que el evento DOMContentLoaded solo se añade una vez
document.addEventListener('DOMContentLoaded', initializePeliculaListeners);
document.addEventListener('peliculasCargadas', initializePeliculaListeners);

// Manejar el evento de like
document.getElementById('likeButton').addEventListener('click', function() {
    if (!currentPeliculaId) return;

    // Verificar si el usuario ha iniciado sesión
    if (!document.body.classList.contains('logged-in')) {
        Swal.fire({
            icon: 'warning',
            title: 'Inicia sesión',
            text: 'Debes iniciar sesión para dar like.',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    // Mostrar la URL que se está intentando alcanzar
    const url = `./procesos/like_pelicula.php?id=${currentPeliculaId}`;
    console.log('Intentando alcanzar:', url);

    fetch(url)
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.text(); // Cambiamos a text() para ver la respuesta raw
        })
        .then(rawText => {
            console.log('Respuesta raw del servidor:', rawText);
            const data = JSON.parse(rawText); // Intentamos parsear manualmente
            
            if (data.success) {
                // Actualizar el contador de likes en el modal
                document.getElementById('modalLikes').textContent = data.newLikes;
                
                // Actualizar el atributo data-likes en la imagen
                currentPeliculaImg.setAttribute('data-likes', data.newLikes);
                
                // Actualizar el icono y texto del botón
                const likeIcon = document.getElementById('likeIcon');
                const likeButtonText = document.getElementById('likeButtonText');
                
                if (data.message.includes('añadido')) {
                    likeIcon.classList.remove('fa-regular');
                    likeIcon.classList.add('fa-solid');
                    likeButtonText.textContent = 'Quitar Like';
                    currentPeliculaImg.setAttribute('data-liked', 'true');
                } else {
                    likeIcon.classList.remove('fa-solid');
                    likeIcon.classList.add('fa-regular');
                    likeButtonText.textContent = 'Dar Like';
                    currentPeliculaImg.setAttribute('data-liked', 'false');
                }
            } else {
                throw new Error(data.message || 'Error en la respuesta del servidor');
            }
        })
        .catch(error => {
            console.error('Error detallado:', error);
            console.error('Stack trace:', error.stack);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al procesar la solicitud. Revisa la consola para más detalles.',
                confirmButtonText: 'Aceptar'
            });
        });
});

