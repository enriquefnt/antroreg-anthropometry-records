
<div class="modal" id="SucessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Se cargo a <?=$datosCaso['ApeNom']?> </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p>Edad: <b><?= $datosCaso['Edad'] ?? '' ?></b> </p> 
        <p>Lugar de residencia <b><?=$datosCaso['Localidad']?></b> </p> 
      </div>
 <div class="modal-footer">
         
            <a href="/Casos/home"  class="btn btn-primary btn-sm" role="button">Guardar y Salir</a>
            <a href="/control/control?idControl=<?= $datosCaso['idControl'] ?? '' ?>&idCaso=<?= $datosCaso['IdCaso'] ?? '' ?>" class="btn btn-primary" role="button">Control</a>
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