document.addEventListener("DOMContentLoaded", function () {
    // Comprobar si hay un parámetro 'error' o 'mensaje' en la URL
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const mensaje = urlParams.get('mensaje');
    const errorFormato = urlParams.get('errorFormato');

    // Condiciones para mostrar el SweetAlert dependiendo del parámetro 'error'
    if (error) {
        switch (error) {
            case 'contra_incorrecta':
                Swal.fire({
                    icon: 'error',
                    title: 'La contraseña es incorrecta',
                    text: 'Por favor,vuelve a iniciar sesión.'
                });
                break;
            case 'usuario_no_encontrado':
                Swal.fire({
                    icon: 'error',
                    title: 'Usuario no encontrado',
                    text: 'Por favor, vuelve a intentarlo.'
                });
                break;
            default:
                Swal.fire({
                    icon: 'error',
                    title: 'Error inesperado',
                    text: 'Ocurrió un error inesperado. Por favor, inténtelo nuevamente.'
                });
        }
    }

    // Condiciones para mostrar el SweetAlert dependiendo del parámetro 'mensaje'
    if (mensaje) {
        switch (mensaje) {
            case 'logeado':
                Swal.fire({
                    icon: 'success',
                    title: '¡Bienvenido!',
                    text: 'Has iniciado sesión con éxito.'
                });
                break;
            default:
                break;
        }
    }
    if (mensaje) {
        switch (mensaje) {
            case 'errorFormato':
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el formato',
                    text: 'El formato de la imagen no es correcto.'
                });
                break;
            default:
                break;
        }
    }
});
