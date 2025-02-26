document.addEventListener('DOMContentLoaded', function() {
    // Referencias a los elementos del formulario de filtro
    const tituloFilter = document.getElementById('titulo-filter');
    const directorFilter = document.getElementById('director-filter');
    const anoFilter = document.getElementById('ano-filter');
    const likesOrderBtn = document.getElementById('likes-order');
    
    let likesOrder = null; // null = sin orden, 'asc' = ascendente, 'desc' = descendente
    
    // Función para aplicar los filtros
    function aplicarFiltros() {
        // Construir URL con los parámetros de filtro
        const params = new URLSearchParams();
        
        if (tituloFilter.value) params.append('titulo', tituloFilter.value);
        if (directorFilter.value) params.append('director', directorFilter.value);
        if (anoFilter.value) params.append('ano', anoFilter.value);
        if (likesOrder) params.append('orderLikes', likesOrder);
        
        // Realizar la petición fetch con los filtros
        fetch(`../procesos/proc_films.php?${params.toString()}`)
            .then(response => {
                if (!response.ok) throw new Error('Error en la red');
                return response.json();
            })
            .then(films => {
                actualizarTabla(films);
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al filtrar las películas'
                });
            });
    }
    
    // Función para actualizar la tabla con los resultados filtrados
    function actualizarTabla(films) {
        const resultado = document.getElementById('resultado');
        let tabla = '';
        
        films.forEach(function(item) {
            tabla += `<tr>
                <td>${item.titulo}</td>
                <td class="hide-mobile">${item.descripcion}</td>
                <td>${item.director}</td>
                <td>${item.ano}</td>
                <td class="hide-mobile">${item.likes}</td>
                <td>
                    <div class="action-buttons">
                        <button type='button' class='btn-icon edit' title="Editar">
                            <i class="fas fa-edit" style="color: white;" onclick='Update(${item.id_peli})'></i>
                        </button>
                        <button type="button" class="btn-icon delete" title="Eliminar">
                            <i class="fas fa-trash-alt icon-action" style="color: red;" onclick="Eliminar(${item.id_peli})"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
        });
        
        resultado.innerHTML = tabla;
    }
    
    // Función para actualizar el icono de ordenamiento
    function actualizarIconoOrdenamiento() {
        const icon = likesOrderBtn.querySelector('i');
        icon.className = likesOrder === 'asc' ? 'fas fa-sort-up' :
                        likesOrder === 'desc' ? 'fas fa-sort-down' : 'fas fa-sort';
    }
    
    // Toggle para ordenar por likes
    likesOrderBtn.addEventListener('click', function() {
        likesOrder = likesOrder === null ? 'desc' :
                    likesOrder === 'desc' ? 'asc' :
                    likesOrder === 'asc' ? null : 'desc';
        actualizarIconoOrdenamiento();
        aplicarFiltros();
    });
    
    // Event listeners para los filtros
    tituloFilter.addEventListener('input', debounce(aplicarFiltros, 300));
    directorFilter.addEventListener('input', debounce(aplicarFiltros, 300));
    anoFilter.addEventListener('change', aplicarFiltros);
    
    // Función debounce para evitar muchas peticiones seguidas
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
}); 