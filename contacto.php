<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bankini</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="SASS/styles.css">
</head>
<body>
      
    <!-- Barra lateral -->
    <div class="sidebar">
        <h3>Bankini</h3>
        <img class="logo" src="img/Logo-removebg-preview.png" alt="Logo" width="60" height="40">
        <ul>
            <li><a href="banco.php">Inicio</a></li>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="sobre-nosotros.php">Sobre Nosotros</a></li>
            <li><a href="#">Contacto</a></li>
            <li><a href="#">Ayuda</a></li>
        </ul>
    </div>
 <!-- Contacto -->
 <div id="contactame" class="seccion-contacto">
  <div class="container contacto">
    <div class="row">
      <div class="col-md-5 border-right mr-4">
        <h2>CONTACTO</h2>
        <form>
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email">
          </div>
          <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea class="form-control" id="mensaje" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary boton-enviar">Enviar Mensaje</button>
        </form>
      </div>
      <div class="col-md-5 border-left ml-4">
        <h2>UBICACION</h2>
        <iframe class="mapa-responsivo" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12678.601724304739!2d-5.931715987391038!3d37.39809845013164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd126f311a421575%3A0xee06aca07d9f2f6c!2sSevilla%20Este%2C%20Sevilla!5e0!3m2!1ses!2ses!4v1699912931579!5m2!1ses!2ses" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>    
      </div>
    </div>  
  </div>
</div>

</body>
</html>