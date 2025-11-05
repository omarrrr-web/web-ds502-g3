<nav class="navbar navbar-expand-lg" style="background-color:darkcyan;">
  <div class="container-fluid">
  <a class="nav-link active" aria-current="page" href="<?=$route?>"><i class="fas fa-home me-2"></i>Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="https://www.senati.edu.pe"><i class="fas fa-graduation-cap text-light me-2"></i>SENATI</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=$route?>/empleado"><i class="fas fa-users text-info me-2"></i>Empleados</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=$route?>/rol"><i class="fas fa-user-tag text-warning me-2"></i>Roles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=$route?>/categoria"><i class="fas fa-tags text-success me-2"></i>Categorías</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=$route?>/activos"><i class="fas fa-box text-primary me-2"></i>Activos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=$route?>/licencias"><i class="fas fa-id-badge text-danger me-2"></i>Licencias</a>
        </li>
      </ul>
    </div>
  </div>
</nav>