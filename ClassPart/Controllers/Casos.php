<?php

namespace ClassPart\Controllers;

use \ClassGrl\DataTables;
use \AllowDynamicProperties;
use DateTimeImmutable;

#[AllowDynamicProperties]
class Casos
{
    private $tablaCasos;
    private $authentication;

    public function __construct(
        \ClassGrl\DataTables $tablaCasos,
        \ClassGrl\DataTables $tablaLoc,
           \ClassGrl\Authentication $authentication
    ) {
        $this->tablaCasos = $tablaCasos; 
        $this->tablaLoc = $tablaLoc;
        $this->authentication = $authentication;
    }

    public function busca()
    {



        $result = $this->tablaCasos->findAll();
        $dataCaso = [];
        foreach ($result as $Caso) {         
                $dataCaso[] = array(
                    'label' => $Caso['ApeNom'],
                    'value' => $Caso['IdCaso']
                );
        }



        $title = 'Busca Caso';

        return [
            'template' => 'busca_caso.html.php',
            'title' => $title,
            'variables' => [
                'data' => $dataCaso

            ]
        ];
    }

    public function Casos($id = null)
    {
    
        $localidades = $this->tablaLoc->findAll();
        foreach ($localidades as $localidad) {
            $data[] = array(
                'label'     => $localidad['localidad'],
                'value'     => $localidad['gid']
            );
        }

        $fechaInf = $this->calcularFechaMenos(365 * 6 + 6);
  
        if ($_GET['id'] > 0) {

            $datosCaso = $this->tablaCasos->findById($_GET['id']);
            $datosCaso['Localidad'] = $this->tablaLoc->findById($datosCaso['Gid'])['localidad'] ?? '';
     
            $title = 'Ver Caso';

            return [
                'template' => 'caso.html.php',
                'title' => $title,
                'variables' => [
                    'data' =>   $data,
                    'datosCaso' => $datosCaso ?? ' '
                ]
            ];
        } elseif ($_GET['id'] < 1) {
            $title = 'Cargar Caso';

            return [
                'template' => 'caso.html.php',
                'title' => $title,
                'variables' => [
                    'fechaInf' => $fechaInf ?? '',
                    'data' =>   $data
                ]
            ];
        }
    }

    public function CasosSubmit()
    {
        $usuario = $this->authentication->getUser();
        $Caso = [];
       
        
        $Caso['IdCaso'] = $_POST['Caso']['IdCaso'] ?? '';

        $Caso['Apellido'] = strtoupper(ltrim($_POST['Caso']['Apellido']));
        $Caso['Nombre'] = strtoupper(ltrim($_POST['Caso']['Nombre']));
        $Caso['ApeNom']=strtoupper(ltrim($_POST['Caso']['Apellido']).' '.ltrim($_POST['Caso']['Nombre']));
        $Caso['Dni'] = $_POST['Caso']['Dni'];
        
        $Caso['FecNac'] = $_POST['Caso']['FecNac'];
        $Caso['Sexo'] = $_POST['Caso']['Sexo'];
        $Caso['Gid'] = $_POST['Caso']['Gid'];
        
        $Caso['UsuId'] = $usuario['id_usuario'];
        $Caso['FechaCapta'] = new \DateTime();

      

        $errors = [];

        if (empty($_GET['id']) && count($this->tablaCasos->find('Dni', $Caso['Dni'])) > 0
            && $Caso['Dni'] > 0)
         {

            $errors[] = 'Un Caso con este DNI ya está registrado';
        }

        if (empty($errors)) {
          
        
            $this->tablaCasos->save($Caso);
           
            if (empty($_GET['id'])) {
                $datosCaso = $this->tablaCasos->ultimoReg();
            } else {
                $datosCaso = $this->tablaCasos->findById($_GET['id']);
            }
            $datosCaso['Edad'] = $this->calcularEdad($datosCaso['FecNac'], date('Y-m-d'));
        
            $datosCaso['Localidad'] = $_POST['Caso']['ResiLocal'] ?? '';
      

            $datosCaso['Gid'] = $_POST['Caso']['Gid'] ?? '';
             

            return [
                'template' => 'casoSuccess.html.php',
                'title' => 'Carga',
                'variables' => [
                    'datosCaso' => $datosCaso ?? ' '
                ]
            ];
        } else {
            $localidades = $this->tablaLoc->findAll();
            foreach ($localidades as $localidad) {
                $data[] = array(
                    'label'     => $localidad['localidad'],
                    'value'     => $localidad['gid']
                );
            }
     
            
            return [
                'template' => 'caso.html.php',
                'title' => 'Revisar',
                'variables' => [
                    'errors' => $errors,
                    'datosCaso' => $datosCaso ?? ''
                  ]
            ];
        }
    }

    private function separar_nombres($cadena)
    {
        $apenom_array = explode(" ", $cadena);
        $nombres = array_slice($apenom_array, 1);
        $nombre = implode(" ", $nombres);
        return [
            "apellido" => $apenom_array[0],
            "nombres" => $nombre,
        ];
    }

    private function calcularEdad($fechaNacimiento, $fechaActual)
    {
        $nacimiento = new \DateTime($fechaNacimiento);
        $actual = new \DateTime($fechaActual);
        $edad = $nacimiento->diff($actual);
        $anios = $edad->y;
        $meses = $edad->m;
        $dias = $edad->d;
        if ($anios > 0) {
            return " $anios a $meses m    ";
        } else {
            return "  $meses m $dias d   ";
        }
    }
    public function home()
    {
        $title = 'AntroF78';

        return ['template' => 'home.html.php', 'title' => $title, 'variables' => []];
    }

    public function calcularFechaMenos($dias)
    {
        // Obtener la fecha actual 
        $hoy = new \DateTime();

        // Restar el número de días
        $hoy->sub(new \DateInterval("P{$dias}D"));

        // Obtener la fecha resultante 
        $fechaAnterior = $hoy->format('Y-m-d');

        return $fechaAnterior;
    }
}
