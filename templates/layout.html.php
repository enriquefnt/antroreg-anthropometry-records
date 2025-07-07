<?php
if (isset($_SESSION['inicio']) && (time() - $_SESSION['inicio'] > 2400)) {
    
    session_unset();     
    session_destroy();   
    header('Location: /login/login');
}
$_SESSION['inicio'] = time(); // actualiza ultimo uso
?>

<!DOCTYPE html>
<html lang="es" class="min-h-screen">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Sistema de Registros Antropométricos F7 y F8">
  <meta name="theme-color" content="#0d6efd">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" type="text/css" href="/styles.css">
<!-- <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> -->


<script src="https://kit.fontawesome.com/f6cbba0704.js" crossorigin="anonymous"></script>
 <!-- -----------------jquery----------------- -->
 <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<!-- --------------bootstrap--------------------- -->

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- -------------------datatables-------------------- -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.6/sb-1.3.3/sp-2.0.1/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.3/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.6/sb-1.3.3/sp-2.0.1/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>





<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>

                        <!-- Chart.js y moment.js  -->

   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
  
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 

<link rel="shortcut icon" type="image/x-icon" href="https://www.flaticon.es/iconos-gratis/crecimiento-personal">
<!-- <link rel="shortcut icon" type="image/x-icon" href="../public/favicon.ico">
<a href="https://www.flaticon.es/iconos-gratis/crecimiento-personal" title="crecimiento personal iconos">Crecimiento personal iconos creados por juicy_fish - Flaticon</a> -->
  <title><?=$title?></title>
  <script src="/autocom.js"></script>
 
</head>
  <body class="w3-light-grey" > 

 

<header class="py-3 bg-primary shadow-sm">
  <div class="container-fluid px-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between">
      <h1 class="h4 text-white mb-0">Registros Antropométricos - F7 y F8</h1>

      <?php if (isset($_SESSION['username'])): ?>
        <div class="text-white small">
          <span class="fw-medium">Usuario:</span> 
          <?= htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']) ?> 
          <span class="mx-1">-</span>
          <?= htmlspecialchars($_SESSION['establecimiento_nombre']) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</header>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid px-4">
    <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  <?php if ($loggedIn): ?>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav gap-lg-3">
          <li class="nav-item">
            <a class="nav-link px-0 <?= $uri === 'casos/home' ? 'active fw-medium' : '' ?>" href="/casos/home">
              <i class="bi bi-house-door me-1"></i>Inicio
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link px-0 <?= $uri === 'casos/busca' ? 'active fw-medium' : '' ?>" href="/casos/busca">
              <i class="bi bi-plus-circle me-1"></i>Carga
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link px-0 <?= $uri === 'lista/nominal' ? 'active fw-medium' : '' ?>" href="/lista/nominal">
              <i class="bi bi-search me-1"></i>Consulta
            </a>
          </li>
     
        

          <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'Auditor'): ?>
          <li class="nav-item dropdown">
            <a class="nav-link px-0 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-people me-1"></i>Usuarios
            </a>
            <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="/user/user">
                  <i class="bi bi-person-plus me-2"></i>Cargar Usuario
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/user/listar">
                  <i class="bi bi-pencil me-2"></i>Ver/Editar
                </a>
              </li>
            </ul>
          </li>
            <?php endif; ?>
          <li class="nav-item ms-lg-auto"> 
            <a class="nav-link px-0 text-danger" href="/login/logout">
              <i class="bi bi-box-arrow-right me-1"></i>Salir
            </a>
          </li>
        </ul>
      </div>
    </div>
    <?php else: ?>
      <a class="nav-link active " aria-current="page" href="/login/login">Ingresar con contraseña (Usuarios registrados)</a>
    <?php endif; ?>
  </nav>




</header>
 <main class="w3-row-padding table-container">  
  <div class="w3-container" >
    
  <?=$output ?? ''?>

  </div>  
  </main>
<footer class="py-3 bg-primary text-white mt-auto">
  <div class="container-fluid px-4">
    <p class="text-center small mb-0">
      MSP - DNyAS - Sistema de Vigilancia Nutricional
      <span class="opacity-75 d-block mt-1">v1.0</span>
    </p>
  </div>
</footer>

 


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<script src="\datatable.js"> </script>
<script src="\scripts.js"> </script>

<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>


</body>
</html>