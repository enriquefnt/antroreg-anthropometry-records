<?php
if (!empty($errors)) :
?>
 <div class="alert alert-warning" role="alert">
    <p>No se puede crear el usuario, revise:</p>
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
 <legend class="w-80 p-0 h-0 ">Datos personales para nuevo usuario
   </legend>

  <form onkeydown="return event.key != 'Enter';" class="row g-3"  action="" method="post" id='formulario' autocomplete="off" >
  <input type="hidden" name="Usuario[id_usuario]" id="id_usuario" value=<?=$datosUser['id_usuario'] ?? ''?> >
       
  <div class="col-sm-6">
  	<label class="form-label-sm" for="nombre">Nombres</label>
    <div class="input-group">
    <input type="text"  class="form-control form-control-sm" name="Usuario[nombre]"  autocomplete="off" value="<?=$datosUser['nombre'] ?? ''?>">
      <span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Anote el o los nombres del nuevo unsuario"></i>
      </span>
    
</div>
</div>

  <div class="col-sm-6">
  <label class="form-label-sm" for="apellido">Apellidos</label>
  <div class="input-group">
  <input type="text" required="required" class="form-control form-control-sm" name="Usuario[apellido]"  autocomplete="off" value="<?=$datosUser['apellido'] ?? ''?>">
      <span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Anote el o los apellidos del nuevo unsuario"></i>
      </span>
</div>
</div>

<div class="col-sm-3">
  <label class="form-label-sm" for="profesion">Profesión</label>
  <div class="input-group">
  <select name="Usuario[profesion]"  class="form-control form-control-sm">
    <option hidden selected><?=$datosUser['profesion'] ?? '...'?></option>
    <option value='Enfermería'>Enfermería</option>
    <option value='Nutrición'>Nutrición</option>
    <option value='Medicina'>Medicina</option>
    <option value='Agente Sanitario'>Agente Sanitario</option>
    <option value='Administrativo'>Administrativo</option>
    <option value='Otros'>Otros</option>
    </select>
    <span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Seleccione el agrupamiento profesional al que pertenece el nuevo usuario"></i>
      </span>
</div>
 </div>

<div class="col-sm-3">
  <label class="form-label-sm" for="tipo">Función</label>
  <div class="input-group">
  <select name="Usuario[tipo]" id="tipo" class="form-control form-control-sm">
  	<option hidden selected><?=$datosUser['tipo'] ?? '...'?></option>
  <!--  <option value='1'>Administrador</option> -->
    <option value='Auditor'>Auditor</option>
    <option value=Profesional>Vigilante</option>
    <option value='Administrativo'>Administrativo</option>
    <option value='Otros'>Otros</option>
    </select>
    <span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Seleccione la funcion ejercerá el nuevo usuario"></i>
      </span>
</div>
</div>

 <div class="col-sm-6">
    	<label class="form-label-sm" for="establecimiento_nombre">Institución</label>
      <div class="input-group">
    	<input type="text" name="Usuario[establecimiento_nombre]" id="establecimiento_nombre" class="form-control form-control-sm" autocomplete="off" value="<?=$datosUser['establecimiento_nombre'] ?? ''?>">
      <span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" 
      title="Seleccione el establecimiento donde tiene asignada la mayor parte de las horas el nuevo usuario"></i>
      </span>
		    </div>
        </div>
   <div>
            <input type="hidden" name="Usuario[id_establecimiento]" id="id_establecimiento"  value="<?=$data['value'] ??$datosUser['id_establecimiento'] ?? ''?>" />
            <!-- <input type="hidden" name="Noticon[establecimiento_id]" id="establecimiento_id" value="<?= $data['value'] ?? $datosNoti['establecimiento_id'] ?? '' ?>" /> -->
        </div>     


<div class="col-sm-3">		
			<label class="form-label-sm" for="celular">Celular</label>
      <div class="input-group">
			      <input class="form-control form-control-sm" type="text" id="celular" name="Usuario[celular]" placeholder="###-#######"  data-llenar-campo="celular" pattern="[0-9]{3}-[0-9]{7}"  value="<?=$datosUser['celular'] ?? ''?>" >
            <span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" 
      title="indique el celular como codigo de área sin 0 - número sin 15, en caso de que el código de área tenga 4 dígitos, agreguelo al cuarto al número"></i>
      </span>
		    </div>
  
    </div>

<div class="col-sm-3">		
			<label class="form-label-sm" for="email">Correo electrónico</label>
      <div class="input-group">
			<input class="form-control form-control-sm" type="email"   name="Usuario[email]" id="email"  value="<?=$datosUser['email'] ?? ''?>">
      <span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" 
      title="Anote el correo electronico particular, puede ser también el institucional si está personalizado.
      No puede haber duplicados en el sistema, 
      si coloca uno  que ya esta en la base, se advertirá que lo cambie"></i>
      </span>
		    </div>
	</div>


<?php 
if(empty($datosUser['user'])) { ?>

<div class="col-sm-3">
	<label class="form-label-sm" for="usuario">Nombre de usuario</label>
  <div class="input-group">
  <input type="text" required="required" class="form-control form-control-sm" name="Usuario[user]"  autocomplete="off" value="<?=$datosUser['user'] ?? ''?>">
  <span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" 
      title="Elija un nombre de usuario que sea facil de recordar, 
      por ejemplo la pirmera letra del nombre seguida del apellido. No puede haber duplicados en el sistema, 
      si coloca uno  que ya esta en la base, se advertirá que lo cambie"></i>
      </span>
		    </div>
</div>

<div class="col-sm-3">
	<label class="form-label-sm" for="password">Contraseña</label>
  <div class="input-group">
  <input type="text" required="required" class="form-control form-control-sm" name="Usuario[password]"  autocomplete="off" value="<?=$datosUser['password'] ?? ''?>">
  <span class="input-group-text">
      <i class="fas fa-info-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="top" 
      title="Puede tener números, letras y caracteres especiales, se sugiere que tenga al menos 6 caracteres"></i>
      </span>
		    </div>
</div>

<?php } ?>

  <div class="col-sm-3">
      <button class="btn btn-primary" type="submit" name="submit">Enviar</button>
  </div>
</fieldset>
  </form>

</div>
</div>

<script>
var options = {
 data: <?php echo json_encode($data_insti); ?>,
 maximumItems: 10,
 highlightTyped: true,
 highlightClass: 'fw-bold text-primary',
 onSelectItem: function(selectedItem) {
    document.getElementById('id_establecimiento').value = parseInt(selectedItem.value); // Asignar el valor del item seleccionado al input hidden
 }
};

var auto_complete = new Autocom(document.getElementById('establecimiento_nombre'), options);
</script>




<!-- <script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script> -->