
<?php
	if (!empty($errors)) :
?>
	<div class="alert alert-warning" role="alert">

				<p>Controle los siguiente:</p>
		<ul>
	<?php
	foreach ($errors as $error) :
	?>
			<li><?= $error ?></li>
	<?php
	endforeach; ?>
		</ul>
	</div>
<?php
endif;
?>

<div class="container">

<fieldset class="border p-2">
	
 <legend class="w-80 p-0 h-0 ">Datos personales 
   </legend>
<form onkeydown="return event.key != 'Enter';" class="row g-3"  action=""  onsubmit="myButton.disabled = true;
 return true;" method="post" autocomplete="off" id="formulario">
		
	
	<input type="hidden" name="Caso[IdCaso]" value="<?=$datosCaso['IdCaso'] ?? ''?>">
	
          
<div class="col-sm-2">	
			<label class="form-label-sm" for="Nombre">Nombre</label>
			
			<input class="form-control form-control-sm" type="text" name="Caso[Nombre]" id="Nombre" required="required" value="<?=$datosCaso['Nombre'] ?? ''?>">
			
</div>
<div class="col-sm-2">	
			<label class="form-label-sm" for="Apellido">Apellido</label>
			<input class="form-control form-control-sm" type="text" name="Caso[Apellido]" id="Apellido" required="required" value="<?=$datosCaso['Apellido'] ?? ''?>">
</div>

<div class="col-sm-2">	
			<label class="form-label-sm" for="Dni">DNI</label>
			<div class="input-group">
			<input class="form-control form-control-sm" type="number" name="Caso[Dni]" id="Dni" min="0" max="99999999"  value="<?=$datosCaso['Dni'] ?? ''?>">
			<span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Indique el número de documento sin puntos. En caso de ser idocumentado coloque 0 "></i>
      </span>
</div>
</div>

<div class="col-sm-2">	
			<label class="form-label-sm" for="FecNac">Fecha de Nacimiento</label>
			<div class="input-group">
			<input class="form-control form-control-sm" type="date" name="Caso[FecNac]" id="FecNac" required="required" min="<?=$fechaInf ?? ''?>"  max="<?=date('Y-m-d');?>"  value="<?=$datosCaso['FecNac'] ?? ''?>">
			<span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="El sistema no permite el registro de Casos mayores de 6 años"></i>
      </span>
</div>
</div>

<div class="col-sm-2">
  <label class="form-label-sm" for="tipo">Sexo</label>
  <select name="Caso[Sexo]" id="Sexo" class="form-control form-control-sm">
  	<option hidden selected><?=$datosCaso['Sexo'] ?? '...'?></option>
    <option value='Femenino'>Femenino</option>
    <option value='Masculino'>Masculino</option>
    <option value='No determinado'>No determinado</option>
        </select>
 </div>


<div class="col-sm-4">
  <label class="form-label-sm" for="ResiLocal">Localidad</label>
  <input type="text" name="Caso[ResiLocal]" id="ResiLocal" class="form-control form-control-sm" autocomplete="off"  value="<?=$datosCaso['Localidad'] ?? ''?>" >
  <!-- <input type="hidden" name="Domicilio[IdResi]" value="<?=$datosDomi['IdResi'] ?? ''?>"> -->
  <input type="hidden" name="Caso[Gid]" id="Gid" value="<?= $data['value'] ?? $datosCaso['gid'] ?? '' ?>" />
 </div>

</fieldset>
<fieldset class="border p-2">
	<div class="d-flex">
		<div class="col-sm-3">
			<?php if (empty($datosCaso)): ?>
            <input type="submit" id="myButton" name="submit" class="btn btn-primary" value="Guardar">
		</div>
         <?php elseif (isset($datosCaso)): ?>
		<div class="col-sm-3">
            <input type="submit" id="myButton" name="submit" class="btn btn-primary" value="Guardar cambios">
			<a href="/control/control?idControl=<?= $datosCaso['idControl'] ?? '' ?>&idCaso=<?= $datosCaso['IdCaso'] ?? '' ?>" class="btn btn-primary" role="button">Control</a>
        <?php endif; ?>					
		 </div>
			</div>
			</fieldset>
 </form>
</div>

<script>
var auto_complete = new Autocom(document.getElementById('ResiLocal'), {
	data: <?php echo json_encode($data); ?>,
	maximumItems: 10,
	highlightTyped: true,
	highlightClass: 'fw-bold text-primary',
	onSelectItem: function(selectedItem) {
		document.getElementById('Gid').value = selectedItem.value; // Asignar el valor del item seleccionado al input hidden
	//document.getElementById('IdCaso').value = selectedItem.value; 
  }
});
</script>
<script>
var auto_complete = new Autocom(document.getElementById('Caso'), {
	data: <?php echo json_encode($dataCaso); ?>,
	maximumItems: 15,
	highlightTyped: true,
	highlightClass: 'fw-bold text-primary',
	onSelectItem: function(selectedItem) {
		document.getElementById('IdCaso').value = selectedItem.value; 
	}
});
</script>

<script>
document.getElementById('FecNac').addEventListener('input', function() {
    var inputDate = new Date(this.value);
    var minDate = new Date('<?= $fechaLimite ?>');

    if (inputDate < minDate) {
        document.getElementById('fechaError').textContent = 'La fecha debe ser al menos 6 años atrás.';
    } else {
        document.getElementById('fechaError').textContent = '';
    }
});
</script>

