<?php
	session_start();
	include('funcoes.php'); 
	define('CLASSES', 'admin/classes/', true);	
	include(CLASSES.'s72_conexao.class.php');
		
	$conexao = new Conexao; 
	$conexao->conectarMysql();

	/*
	** Seguranca
	*/
	$_POST = validaParametro($_POST);
	$_GET = validaParametro($_GET);
	extract($_REQUEST);
	
	/*
	* Controle de Path
	*/
	if($_SERVER['HTTP_HOST'] == '192.168.0.66'){
		define('DIR', 'http://192.168.0.66/Nimbus/2015/site');
	} else {
		define('DIR', 'http://'.$_SERVER['HTTP_HOST']);
	}
	
	/*
	* Controle de URL
	*/
	$url = explode("/", @$_GET['url']);
	
	$paginas_permitidas[0] = array('home');
	$paginas_permitidas[1] = array('');
	$paginas_permitidas_excecoes[0] = array('');
	
	switch(count($url)):
		case 1:

			$controle_pagina = $url[0];
			
			if(empty($url[0])){
				$controle_pagina = 'home';
			} elseif(!in_array($url[0], $paginas_permitidas[0])){
				 $controle_pagina = 'home';
			} 										  

			break;
			
		case 2:
			$controle_pagina = $url[0];
			if(in_array($url[0],$paginas_permitidas_excecoes[0])){
			
				if( (!in_array($url[0], $paginas_permitidas[1])) || (!in_array($url[1], $paginas_permitidas[1]) ) ){
					$controle_pagina = 'home';
				}
			} 
			break;
			
		case 3:
			$controle_pagina = $url[0];
			if(in_array($url[0],$paginas_permitidas_excecoes[0])){
			
				if( (!in_array($url[0], $paginas_permitidas[1])) || (!in_array($url[1], $paginas_permitidas[1]) ) ){
					$controle_pagina = 'home';
				}
			} 
			break;
			
		case 4:
			$controle_pagina = $url[0];
			if(empty($url[0])){
				$controle_pagina = 'home';
			} elseif( (!in_array($url[0], $paginas_permitidas[0])) || (!in_array($url[0], $paginas_permitidas_excecoes[0])) ){
				 $controle_pagina = 'home';
			} 											  
			
			break;
		
		default: 
			$controle_pagina = 'home';
	endswitch;
	
	define('CONTROLE_PAGINA', $controle_pagina);	
?>
