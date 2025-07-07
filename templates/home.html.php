<?php $title = "Inicio - Sistema de Registros Antropométricos"; ?>

<div class="container-fluid px-4 py-4">
  <!-- Welcome Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body p-4">
          <h2 class="h4 mb-3">Bienvenido al Sistema de Registros Antropométricos</h2>
          <p class="text-secondary mb-0">Sistema integral para el registro y seguimiento de medidas antropométricas F7 y F8.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
              <i class="bi bi-plus-circle text-primary fs-4"></i>
            </div>
            <h3 class="h5 mb-0">Nuevo Registro</h3>
          </div>
          <p class="text-secondary small mb-3">Agregar un nuevo registro antropométrico al sistema.</p>
          <a href="/casos/busca" class="btn btn-primary w-100">Cargar Registro</a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
      <div class="card h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
              <i class="bi bi-search text-success fs-4"></i>
            </div>
            <h3 class="h5 mb-0">Consultar</h3>
          </div>
          <p class="text-secondary small mb-3">Buscar y visualizar registros existentes en el sistema.</p>
          <a href="/lista/nominal" class="btn btn-success w-100">Ver Registros</a>
        </div>
      </div>
    </div>

    <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'Auditor'): ?>
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
              <i class="bi bi-people text-info fs-4"></i>
            </div>
            <h3 class="h5 mb-0">Usuarios</h3>
          </div>
          <p class="text-secondary small mb-3">Gestionar usuarios y permisos del sistema.</p>
          <a href="/user/listar" class="btn btn-info w-100">Administrar</a>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="col-12 col-md-6 col-xl-3">
      <div class="card h-100">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle bg-secondary bg-opacity-10 p-3 me-3">
              <i class="bi bi-question-circle text-secondary fs-4"></i>
            </div>
            <h3 class="h5 mb-0">Ayuda</h3>
          </div>
          <p class="text-secondary small mb-3">Acceder a la documentación y guías del sistema.</p>
          <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#helpModal">Ver Ayuda</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="helpModalLabel">Ayuda del Sistema</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-4">
          <h6 class="fw-bold mb-2">Registro de Datos</h6>
          <p class="small text-secondary mb-0">Para registrar nuevos datos antropométricos, utilice la opción "Cargar Registro" desde el menú principal o la tarjeta de acceso rápido.</p>
        </div>
        <div class="mb-4">
          <h6 class="fw-bold mb-2">Consulta de Registros</h6>
          <p class="small text-secondary mb-0">Puede consultar los registros existentes utilizando la opción "Ver Registros". El sistema permite filtrar y exportar los datos según sus necesidades.</p>
        </div>
        <div>
          <h6 class="fw-bold mb-2">Soporte</h6>
          <p class="small text-secondary mb-0">Para obtener ayuda adicional, contacte al administrador del sistema o consulte la documentación completa.</p>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

