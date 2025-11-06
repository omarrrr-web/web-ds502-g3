<!DOCTYPE html>
<html lang="es">
    <?php
        $route = ".";
        $title = "Aplicación Web - DS502 - G3";
        include("pages/template/header.php");
    ?>
<body>
    <?php
    include("pages/template/menubar.php")
    ?>
    <div class="container mt-3">
        <header>
            <h1><i class="fab fa-salesforce"></i><?=$title?></h1>
            <hr>
        </header>
<div id="carouselExampleCaptions" class="carousel slide carousel-fade main-carousel shadow-lg rounded-4 overflow-hidden mx-auto mt-4" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/img1.png" class="d-block w-100" alt="Gestión de Activos">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
        <h5>Control Total sobre tus Activos</h5>
        <p>Visualiza y gestiona todo el inventario de hardware de tu organización.</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/img2.png" class="d-block w-100" alt="Asignación a Empleados">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
        <h5>Asignaciones Claras y Precisas</h5>
        <p>Asigna activos a empleados y mantén un registro detallado de cada movimiento.</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/img3.png" class="d-block w-100" alt="Gestión de Licencias">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
        <h5>Administración de Licencias de Software</h5>
        <p>No pierdas de vista las fechas de vencimiento y la cantidad de usuarios de tus licencias.</p>
      </div>
    </div>
        <div class="carousel-item">
      <img src="images/img4.png" class="d-block w-100" alt="Organización por Categorías">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
        <h5>Organización Intuitiva</h5>
        <p>Clasifica tus activos y licencias por categorías para una fácil localización.</p>
      </div>
    </div>
        <div class="carousel-item">
      <img src="images/img5.png" class="d-block w-100" alt="Roles y Permisos">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
        <h5>Seguridad y Control de Acceso</h5>
        <p>Define roles y permisos para cada empleado dentro del sistema.</p>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>

        <?php
        include("pages/template/footer.php");
        ?>
    </div>
</body>
</html>