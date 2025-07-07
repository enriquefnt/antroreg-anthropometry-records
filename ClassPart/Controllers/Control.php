<?php
namespace ClassPart\Controllers;

use \ClassGrl\DataTables;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class Control
{
    private $tablaCasos;
   	private $tablaControl;
	private $tablaLocal;
	private $pdoZSCORE;   
    private $authentication;

    public function __construct(\ClassGrl\DataTables $tablaCasos,
                         
                                \ClassGrl\DataTables $tablaControl,
								\ClassGrl\DataTables $tablaLocal,
								$pdoZSCORE,									
							
                                \ClassGrl\Authentication $authentication)
    {
        $this->tablaCasos = $tablaCasos;
		$this->tablaControl = $tablaControl;
		$this->tablaLocal = $tablaLocal;
        $this->pdoZSCORE = $pdoZSCORE;
        $this->authentication = $authentication;
    }


public function control($id=null){

	$usuario = $this->authentication->getUser();
	$datosCaso=$this->tablaCasos->findById($_GET['idCaso']);
	if(!empty($datosCaso)){
	
	$datosCtrl=$this->tablaControl->findLast('IdCaso',$datosCaso['IdCaso']) ?? '';}
	$edad=$this->calcularEdad($datosCaso['FecNac'],date('Y-m-d')) ?? ' ';
	$datosCaso['edad']=$edad ?? ' ';


			$title = 'Control';	

			if (isset($_GET['idCaso'])) {
	
			  return ['template' => 'control.html.php',
					     'title' => $title ,
					 'variables' => [
			     		  'datosCaso'=> $datosCaso ?? ' '
							
									 ]

					]; } 
	}

public function controlSubmit() {
	
	$datosCaso=$this->tablaCasos->findById($_GET['idCaso']);
	$edad=$this->calcularEdad($datosCaso['FecNac'],date('Y-m-d'));
	$datosCaso['edad']=$edad;
	$usuario = $this->authentication->getUser();
	$Control=$_POST['Control'];
	// var_dump($datosCaso);
		
	$Control['FechaCarg'] = new \DateTime();
	$Control['Usuario']=$usuario['id_usuario'];
	$datosControl=$Control;
	// var_dump($datosControl);
	$this->tablaControl->save($Control);

	$imc=$Control['Peso']/(($Control['Talla']/100)*($Control['Talla']/100));
	$sexo = ($datosCaso['Sexo'] ==='Femenino') ? '2' : '1';
	$nacimiento = new \DateTime($datosCaso['FecNac']);
	$actual = new \DateTime($datosControl['FechaControl']);
	$edadDias= $nacimiento->diff($actual);
	$datosControl['edadDias'] = $edadDias->days;
//////////////////////////////////////////
$controlesPrev = $this->pdoZSCORE->prepare("call saltaped_antroreg.controlesXcasos(:idCaso);");
$controlesPrev->execute([':idCaso' => $datosCaso['IdCaso']]);
$datosControlPrev = $controlesPrev->fetchAll(\PDO::FETCH_ASSOC);
$controlesPrev->closeCursor();

$ultimoControl = null;
$fechaUltimoControl = '';
foreach ($datosControlPrev as $control) {
    if ($control['Fecha'] > $fechaUltimoControl) {
        $fechaUltimoControl = $control['Fecha'];
        $ultimoControl = $control;
    }
}
$nuevoArray = $ultimoControl;

//var_dump($ultimoControl);var_dump($datosControl);
//die;
	

	////////////////////calculos//////////////////////////////////

	$datosControl['CtrolZpe']= $this->calcularZScore(
		$sexo  , 
		"p", 
		$datosControl['Peso'], 
		$datosCaso['FecNac'], 
		$datosControl['FechaControl']
		) ;
	$datosControl['CtrolZta']= $this->calcularZScore(
			$sexo  , 
		"t", 
		$datosControl['Talla'], 
		$datosCaso['FecNac'], 
		$datosControl['FechaControl']
		) ;
	$datosControl['CtrolZimc'] = $this->calcularZScore(
		$sexo , 
		"i", 
		$imc, 
		$datosCaso['FecNac'], 
		$datosControl['FechaControl']
		) ;   
		$datosControl['CtrolPt'] = $this->calcularZScorePt(
			$sexo , 
			$datosControl['Peso'],
			$datosControl['Talla'], 
			$datosCaso['FecNac'], 
			$datosControl['FechaControl']
			) ;   
		$datosControl['alertIMC']=$this->getAlertClass($datosControl['CtrolZimc']);
		$datosControl['alertPE']=$this->getAlertClass($datosControl['CtrolZpe']);
		$datosControl['alertTA']=$this->getAlertClass($datosControl['CtrolZta']);
		$datosControl['alertPT']=$this->getAlertClass($datosControl['CtrolPt']);
 
		if (($datosControl['CtrolZpe'] < -3) || ($datosControl['CtrolZimc'] < -3 && $datosControl['edadDias'] > 730)) $datosControl['ClasPeso'] = 'MBP';
		elseif (($datosControl['CtrolZpe'] < -2) || ($datosControl['CtrolZimc'] < -2 && $datosControl['edadDias'] > 730)) $datosControl['ClasPeso'] = 'BP';
		elseif ($datosControl['CtrolZpe'] < -1.5) $datosControl['ClasPeso'] = 'RBP';
		elseif ($datosControl['CtrolZpe'] < 2) $datosControl['ClasPeso'] = 'AD';
		else $datosControl['ClasPeso'] = 'AP';
		if 	($datosControl['CtrolZta'] < -3) $datosControl['ClasTalla'] = 'MBT';
		elseif ($datosControl['CtrolZta'] < -2) $datosControl['ClasTalla'] = 'BT';
		elseif ($datosControl['CtrolZta'] < -1.5) $datosControl['ClasTalla'] = 'RBT';
		elseif ($datosControl['CtrolZta'] < 2) $datosControl['ClasTalla'] = 'AD';
		else $datosControl['ClasTalla'] = 'AT';
//var_dump($datosControl);die;


	return [
		'template' => 'controlsucess.html.php',
		'title' => 'Carga',
		'variables' => [
			'datosCaso' => $datosCaso ?? ' ',
			'datosControl' => $datosControl ?? ' '
			
		]
	];


}
	
public function calcularEdad($fechaNacimiento, $fechaActual) {
	$nacimiento = new \DateTime($fechaNacimiento);
	$actual = new \DateTime($fechaActual);
	$edad = $nacimiento->diff($actual);
		$anios = $edad->y;
		$meses = $edad->m;
		$dias = $edad->d;
 if($anios>0){
	return " $anios a $meses m    ";
}
else {
	return "  $meses m $dias d   ";
}
}

public function calcularZScore($sexo, $bus, $valor, $fecha_nace, $fecha_control) {

    
    $query = "SELECT ZSCORE($sexo, '$bus', $valor, '$fecha_nace', '$fecha_control') AS resultado"; 
    $resultado = $this->pdoZSCORE->query($query);
//	var_dump($resultado);//die;
  if ($resultado) {
      
      $fila = $resultado->fetchColumn();

    
            $resultadoZSCORE = $fila;
    } else {
      echo("No se pudo calcular");
      $resultadoZSCORE = null;
    }
  
   return $resultadoZSCORE;
  }

  public function calcularZScorePt($sexo, $peso, $talla, $fecha_nace, $fecha_control) {
    $query = "SELECT ZSCOREpt($sexo, $peso, $talla, '$fecha_nace', '$fecha_control') AS resultado"; 
    $resultado = $this->pdoZSCORE->query($query);
//	var_dump($resultado);//die;
  if ($resultado) {
      
      $fila = $resultado->fetchColumn();

    
            $resultadoZSCOREpt = $fila;
    } else {
      echo("No se pudo calcular");
      $resultadoZSCORE = null;
    }
  
   return $resultadoZSCOREpt;
  }
  
  public function getColorClass($value) {
    switch (true) {
        case $value > 2:
            return 'red';
        case $value < -2:
            return 'red';
		case ($value >= -1.5 && $value <= 1.5):
			return 'green';		
				case ($value < -1.5 && $value >= -2):
			return 'yellow';	
        default:
            return 'green';
    }
}

public function getAlertClass($value) {
    switch (true) {
        case $value > 2 && $value <= 6 :
            return 'danger';
        case $value < -2 && $value >= - 6 :
            return 'danger';
		case $value >= -1.5 && $value <= 2:
			return 'success';		
				case $value < -1.5 && $value >= -2:
			return 'warning';	
        default:
            return 'dark';
    }
}

public function relacionaCodigos($Codigo,$tablaValores){
$valor=$this->$tablaValores->findById($Codigo)[1];
return $valor;
	}
}