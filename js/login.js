document.addEventListener("DOMContentLoaded", function () {
    const nombreUser = document.getElementById('usuario');
    const email = document.getElementById('email');
    const contrasena = document.getElementById('password');
    const repetirContrasena = document.getElementById('repe-password');
    
    const nombreUserError = document.getElementById('nombreUserError');
    const emailError = document.getElementById('emailError');
    const contrasenaError = document.getElementById('contrasenaError');
    const repetirContrasenaError = document.getElementById('repetirContrasenaError');
    const formulario = document.getElementById('registrationForm');
    const formulario1 = document.getElementById('formulario-login');
    // Limpiar mensajes y estilos al cargar la página
    if(formulario){
        [nombreUserError, emailError, contrasenaError, repetirContrasenaError].forEach(error => error.textContent = "");
        [nombreUser, email, contrasena, repetirContrasena].forEach(input => input.style.borderColor = ""); // Asignar eventos
    nombreUser.onblur = nombreCorrecto;
    email.onblur = emailCorrecto;
    contrasena.onblur = contrasenaCorrecto;
    repetirContrasena.onblur = repetirContrasenaCorrecto;
    
    function nombreCorrecto() {
        const value = nombreUser.value.trim();
        const regex = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/;

        if (value === "") {
            nombreUserError.textContent = "El nombre de usuario está vacío";
            nombreUser.style.borderColor = "red";
            return false;
        } else if (value.length < 3) {
            nombreUserError.textContent = "El nombre de usuario debe tener al menos 3 caracteres";
            nombreUser.style.borderColor = "red";
            return false;
        } else if (!regex.test(value)) {
            nombreUserError.textContent = "El nombre de usuario no puede contener números ni caracteres especiales";
            nombreUser.style.borderColor = "red";
            return false;   
        } else {
            nombreUserError.textContent = "";
            nombreUser.style.borderColor = "";
            return true;
        }
    }

    function emailCorrecto() {
        const value = email.value.trim();
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        if (value === "") {
            emailError.textContent = "El email está vacío";
            email.style.borderColor = "red";
            return false;
        } else if (!regex.test(value)) {
            emailError.textContent = "El email no tiene un formato válido";
            email.style.borderColor = "red";
            return false;
        } else {
            emailError.textContent = "";
            email.style.borderColor = "";
            return true;
        }
    }

    function contrasenaCorrecto() {
        const value = contrasena.value.trim();
        if (value === "") {
            contrasenaError.textContent = "La contraseña está vacía";
            contrasena.style.borderColor = "red";
            return false;
        } else if (value.length < 6) {
            contrasenaError.textContent = "La contraseña debe tener al menos 6 caracteres";
            contrasena.style.borderColor = "red";
            return false;
        } else {
            contrasenaError.textContent = "";
            contrasena.style.borderColor = "";
            return true;
        }
    }

    function repetirContrasenaCorrecto() {
        if (repetirContrasena.value.trim() === "") {
            repetirContrasenaError.textContent = "Debes repetir la contraseña";
            repetirContrasena.style.borderColor = "red";
            return false;
        } else if (repetirContrasena.value !== contrasena.value) {
            repetirContrasenaError.textContent = "Las contraseñas no coinciden";
            repetirContrasena.style.borderColor = "red";
            return false;
        } else {
            repetirContrasenaError.textContent = "";
            repetirContrasena.style.borderColor = "";
            return true;
        }
    }
    
    formulario.onsubmit = function (event) {
        let formIsValid = true;
        if (!nombreCorrecto()) formIsValid = false;
        if (!emailCorrecto()) formIsValid = false;
        if (!contrasenaCorrecto()) formIsValid = false;
        if (!repetirContrasenaCorrecto()) formIsValid = false;

        if (!formIsValid) { 
            event.preventDefault();
        }
    };
    } else   if (formulario1) {
        const nombreUsuario = document.getElementById('usuario-login');
        const password = document.getElementById('password-login');
        const error_form = document.getElementById('error-form');

        formulario1.onsubmit = function (event) {
            let formIsValid1 = true;

            if (nombreUsuario.value.trim() === "" || password.value.trim() === "") {
                error_form.textContent = "El usuario o contraseña son incorrectos";
                nombreUsuario.style.borderColor = "red";
                password.style.borderColor = "red";
                formIsValid1 = false;
            } else {
                error_form.textContent = "";
                nombreUsuario.style.borderColor = "";
                password.style.borderColor = "";
            }

            if (!formIsValid1) {
                event.preventDefault();
            }
        };
    }

   

});