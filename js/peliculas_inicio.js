document.addEventListener('DOMContentLoaded', function() {
    const peliculaImgs = document.querySelectorAll('.pelicula-img');
    const modal = new bootstrap.Modal(document.getElementById('peliculaModal'));
    let currentPeliculaId = null;
    let currentPeliculaImg = null;

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

        fetch(`procesos/like_pelicula.php?id=${currentPeliculaId}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modalLikes').textContent = data.newLikes;
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
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error al dar like.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});

