<?php
	header('Content-type: text/html; charset="iso-8859-1"',true);
	ini_set('upload_max_filesize', '10M');
	ini_set('post_max_size', '10M');
	set_time_limit(0);
	session_cache_expire(3600);
	session_start();

	/*
	* Controle de Path
	*/
	if($_SERVER['HTTP_HOST'] == '192.168.0.66'){
		define('DIR', 'http://192.168.0.66/Motiva-Moveis/2013/site');
	} else {
		define('DIR', 'http://'.$_SERVER['HTTP_HOST']);
	}
	
	require('../classes/s72_conexao.class.php');
	require('../classes/s72_usuario.class.php');
	
	$conexao = new Conexao; 
	$usuario = new Usuario;
	
	$conexao->conectarMysql();
?>