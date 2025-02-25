document.addEventListener("DOMContentLoaded", function () {
    var inputBusqueda = document.getElementById('search');
    var tablaResultados = document.getElementById('tabla-resultados');

    function obtenerDatos(valorBusqueda = "") {
        fetch('../procesos/proc_users.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ busqueda: valorBusqueda })
        })
        .then(response => response.json())
        .then(data => actualizarTabla(data));
    }

    obtenerDatos(); // Cargar datos al inicio

    inputBusqueda.addEventListener('input', function () {
        obtenerDatos(inputBusqueda.value);
    });

    function actualizarTabla(datos) {
        tablaResultados.innerHTML = ''; 

        if (datos.length > 0) {
            datos.forEach(function (item) {
                var fila = document.createElement('tr');
                var checked = item.estado === 'activo' ? 'checked' : ''; // Si está activo, marcar el switch
                var estadoTexto = item.estado === 'activo' ? 'habilitado' : 'deshabilitado'; // Texto inicial del estado
                var disabled = item.rol === 'admin' ? 'disabled' : ''; // Deshabilitar el switch si es admin
                
                fila.innerHTML = `
                    <td>${item.nombre_usuario}</td>
                    <td>${item.email}</td>
                    <td>${item.fecha_registro}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input switch-usuario" type="checkbox" role="switch" id="switch-${item.id_usu}" ${checked} ${disabled} data-id="${item.id_usu}">
                                <span class="estado-texto">${estadoTexto}</span>
                            </div>
                        </div>
                    </td>
                `;
                tablaResultados.appendChild(fila);
            });

            // Agregar event listener a todos los switches
            document.querySelectorAll('.switch-usuario').forEach(switchUsuario => {
                switchUsuario.addEventListener('change', function () {
                    let idUsuario = this.getAttribute('data-id');
                    let nuevoEstado = this.checked ? 'activo' : 'inactivo';
                    let estadoTexto = this.checked ? 'habilitado' : 'deshabilitado'; // Actualizar texto del estado

                    fetch('../procesos/cambiar_estado_usuario.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id_usu: idUsuario, estado: nuevoEstado })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert('Error al cambiar el estado');
                            this.checked = !this.checked; // Restaurar el estado si hubo error
                        } else {
                            this.nextElementSibling.textContent = estadoTexto; // Actualizar el texto del estado
                        }
                    });
                });
            });
        } else {
            tablaResultados.innerHTML = '<tr><td colspan="5">No se encontraron resultados</td></tr>';
        }
    }
});
