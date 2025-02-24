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
            let tabla = '';

            // Recorremos el array de películas y construimos las filas de la tabla HTML
            films.forEach(function (item) {
                let str = "<tr><td>" + item.titulo + "</td>";
                str += "<td>" + item.descripcion + "</td>";
                str += "<td>" + item.director + "</td>";
                str += "<td>" + item.ano + "</td>";
                str += "<td>" + item.likes + "</td>";
                str += "<td>";
                str += " <button type='button' class='btn btn-success' onclick='Update(" + item.id_peli + ")'>Editar</button>";
                str += ` <button type="button" class="btn btn-danger" onclick="Eliminar(${item.id_peli})">Eliminar</button>`;
                str += "</td>";
                str += "</tr>";
                tabla += str;
            });

            // Insertar la tabla construida en el elemento resultado
            resultado.innerHTML = tabla;

        })
        .catch(error => {
            console.error('Error:', error);
            resultado.innerText = 'Error al cargar las películas';
        });
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
                        <input type="text" id="titulo" name="titulo" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;">
                    </div>
                   <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;">
                    </div>
                    
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="precio">Director:</label>
                        <input type="text" id="director" name="director" class="swal2-input" step="0.01" style="width: 85%; height: 35px; font-size: 16px;">
                    </div>
                    
                    <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="cantidad">Año:</label>
                        <input type="number" id="year" name="year" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;">
                    </div>

                      <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                        <label for="cantidad">Imagen de la Película:</label>
                        <input type="file" id="peli_img" name="peli_img" class="swal2-input" style="width: 85%; height: 35px; font-size: 16px;">
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Insertar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'no-scroll-popup'
            },
            preConfirm: () => {
                var formulario = document.getElementById('crearForm');
                const formData = new FormData(formulario);

                // validacion genérica para los campos
                if (!formData.get('titulo') ||!formData.get('descripcion') || !formData.get('director') || !formData.get('year')) {
                    Swal.showValidationMessage('Todos los campos son obligatorios');
                    return;
                }

                // Solicitud Ajax
                fetch('../procesos/proc_insertFilms.php', {
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
                    ListaFilms(); // Actualiza la lista de películas
                })
                .catch(error => {
                    console.error('Error:', error);
                });
                
            }
        });

        // Elimina el scroll del popup
        document.querySelector('.swal2-popup').style.overflow = 'hidden';

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
                    ListaFilms(); // Actualizar la lista de películas
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
    // Solicitar los datos de la película a editar
    fetch(`../procesos/proc_getFilm.php?id=${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener la película');
            }
            return response.json();
        })
        .then(film => {
            // Verificar si se obtuvo un error en la respuesta
            if (film.error) {
                throw new Error(film.error);
            }

            Swal.fire({
                title: 'Editar Película',
                html: `
                    <form id="editarForm" method="POST" style="display: flex; flex-direction: column; gap: 10px; align-items: center; width: 100%;">
                        <input type="hidden" id="id" name="id" value="${film.id_peli}">
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="titulo">Título:</label>
                            <input type="text" id="titulo" name="titulo" class="swal2-input" value="${film.titulo}" style="width: 85%; height: 35px; font-size: 16px;">
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" id="descripcion" name="descripcion" class="swal2-input" value="${film.descripcion}" style="width: 85%; height: 35px; font-size: 16px;">
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="director">Director:</label>
                            <input type="text" id="director" name="director" class="swal2-input" value="${film.director}" style="width: 85%; height: 35px; font-size: 16px;">
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                            <label for="year">Año:</label>
                            <input type="number" id="year" name="year" class="swal2-input" value="${film.ano}" style="width: 85%; height: 35px; font-size: 16px;">
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Actualizar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const formData = new FormData(document.getElementById('editarForm'));
                    // Validación de campos
                    if (!formData.get('titulo') || !formData.get('descripcion') || !formData.get('director') || !formData.get('year')) {
                        Swal.showValidationMessage('Todos los campos son obligatorios');
                        return;
                    }
                    // Enviar datos al servidor
                    return fetch('../procesos/proc_updateFilm.php', {
                        method: 'POST',
                        body: formData
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error('Error al actualizar la película');
                        }
                        return response.json(); // Cambiado a JSON para manejar la respuesta
                    }).then(data => {
                        if (!data.success) {
                            throw new Error(data.error || 'Error desconocido al actualizar');
                        }
                        return data; // Retornar datos para el siguiente then
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Película actualizada correctamente');
                    ListaFilms(); // Actualiza la lista de películas
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







