// Mensaje de bienvenida en mayusculas
window.onload = function() {
    var nombreElemento = document.getElementById("nombre");
    if (nombreElemento) {
        nombreElemento.textContent = nombreElemento.textContent.toUpperCase();
    }
}