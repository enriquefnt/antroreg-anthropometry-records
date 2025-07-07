<?php

namespace ClassPart;

use \AllowDynamicProperties;

#[AllowDynamicProperties]
class AntroRegWebsite implements \ClassGrl\Website
{

	private \ClassGrl\DataTables $tablacasos;
	private \ClassGrl\DataTables $tablaUser;
	private \ClassGrl\DataTables $tablaLoc;
	private \ClassGrl\DataTables $tablaControl;
	private \ClassGrl\DataTables $tablauserantro;
	private \ClassGrl\DataTables $tablaZscore;
	private \PDO $pdoZSCORE;
	


	public function __construct()
	{

		$dsn = 'mysql:host=109.106.251.56;dbname=saltaped_antroreg;charset=utf8';
			 $pdo = new \PDO($dsn, 'saltaped_antro', 'antro7625',[ 
				\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
				\PDO::ATTR_EMULATE_PREPARES => false, // Asegura el uso de consultas preparadas nativas
			]);
			
		$this->tablacasos = new \ClassGrl\DataTables($pdo, 'datos_casos', 'IdCaso');
		$this->tablaUser = new \ClassGrl\DataTables($pdo, 'datos_usuarios', 'id_usuario');
		$this->tablaLoc = new \ClassGrl\DataTables($pdo, 'localidades', 'gid');
		$this->tablaControl = new \ClassGrl\DataTables($pdo, 'datos_controles', 'IdControl');
		$this->tablaZscore = new \ClassGrl\DataTables($pdo,'scoresZ;', 'edadDias');
		$this->authentication = new \ClassGrl\Authentication($this->tablaUser, 'user', 'password');
	
			$this->pdoZSCORE = new \PDO($dsn, 'saltaped_antro', 'antro7625',[
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
			\PDO::ATTR_EMULATE_PREPARES => false, 
		]);
			}
	public function getLayoutVariables(): array
	{

		return [

			'loggedIn' => $this->authentication->isLoggedIn()

		];
	}


	public function getDefaultRoute(): string
	{

		return 'casos/home';
	}

	public function getController(string $controllerName): ?object
	{


		if ($controllerName === 'user') {

			$controller = new \ClassPart\Controllers\Usuarios(
				$this->tablaUser, 
				$this->tablaInsti, 
				$this->tablauserantro
			);
		} else if ($controllerName === 'casos') {

			$controller = new  \ClassPart\Controllers\Casos(
				$this->tablacasos,
				$this->tablaLoc,
				$this->authentication
			);
		} else if ($controllerName === 'control') {

			$controller = new  \ClassPart\Controllers\Control(
				$this->tablacasos,
				$this->tablaControl,
				$this->tablaLoc,
				$this->pdoZSCORE,
				$this->authentication
			);
		
		} else if ($controllerName === 'lista') {

			$controller = new  \ClassPart\Controllers\Lista(
				$this->tablacasos,
				$this->tablaZscore,
				$this->pdoZSCORE,
				$this->authentication
			);
		
		} else if ($controllerName == 'login') {

			$controller = new \ClassPart\Controllers\Login($this->authentication);
		} else {

			$controller = null;
		}


		return $controller;
	}

	public function checkLogin(string $uri): ?string
	{

		$restrictedPages = [
			'casos/casos',
			'user/user',
			'casos/busca',
			'lista/nominal',
			'lista/grafico'
		];

		foreach ($restrictedPages as $page) {

			if (in_array($uri, $restrictedPages) && !$this->authentication->isLoggedIn()) {

				header('location: /login/login');

				exit();
			}
		}

		return $uri;
	}
}