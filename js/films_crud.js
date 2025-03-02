// Añadir estas variables al inicio del archivo
const ITEMS_PER_PAGE = 10;
let currentPage = 1;
let totalItems = 0;

window.onload = function () {
    ListaFilms();
    InsertFilm();
}
function ListaFilms() {
    const resultado = document.getElementById('resultado'); // Elemento donde se mostrará la lista de películas

    // Realizar la solicitud fetch para obtener los datos de las películas
    fetch('../procesos/proc_films.php')
        .then(response => {
            if (response.ok) {
                return response.json(); // Convertir la respuesta en formato JSON
            } else {
                throw new Error('Error al cargar los datos');
            }
        })
        .then(films => {
            totalItems = films.length;
            const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
            
            // Paginar los resultados
            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
            const endIndex = startIndex + ITEMS_PER_PAGE;
            const paginatedFilms = films.slice(startIndex, endIndex);
            
            let tabla = '';

            // Recorremos el array de películas y construimos las filas de la tabla HTML
            paginatedFilms.forEach(function (item) {
                let str = "<tr><td>" + item.titulo + "</td>";
                str += "<td class='hide-mobile'>" + item.descripcion + "</td>";
                str += "<td>" + item.director + "</td>";
                str += "<td>" + item.ano + "</td>";
                str += "<td class='hide-mobile'>" + item.likes + "</td>";
                str += "<td>";
                str += "<div class='action-buttons'>";
                str += `<i class="fas fa-edit icon-action" onclick='Update(${item.id_peli})'></i>`;
                str += `<i class="fas fa-trash-alt icon-action" style="color: red;" onclick="Eliminar(${item.id_peli})"></i>`;
                str += "</div>";
                str += "</td>";
                str += "</tr>";
                tabla += str;
            });

            // Insertar la tabla construida en el elemento resultado
            resultado.innerHTML = tabla;
            
            // Actualizar la paginación
            updatePagination(totalPages);
        })
        .catch(error => {
            console.error('Error:', error);
            resultado.innerText = 'Error al cargar las películas';
        });
}

function updatePagination(totalPages) {
    const paginationContainer = document.getElementById('pagination');
    
    // Si no hay suficientes items para paginar, ocultamos la paginación
    if (totalItems <= ITEMS_PER_PAGE) {
        paginationContainer.innerHTML = '';
        return;
    }
    
    let paginationHTML = '';
    
    // Botón Anterior
    paginationHTML += `
        <button class="pagination-button" 
                onclick="changePage(${currentPage - 1})" 
                ${currentPage === 1 ? 'disabled' : ''}>
            <i class="fas fa-chevron-left"></i>
        </button>`;

    // Lógica para mostrar números de página con puntos suspensivos
    let pagesToShow = [];
    
    if (totalPages <= 7) {
        // Si hay 7 o menos páginas, mostrar todas
        pagesToShow = Array.from({length: totalPages}, (_, i) => i + 1);
    } else {
        // Siempre mostrar primera página
        pagesToShow.push(1);
        
        if (currentPage > 3) {
            pagesToShow.push('...');
        }
        
        // Páginas alrededor de la página actual
        for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
            pagesToShow.push(i);
        }
        
        if (currentPage < totalPages - 2) {
            pagesToShow.push('...');
        }
        
        // Siempre mostrar última página si hay más de una página
        if (totalPages > 1) {
            pagesToShow.push(totalPages);
        }
    }

    // Generar botones de página
    pagesToShow.forEach(page => {
        if (page === '...') {
            paginationHTML += `<span class="pagination-separator">...</span>`;
        } else {
            paginationHTML += `
                <button class="pagination-button ${currentPage === page ? 'active' : ''}" 
                        onclick="changePage(${page})"
                        ${totalItems <= ITEMS_PER_PAGE ? 'disabled' : ''}>
                    ${page}
                </button>`;
        }
    });
    
    // Botón Siguiente - solo se muestra si hay más de una página
    if (totalPages > 1) {
        paginationHTML += `
            <button class="pagination-button" 
                    onclick="changePage(${currentPage + 1})" 
                    ${currentPage === totalPages ? 'disabled' : ''}>
                <i class="fas fa-chevron-right"></i>
            </button>`;
    }
    
    paginationContainer.innerHTML = paginationHTML;
}

function changePage(newPage) {
    if (newPage >= 1 && newPage <= Math.ceil(totalItems / ITEMS_PER_PAGE)) {
        currentPage = newPage;
        ListaFilms();
    }
}

// Asegúrate de que la paginación se actualice también cuando se aplican filtros
window.aplicarFiltros = function() {
    currentPage = 1; // Reset a la primera página cuando se aplica un filtro
    ListaFilms();
}

// CREAR
function InsertFilm() {
    document.getElementById('crear').onclick = formCrear;
    function formCrear() {
        Swal.fire({
            title: 'Añadir Película',
            html: `
                <form id="crearForm" style="display: flex; flex-direction: column; gap: 10px; align-items: center; width: 100%;"> 
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;" maxlength="100">
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;" maxlength="255">
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="director">Director:</label>
                        <input type="text" id="director" name="director" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;" maxlength="100">
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="year">Año:</label>
                        <input type="number" id="year" name="year" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;" min="1900" max="${new Date().getFullYear()}">
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="categoria">Categoría:</label>
                        <select id="categoria" name="categoria" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;">
                            <!-- Las opciones de categoría se llenarán dinámicamente desde el servidor -->
                        </select>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="peli_img">Imagen de la Película:</label>
                        <input type="file" id="peli_img" name="peli_img" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;" accept=".jpg,.jpeg,.png,.gif">
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Insertar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'no-scroll-popup'
            },
            didOpen: () => {
                // Obtener las categorías desde el servidor y llenar el select
                fetch('../procesos/get_categorias.php')
                    .then(response => response.json())
                    .then(categorias => {
                        const selectCategoria = document.getElementById('categoria');
                        selectCategoria.innerHTML = ''; // Limpiar el select antes de llenarlo
                        categorias.forEach(categoria => {
                            const option = document.createElement('option');
                            option.value = categoria.id_categoria;
                            option.textContent = categoria.nombre;
                            selectCategoria.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al cargar categorías:', error));
            },
            preConfirm: () => {
                var formulario = document.getElementById('crearForm');
                const formData = new FormData(formulario);

                // Validaciones adicionales
                const titulo = formData.get('titulo');
                const descripcion = formData.get('descripcion');
                const director = formData.get('director');
                const year = formData.get('year');
                const categoria = formData.get('categoria');
                const imagen = document.getElementById('peli_img').files[0];

                if (!titulo || !descripcion || !director || !year || !categoria) {
                    Swal.showValidationMessage('Todos los campos son obligatorios');
                    return false;
                }

                if (!/^[a-zA-Z\s]+$/.test(director)) {
                    Swal.showValidationMessage('El nombre del director solo debe contener letras y espacios');
                    return false;
                }

                if (imagen) {
                    const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    const fileExtension = imagen.name.split('.').pop().toLowerCase();
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!allowedExtensions.includes(fileExtension)) {
                        Swal.showValidationMessage('El formato de la imagen no es válido');
                        return false;
                    }

                    if (imagen.size > maxSize) {
                        Swal.showValidationMessage('El tamaño de la imagen no debe exceder 2MB');
                        return false;
                    }
                }

                // Solicitud Ajax
                return fetch('../procesos/proc_insertFilms.php', {
                    method: 'POST', // Método POST para enviar datos
                    body: formData // Enviar datos del formulario, incluyendo la imagen
                })
                .then(response => {
                    if (response.ok) {
                        return response.text(); // Puedes usar .json() si el PHP retorna JSON
                    } else {
                        throw new Error('Error al insertar la película');
                    }
                })
                .then(responseText => {
                    console.log('Respuesta del servidor:', responseText);
                    Swal.fire({
                        icon: 'success',
                        title: 'Película Insertada Correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    if (window.aplicarFiltros) {
                        window.aplicarFiltros();
                    } else {
                        ListaFilms();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    }
}

// Eliminar
function Eliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../procesos/proc_deleteFilms.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Película eliminada correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    if (window.aplicarFiltros) {
                        window.aplicarFiltros();
                    } else {
                        ListaFilms();
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al eliminar',
                        text: data.error
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la solicitud',
                    text: 'No se pudo conectar con el servidor'
                });
            });
        }
    });
}

// Editar 
function Update(id) {
    fetch(`../procesos/proc_getFilm.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener la película');
            }
            return response.json();
        })
        .then(film => {
            if (film.error) {
                throw new Error(film.error);
            }

            Swal.fire({
                title: 'Editar Película',
                html: `
                    <form id="editarForm" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 10px; align-items: center; width: 100%;">
                        <input type="hidden" id="id" name="id" value="${film.id_peli}">
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="titulo">Título:</label>
                            <input type="text" id="titulo" name="titulo" class="swal2-input" value="${film.titulo}" style="width: 85%; height: 35px; font-size: 16px;" maxlength="100">
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" id="descripcion" name="descripcion" class="swal2-input" value="${film.descripcion}" style="width: 85%; height: 35px; font-size: 16px;" maxlength="255">
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="director">Director:</label>
                            <input type="text" id="director" name="director" class="swal2-input" value="${film.director}" style="width: 85%; height: 35px; font-size: 16px;" maxlength="100">
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="year">Año:</label>
                            <input type="number" id="year" name="year" class="swal2-input" value="${film.ano}" style="width: 85%; height: 35px; font-size: 16px;" min="1900" max="${new Date().getFullYear()}">
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="categoria">Categoría:</label>
                            <select id="categoria" name="categoria" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;">
                                <!-- Las opciones de categoría se llenarán dinámicamente desde el servidor -->
                            </select>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="imagen_actual">Imagen Actual:</label>
                            <img src="../img/${film.imagen}" alt="Imagen actual" style="width: 150px; margin: 10px 0;">
                            <input type="hidden" name="imagen_actual" value="${film.imagen}">
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="nueva_imagen">Nueva Imagen (opcional):</label>
                            <input type="file" id="nueva_imagen" name="nueva_imagen" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;" accept=".jpg,.jpeg,.png,.gif">
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Actualizar',
                cancelButtonText: 'Cancelar',
                didOpen: () => {
                    // Obtener las categorías desde el servidor y llenar el select
                    fetch('../procesos/get_categorias.php')
                        .then(response => response.json())
                        .then(categorias => {
                            const selectCategoria = document.getElementById('categoria');
                            selectCategoria.innerHTML = ''; // Limpiar el select antes de llenarlo
                            categorias.forEach(categoria => {
                                const option = document.createElement('option');
                                option.value = categoria.id_categoria;
                                option.textContent = categoria.nombre;
                                if (categoria.id_categoria === film.id_categoria) {
                                    option.selected = true;
                                }
                                selectCategoria.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error al cargar categorías:', error));
                },
                preConfirm: () => {
                    const formData = new FormData(document.getElementById('editarForm'));
                    
                    // Validaciones de campos
                    const titulo = formData.get('titulo');
                    const descripcion = formData.get('descripcion');
                    const director = formData.get('director');
                    const year = formData.get('year');
                    const categoria = formData.get('categoria');
                    const imagen = document.getElementById('nueva_imagen').files[0];

                    if (!titulo || !descripcion || !director || !year || !categoria) {
                        Swal.showValidationMessage('Todos los campos son obligatorios');
                        return false;
                    }

                    if (!/^[a-zA-Z\s]+$/.test(director)) {
                        Swal.showValidationMessage('El nombre del director solo debe contener letras y espacios');
                        return false;
                    }

                    if (imagen) {
                        const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                        const fileExtension = imagen.name.split('.').pop().toLowerCase();
                        const maxSize = 2 * 1024 * 1024; // 2MB

                        if (!allowedExtensions.includes(fileExtension)) {
                            Swal.showValidationMessage('El formato de la imagen no es válido');
                            return false;
                        }

                        if (imagen.size > maxSize) {
                            Swal.showValidationMessage('El tamaño de la imagen no debe exceder 2MB');
                            return false;
                        }
                    }

                    return fetch('../procesos/proc_updateFilm.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al actualizar la película');
                        }
                        return response.json(); // Cambiado a JSON para manejar la respuesta
                    })
                    .then(data => {
                        if (!data.success) {
                            throw new Error(data.error || 'Error desconocido al actualizar');
                        }
                        return data; // Retornar datos para el siguiente then
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Éxito', 'Película actualizada correctamente', 'success');
                    if (window.aplicarFiltros) {
                        window.aplicarFiltros();
                    } else {
                        ListaFilms();
                    }
                }
            }).catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', error.message || 'No se pudo actualizar la película', 'error');
            });
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudo obtener la película', 'error');
        });
}








