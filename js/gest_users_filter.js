document.addEventListener("DOMContentLoaded", function () {
    // Seleccionamos input de búsqueda y las filas de la tabla accediendo por id y directamente a la clase
    const searchInput = document.getElementById("search");
    const tableRows = document.querySelectorAll(".table_body tr");

    // Añadimos un evento de teclado a input de búsqueda para filtrar la tabla en tiempo real
    searchInput.addEventListener("keyup", function () {
        // Convertimos el texto a minúsculas para facilitar la comparación
        const filter = searchInput.value.toLowerCase();
        // Bucle for each sobre la tabla para recorrer todas las filas
        tableRows.forEach(row => {
            // Se obtienen los elementos de la fila (celdas) y se comprueba si alguna de las celdas contiene el texto de búsqueda
            const cells = row.getElementsByTagName("td");
            let match = false; // Incializamos la variable match a false
            
            // Bucle for para recorrer todas las celdas de la fila
            for (let i = 0; i < cells.length; i++) {
                // Si lo contiene, con la funcion includes comprobamos que coincide y mostramos resultado
                if (cells[i].textContent.toLowerCase().includes(filter)) {
                    match = true;
                    break;
                }
            }
            
            // Si no hay coincidencias, escondemos la fila, si hay coincidencias la mostramos
            row.style.display = match ? "" : "none";
        });
    });
});
