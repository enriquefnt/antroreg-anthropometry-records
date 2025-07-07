<div class="container mt-4">
  
  <div>
     
    
  <table id="example" class="table table-striped table-sm text-xs table-condensed small" data-searchbuilder="true" style="width:100%">
  <div>
  <legend class="w-80 p-0 h-0 ">Lista Nominal - 
       </legend>
</div>
   
  <thead>
  <tr class="w3-blue-grey">
    <th class="nosort">Último registro </th>
    <th>Nombre</th>
    <th>Edad (Último control)</th>
    <!-- <th>Edad (Hoy)</th> -->
    <th>Area Operativa</th>
   <th>Localidad</th>
    <th>Z Peso/edad</th>
    <th>Z Talla/edad</th>
    <th>Z IMC/edad</th>
    <th>Z Peso/Talla</th>
    <th>Clasificacion</th>
    <th>Clasificacion APS</th>
   <th>Ver Evolución</th> 
   
  </tr>
  </thead>
  <tbody class="table-hover">
  <?php 

  if(isset($casos)){
  foreach ($casos as $caso): ?>
  <tr >
  <td ><?= htmlspecialchars($caso['Fecha'], ENT_QUOTES, 'UTF-8'); ?></td> 
   
   <td><?= htmlspecialchars($caso['NomApe'], ENT_QUOTES, 'UTF-8'); ?></td>
   <td><?= htmlspecialchars($caso['años'] .'A ' . $caso['meses'] .'M ' . $caso['dias'] .'D ', ENT_QUOTES, 'UTF-8'); ?></td>
   <!-- <td><?= htmlspecialchars($caso['añosr'] .'A ' . $caso['mesesr'] .'M ' . $caso['diasr'] .'D ', ENT_QUOTES, 'UTF-8'); ?></td> -->
   <td><?= htmlspecialchars($caso['AreaOperativa'], ENT_QUOTES, 'UTF-8'); ?></td>
   <td><?= htmlspecialchars($caso['localidad'], ENT_QUOTES, 'UTF-8'); ?></td>
   <!-- <td><?= htmlspecialchars($caso['Tipo'], ENT_QUOTES, 'UTF-8'); ?></td> -->
   <!-- <td><?= htmlspecialchars($caso['MotNom'], ENT_QUOTES, 'UTF-8'); ?></td> -->
   <td text-align="center"><?= htmlspecialchars($caso['ZPE'], ENT_QUOTES, 'UTF-8'); ?></td>
   <td text-align="center" ><?= htmlspecialchars($caso['ZTE'], ENT_QUOTES, 'UTF-8'); ?></td>
   <td text-align="center"><?= htmlspecialchars($caso['ZIMC'], ENT_QUOTES, 'UTF-8'); ?></td>
   <td text-align="center"><?= htmlspecialchars($caso['ZPT'], ENT_QUOTES, 'UTF-8'); ?></td>
   <td><?= htmlspecialchars($caso['Clasificacion'], ENT_QUOTES, 'UTF-8'); ?></td>
   <td><?= htmlspecialchars($caso['claseAPS'], ENT_QUOTES, 'UTF-8'); ?></td>
   <td><a class="navbar-brand mb-0" href="/lista/porCaso?caso=<?= $caso['IdCaso'] ?? ''; ?>"><i class="fa-solid fa-chart-line"></i></a></td> 
   </tr>
  <?php endforeach;  }?>
    
  </tbody>
  </table>
  </div>
 