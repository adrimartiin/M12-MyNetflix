document.addEventListener("DOMContentLoaded", function() {
    var inputBusqueda = document.getElementById('search');
    var tablaResultados = document.getElementById('tabla-resultados'); // Tabla donde se mostrarán los resultados

    // Función para obtener los datos de la tabla
    function obtenerDatos(valorBusqueda = "") {
        fetch('../procesos/proc_users.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ busqueda: valorBusqueda }) // Enviamos el valor de búsqueda en formato JSON
        })
        .then(function(response) {
            if (response.ok) {
                return response.json(); // Si la respuesta es correcta, la convertimos a JSON
            }
        })
        .then(function(data) {
            actualizarTabla(data); // Llamamos a la función para actualizar la tabla con los datos
        });
    }

    // Llamar a la función al cargar la página sin ningún filtro (para mostrar todos los registros)
    obtenerDatos();

    // Event listener para detectar cambios en el campo de búsqueda
    inputBusqueda.addEventListener('input', function() {
        obtenerDatos(inputBusqueda.value);
    });

    // Función para actualizar la tabla con los resultados
    function actualizarTabla(datos) {
        tablaResultados.innerHTML = ''; // Limpiar la tabla

        if (datos.length > 0) {
            datos.forEach(function(item) {
                var fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${item.nombre_usuario}</td>
                    <td>${item.email}</td>
                    <td>${item.fecha_registro}</td>
                    <td>${item.nombre}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="switch-${item.id_usu}">
                            </div>
                        </div>
                    </td>
                `;
                tablaResultados.appendChild(fila);
            });
        } else {
            tablaResultados.innerHTML = '<tr><td colspan="5">No se encontraron resultados</td></tr>';
        }
    }
});
