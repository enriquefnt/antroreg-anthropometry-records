<div class="container">
   <legend class="w-80 p-0 h-0 ">
    <p>Carga de Control
    </p>
</legend>
<fieldset class="border p-2">
	<legend class="w-80 p-0 h-0 " style="font-size: 0.95rem;font-weight: bold;">  <?=$datosCaso['ApeNom'].' - '.$datosCaso['edad'].' - '. $datosCaso['Dni'] ;?>
   </legend>
<form onkeydown="return event.key != 'Enter';" class="row g-3"  action=""  onsubmit="myButton.disabled = true; return true;" method="post" autocomplete="off" >
		
	<input type="hidden" name="Control[IdCaso]"  id="NotCaso"   value=<?=$datosCaso['IdCaso'] ?? ''?>>
	<input type="hidden" name="Control[IdControl]"  id="IdControl"   value=<?=$datosCaso['IdControl'] ?? ''?>>
          
<div class="col-sm-2">	
			<label class="form-label-sm" for="FechaControl">Fecha</label>
			<div class="input-group">
			<input class="form-control form-control-sm" type="date"  max="<?=date('Y-m-d');?>"
			
			name="Control[FechaControl]" id="FechaControl" required="required" value="<?=$datosNoti['FechaControl'] ?? ''?>">
			<span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Indique la fecha del registro, esta debe coincidir con la que reslizó el control antopometrico. En el calendario observara el rango válido de fechas permitidas"></i>
      </span>
</div>
</div>

<div class="col-sm-2">	
			<label class="form-label-sm" for="Peso">Peso (kg)</label>
			<input class="form-control form-control-sm" type="number" step="0.01" min="1" max="60" name="Control[Peso]"
			 id="Peso" required="required" >
</div>

<div class="col-sm-2">	
			<label class="form-label-sm" for="Talla">Talla (cm)</label>
			<input class="form-control form-control-sm" type="number" step="0.1" min="30" max="150" name="Control[Talla]"
			 id="Talla" required="required" >
</div>

<div class="form-group">
			<label class="form-label-sm" for="Observaciones">Observaciones</label>
			 <textarea class="form-control" rows="3" id="NotObserva" name="Control[Observaciones]"
			 value="<?=$datosCOntrol['Observaciones'] ?? ''?>">
			</textarea>
</div> 

</fieldset>
	<fieldset class="border p-2">       
<div class="col-sm-3">
  
<!-- <a href="/Casos/home"  class="btn btn-primary btn-sm" role="button">Salir sin cambiar</a> -->
<input type="submit" id="myButton"  name=submit class="btn btn-primary btn-sm" value="Guardar">
</div>
	</fieldset>
 </form>
</div>




