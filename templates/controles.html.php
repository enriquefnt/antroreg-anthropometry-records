<div class="position-relative">
  <div class="position-absolute top-0 end-0" style="z-index: 5;">
    <div class="col-12 col-md-auto">
      <button type="button" class="btn btn-outline-primary" onclick="history.back()">
        <i class="fas fa-arrow-left"></i>
       
      </button>
    </div>
  </div>

<div class="container mt-4">

<fieldset class="border p-2">
<legend class="w-80 p-0 h-0 "><?= $datosCaso['ApeNom']; ?>
   </legend>
 
<table id="example" class="table table-striped table-sm table-condensed small" data-searchbuilder="true" style="width:100%">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Edad (Años/Meses/Días)</th>
            <th>Peso (kg)</th>
            <th>Talla (cm)</th>
            <th>Z Peso/edad</th>
            <th>Z Talla/edad</th>
            <th>Z IMC/edad</th>
            <th>Z Peso/Talla</th>
            <th>Clasificación APS</th>
            <!-- <th>Clasificación</th> -->
            <th>Controlado por</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($error)): ?>
            <tr><td colspan="9"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></td></tr>
        <?php else: ?>
            <?php foreach ($datosControl as $control): ?>
                <tr>
                    <td><?= htmlspecialchars($control['Fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($control['años'] .' A ' . $control['meses'] .' M ' . $control['dias'] .' D ', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($control['Peso'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($control['Talla'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($control['ZPE'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($control['ZTE'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($control['ZIMC'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($control['ZPT'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <!-- <td><?= htmlspecialchars($control['Clasificacion'], ENT_QUOTES, 'UTF-8'); ?></td> -->
                    <td><?= htmlspecialchars($control['claseAPS'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars($control['Operador'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</fieldset>
</div>

 <div class="container mt-4">

<fieldset class="border p-2">
<legend class="w-80 p-0 h-0 ">Gráficas
   </legend>

<input type="button" class="w3-button w3-ripple w3-grey" onclick="location.href='/lista/grafico?indicador=PE&caso=<?= $datosCaso['IdCaso']; ?>';" value="Peso/Edad">
<input type="button" class="w3-button w3-ripple w3-grey" onclick="location.href='/lista/grafico?indicador=TE&caso=<?= $datosCaso['IdCaso']; ?>';" value="Talla/Edad">
<input type="button" class="w3-button w3-ripple w3-grey" onclick="location.href='/lista/grafico?indicador=IE&caso=<?= $datosCaso['IdCaso']; ?>';" value="IMC/Edad">


   </fieldset>
    
</div>

	
