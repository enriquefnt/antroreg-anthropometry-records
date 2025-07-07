

<div class="modal" id="SucessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Control de <?=$datosCaso['ApeNom'];?> </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p>Edad: <b><?=$datosCaso['edad'];?></b> </p> 
        <p>Lugar: <b><?= $datosCaso['Gid'];?></b> </p> 
        <p>Fecha: <b><?=date('d/m/Y',strtotime($datosControl['FechaControl']));?></b> </p> 
              <p>Peso: <b><?=$datosControl['Peso'];?> kg </b>
            Talla: <b><?=$datosControl['Talla'];?> cm</b></p>

            <p> ZPE/E=<span class="badge bg-<?=$datosControl['alertPE']; ?>"><b>
            <?= number_format($datosControl['CtrolZpe'], 1); ?> </b></span> - 

            ZTA/E=<span class="badge bg-<?=$datosControl['alertTA']; ?> "><b>
            <?= number_format($datosControl['CtrolZta'], 1); ?> </b></span> - 

            ZIMC/E=<span class="badge bg-<?=$datosControl['alertIMC']; ?> "><b>
            <?= number_format($datosControl['CtrolZimc'], 1); ?> </b></span> - 
            
            ZP/T=<span class="badge bg-<?=$datosControl['alertPT']; ?> "><b>
            <?= number_format($datosControl['CtrolPt'], 1); ?> </b></span> 
      </div>
  <fieldset class="border p-2">
<legend class="w-80 p-0 h-0 ">
  <p>Clasificación APS:   <b><?= $datosControl['ClasPeso'] ." - ". $datosControl['ClasTalla']?? ''; ?></b></p>
   </legend>

<!-- <a class="navbar-brand mb-0" href="/lista/porCaso?caso=<?= $datosCaso['IdCaso'] ?? ''; ?>">Ver Evolución</a> -->
<a href="/lista/porCaso?caso=<?= $datosCaso['IdCaso'] ?? ''; ?>"  class="btn btn-primary " role="button">Ver Evolución</a>
<a href="/Casos/home"  class="btn btn-primary " role="button">Salir</a>

   </fieldset>
    
</div>
  <!-- <div class="modal-footer">
    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
    <a href="/casos/editar?caso=<?= $datosCaso['IdCaso']; ?>"  class="btn btn-primary " role="button">Editar</a>
    <a href="/casos/controles?caso=<?= $datosCaso['IdCaso']; ?>"  class="btn btn-primary " role="button">Agregar Control</a> 
    <a href="/lista/porCaso?caso=<?= $datosCaso['IdCaso'] ?? ''; ?>"  class="btn btn-primary " role="button">Ver Evolución</a>


     <a href="/Casos/home"  class="btn btn-primary " role="button">Guardar y salir</a>
            </div>	 -->
      </div> 
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function() {$('#SucessModal').modal('show');
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
});
</script>
