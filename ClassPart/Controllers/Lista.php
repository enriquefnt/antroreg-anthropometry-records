<?php
namespace ClassPart\Controllers;
use \ClassGrl\DataTables;
use \AllowDynamicProperties;

#[AllowDynamicProperties]
class Lista
{
  private $tablaCasos;
  private $tablaZscore;
  private $pdoZSCORE;
 // private $authentication;  	
  public function __construct(
      \ClassGrl\DataTables $tablaCasos,
      $tablaZscore,
      $pdoZSCORE,
    //  \ClassGrl\Authentication $authentication
    ) {
                $this->tablaCasos = $tablaCasos;	
                $this->tablaZscore = $tablaZscore;
                $this->pdoZSCORE = $pdoZSCORE;
   //             $this->authentication = $authentication;
               
        }


    public function nominal(){
     // var_dump($_SESSION);die;
    
        if ($_SESSION['tipo']=='Auditor') {
    $casos = $this->pdoZSCORE->prepare("call saltaped_antroreg.nominal(0);");
   
    $casos->execute([]);
    $datos = $casos->fetchAll(\PDO::FETCH_ASSOC);
  } 
  else {
    $aop=$_SESSION['usuAo'] ?? 0;
    $casos = $this->pdoZSCORE->prepare("call saltaped_antroreg.nominal($aop);");   
    $casos->execute([]);
    $datos = $casos->fetchAll(\PDO::FETCH_ASSOC);
  }

//var_dump($datos);


$title='Nominal';
 
              return ['template' => 'nominal.html.php',
                         'title' => $title ,
                    'variables' => [
                   'casos'  =>   $datos ?? []
                 //  'casosAop'  =>   $datosAop ?? []
    
                                     ]

                    ]; 
}
 public function porCaso($id=null){
 
  $caso= $_GET['caso'] ?? '';
  //var_dump($_GET);
  $controles = $this->pdoZSCORE->prepare("call saltaped_antroreg.controlesXcasos($caso);");
    $controles->execute([]);
    $datosControl =$controles->fetchAll(\PDO::FETCH_ASSOC);
  //var_dump($datosControl);die;


    $datosCaso=$this->tablaCasos->findById($caso);

    $title='Controles';
 
              return ['template' => 'controles.html.php',
                         'title' => $title ,
                    'variables' => [
                   'datosControl'  =>   $datosControl ?? [],
                   'datosCaso'  =>    $datosCaso ?? []
                                    ]
                     ]; 

}


public function grafico($id=null){
  
  $indicador = $_GET['indicador'] ?? '';
  $sex=substr($this->tablaCasos->findById($_GET['caso'])['Sexo'],0,1) ?? '';
  $tabla=$indicador . $sex;
  $nombre=$this->tablaCasos->findById($_GET['caso'])['ApeNom'] ?? '';
  $caso= $_GET['caso'] ?? '';

 ///////////////////////////////////////datos niño////////////////////////////////////////////////
 $controles = $this->pdoZSCORE->prepare("call saltaped_antroreg.datosGrafica($caso);");
 $controles->execute([]);
 $datosControl =$controles->fetchAll(\PDO::FETCH_ASSOC);

 $dataCaso = [
   'edad' => [],
   'valor' =>[],
    ];
    foreach($datosControl as $control) {
     $dataCaso['edad'][] = $control['EdadDias'];
   
     if ($indicador=='PE'){$dataCaso['valor'][]=$control['Peso'];}
     elseif ($indicador=='TE'){$dataCaso['valor'][]=$control['Talla'];}
     else {$dataCaso['valor'][]=$control['Peso']/($control['Talla']/100)/($control['Talla']/100);}
    }
 // var_dump($dataCaso); die;


     ///////////////////////////////////datos para crear grafica /////////////////////////////////////////////////////////////////////////
 
  $data = [
    'nombre'=>$nombre,
    'edad' => [],
    'SD3neg' => [],
    'SD2neg' => [],
    'SD15neg' => [],
    'SD1neg' => [],
    'SD0' => [],
    'SD1' => [],
    'SD15' => [],
    'SD2' => [],
    'SD3' => [],
    'medida' => [],
    'Caso' => [],
    'rotulox'=> []
  ];
   // data['nombre']
 
  $result = $this->tablaZscore->findAll();
  //var_dump($result);die;
  

  $diasArray = array_column( $result, 'edadDias');
  //var_dump($diasArray);die;
  foreach ($result as $dias) {

    $diaValue = $dias['edadDias'];
    //var_dump($diaValue);
    $diaIndex = array_search($diaValue, $diasArray);
    //var_dump($diaIndex);
    if ($diaIndex !== false) {
      $data['edad'][] =  $dias['edadDias'];
      $data['SD3neg'][] = $dias['SD3neg' . $tabla];
      $data['SD2neg'][] = $dias['SD2neg' . $tabla];
      $data['SD15neg'][] = $dias['SD15neg' . $tabla];
      $data['SD1neg'][] = $dias['SD1neg' . $tabla];
      $data['SD0'][] = $dias['SD0' . $tabla];
      $data['SD1'][] = $dias['SD1' . $tabla];
      $data['SD15'][] = $dias['SD15' . $tabla];
      $data['SD2'][] = $dias['SD2' . $tabla];
      $data['SD3'][] = $dias['SD3' . $tabla];
      $data['rotulox'][] = $dias['Rotulo'];

      switch ($data['medida'] = $tabla){
        case $tabla=="PEF"||$tabla=="PEM":
          $data['medida'] ='Peso (kg)';
          break;
          case $tabla=="TEF"||$tabla=="TEM":
          $data['medida'] ='Talla (cm)';
          break;
          case $tabla=="IEF"||$tabla=="IEM":
          $data['medida'] ='Indice de masa corporal (kg/m2)';
          break;
         
        default:
        $data['medida']  ='Otra';
      }


      foreach ($data['edad'] as $index => $edad) {
        // Busca la coincidencia entre la edad en $data1 y $dataCaso
        $posicion = array_search($edad, $dataCaso['edad']);
        if ($posicion !== false) {
            // Agrega el valor correspondiente a $data1['Caso'] si se encuentra una coincidencia
            $data['Caso'][$index] = $dataCaso['valor'][$posicion];
        } else {
        //     // Si no hay coincidencia, asigna un valor predeterminado
          $data['Caso'][$index] = null;
        }
  }
  unset($diasArray[$diaIndex]);
}


}


//var_dump($data); die;



  $title='Grafica';

          return [
            'template' => 'grafica.html.php',
           
              'title' => $title,
              'variables' => [
               'data' => $data ?? []
                                ]
          ];


}


}