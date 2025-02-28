document.addEventListener('DOMContentLoaded', function() {
    const filtros = document.querySelectorAll('.form-select');
    const peliculasContainer = document.getElementById('peliculas-container');

    function cargarPeliculas() {
        const categoria = document.getElementById('filtroCategoria').value;
        const director = document.getElementById('filtroDirector').value;
        const ano = document.getElementById('filtroAno').value;

        let url = './procesos/cargar_peliculas.php?';
        if (categoria) url += `categoria=${categoria}&`;
        if (director) url += `director=${director}&`;
        if (ano) url += `ano=${ano}`;

        // Limpiar el contenido anterior
        peliculasContainer.innerHTML = 'Cargando...';

        fetch(url)
            .then(response => response.text())
            .then(data => {
                peliculasContainer.innerHTML = data;
            })
            .catch(error => {
                peliculasContainer.innerHTML = 'Error al cargar las películas.';
            });
    }

    filtros.forEach(filtro => {
        filtro.addEventListener('change', cargarPeliculas);
    });

    // Cargar las películas al inicio
    cargarPeliculas();
});