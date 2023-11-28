function validarFormulario() {
    var nombre = document.getElementById("nombre").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var mensajeError = "";

    // Validación del nombre
    if(nombre.length < 3) {
        mensajeError += "El nombre debe tener al menos 3 caracteres.\n";
    }

    // Validación de la contraseña
    if(password.length < 6) {
        mensajeError += "La contraseña debe tener al menos 6 caracteres.\n";
    }

    if(mensajeError) {
        alert(mensajeError);
        return false; // Evitar que el formulario se envíe
    }

    return true; // Enviar el formulario
}
