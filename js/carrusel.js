// Función para cargar las películas en el carrusel
function cargarPeliculas() {
    // Realiza una solicitud a `get_peliculas.php` para obtener los datos de las películas
    fetch('./procesos/get_peliculas.php')
        .then(respuesta => respuesta.json()) // Convierte la respuesta en JSON
        .then(datos => {
            // Seleccionamos los contenedores del carrusel en el HTML
            const indicadores = document.getElementById("carousel-indicators");
            const contenidoCarrusel = document.getElementById("carousel-inner");
            indicadores.innerHTML = "";
            contenidoCarrusel.innerHTML = "";
            // Recorremos las películas recibidas y creamos los elementos necesarios
            datos.forEach((pelicula, indice) => {
                // Crear un botón indicador (círculos inferiores del carrusel)
                indicadores.innerHTML += `
                    <button type="button" data-bs-target="#miCarrusel" data-bs-slide-to="${indice}" 
                        class="${indice === 0 ? 'active' : ''}" aria-label="Diapositiva ${indice + 1}">
                    </button>
                `;

                // Crear el elemento de la diapositiva del carrusel
                contenidoCarrusel.innerHTML += `
                    <div class="carousel-item ${indice === 0 ? 'active' : ''}">
                        <img src="img/${pelicula.imagen}" class="d-block w-100" 
                            alt="${pelicula.titulo}" style="height: 600px; object-fit: cover;">
                        <div class="container">
                            <div class="carousel-caption">
                                <h1>${pelicula.titulo}</h1>
                                <p>${pelicula.descripcion}</p>
                                <p><strong>Likes: ${pelicula.likes}</strong></p>
                            </div>
                        </div>
                    </div>
                `;
            });
        })
}

// Ejecutamos la función cuando la ventana termine de cargar
window.onload = cargarPeliculas;
