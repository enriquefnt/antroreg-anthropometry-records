
<canvas id="graficoLineas" >
    <p>Datos de crecimiento</p>
</canvas>

<!-- <div  class="col-md-2">
<input type="button" class="w3-button w3-ripple w3-grey" value="Volver al listado" onClick="history.go(-1);">
</div> -->
<div class="position-relative">
  <div class="position-absolute top-0 end-0" style="z-index: 5;">
    <div class="col-12 col-md-auto">
      <!-- <button type="button" class="btn btn-outline-primary" onclick="history.back()">
        <i class="fas fa-arrow-left"></i> -->
       <button type="button" class="btn btn-outline-primary" onclick="goBackToModal()">
  <i class="fas fa-arrow-left"></i>
</button>
    </div>
  </div>
<script>
const datosRef = <?php echo json_encode($data); ?>;
</script>

<script type="module" src="\grafica.js"></script>
<script>
function goBackToModal() {
  localStorage.setItem('openModal', 'true'); // Almacena un valor en localStorage
  history.back(); // Regresa a la página anterior
}
</script>