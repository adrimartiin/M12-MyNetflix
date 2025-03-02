document.addEventListener('DOMContentLoaded', function() {
    const filtroCategoria = document.getElementById('filtroCategoria');
    const filtroNombre = document.getElementById('filtroNombre');
    const filtroAno = document.getElementById('filtroAno');
    const filtroLiked = document.getElementById('filtroLiked');
    const peliculasContainer = document.getElementById('peliculas-container');

    // Función de debounce para evitar demasiadas peticiones
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function cargarPeliculas() {
        const categoria = filtroCategoria.value;
        const nombre = filtroNombre.value;
        const ano = filtroAno.value;
        const liked = filtroLiked.value;

        let url = './procesos/cargar_peliculas.php?';
        if (categoria) url += `categoria=${encodeURIComponent(categoria)}&`;
        if (nombre) url += `nombre=${encodeURIComponent(nombre)}&`;
        if (ano) url += `ano=${encodeURIComponent(ano)}&`;
        if (liked) url += `liked=${encodeURIComponent(liked)}`;

        peliculasContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-light" role="status"><span class="visually-hidden">Cargando...</span></div></div>';

        fetch(url)
            .then(response => response.text())
            .then(data => {
                peliculasContainer.innerHTML = data;
                // Disparar un evento personalizado después de cargar las películas
                const event = new CustomEvent('peliculasCargadas');
                document.dispatchEvent(event);
            })
            .catch(error => {
                peliculasContainer.innerHTML = '<p class="text-danger">Error al cargar las películas.</p>';
                console.error('Error:', error);
            });
    }

    // Aplicar debounce a la búsqueda por nombre
    const cargarPeliculasDebounced = debounce(cargarPeliculas, 300);

    // Event listeners
    filtroCategoria.addEventListener('change', cargarPeliculas);
    filtroNombre.addEventListener('input', cargarPeliculasDebounced);
    filtroAno.addEventListener('input', cargarPeliculasDebounced);
    filtroLiked.addEventListener('change', cargarPeliculas);

    // Cargar las películas al inicio
    cargarPeliculas();
});