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
<div id="carouselExampleCaptions" class="carousel slide shadow-lg rounded-4 overflow-hidden mx-auto mt-4" style="max-width: 900px;">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/img1.png" class="d-block w-100" alt="Slide 1" style="object-fit: contain; height: 400px;">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/img2.png" class="d-block w-100" alt="Slide 2" style="object-fit: contain; height: 400px;">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/img3.png" class="d-block w-100" alt="Slide 3" style="object-fit: contain; height: 400px;">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
      </div>
    </div>
        <div class="carousel-item">
      <img src="images/img4.png" class="d-block w-100" alt="Slide 4" style="object-fit: contain; height: 400px;">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
      </div>
    </div>
        <div class="carousel-item">
      <img src="images/img5.png" class="d-block w-100" alt="Slide 5" style="object-fit: contain; height: 400px;">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
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