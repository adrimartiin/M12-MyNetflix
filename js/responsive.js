        // Detectar cambios en el tamaño de la ventana
        function checkScreenWidth() {
            const loginContainer = document.querySelector('.login-container');
            const logo = document.querySelector('.login-logo');
            const form = document.querySelector('.d-flex');

            if (window.innerWidth <= 768) {
                // En pantallas pequeñas, aplicar un estilo de columna
                loginContainer.classList.add('flex-column');
                logo.classList.add('mb-4'); // Añadir margen inferior en pantallas pequeñas
                form.classList.add('text-center'); // Centrar formulario en pantallas pequeñas
            } else {
                // En pantallas grandes, eliminar clases
                loginContainer.classList.remove('flex-column');
                logo.classList.remove('mb-4');
                form.classList.remove('text-center');
            }
        }

        // Ejecutar la función al cargar la página y al cambiar el tamaño de la ventana
        window.addEventListener('resize', checkScreenWidth);
        window.addEventListener('load', checkScreenWidth);