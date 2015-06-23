<?php
	ini_set('upload_max_filesize', '200M');
	ini_set('post_max_size', '200M');
	set_time_limit(0);
	session_cache_expire(3600);
	session_start();
	
	$_SESSION['TITULO'] = 'NIMBUS &#8250; Gerenciador de Conte&uacute;do';
	$_SESSION['NOME-TITULO'] = 'NIMBUS';
	
	require('classes/s72_conexao.class.php');
	require('classes/s72_usuario.class.php');
	require('classes/s72_paginacao.class.php');
	include('inc/funcoes.php');
	
	$conexao = new Conexao; 
	$usuario = new Usuario;
	
	$conexao->conectarMysql();
	$usuario->verificarTemplate();
	
	$index = end(explode("/", $_SERVER['PHP_SELF']));
	
	if($index != 'index.php'){
		$usuario->verificarLogin();	
		
		if (!empty($_GET['modulo'])) {
			
			// modulos
			$modulo = $_GET['modulo'];
			$arquivo = 'admin.php?modulo='.$modulo;
			$arquivo_modulo = 'modulo='.$modulo;
			$arquivo_acao = $modulo.'.acao.php';
			
			// [requerido] validação do usuário no módulo
			$usuario->mostrarModulo($modulo); 
			
			// busca
			$busca = $_GET['palavra'];
			$busca_pag = $arquivo_modulo.'&';
			
			// paginacao
			$registros_por_pagina = 15;
			
			// logout
			if($modulo == 's72_logout'){
				$usuario->logout();
			}
			
		} else{
			$modulo = "inc/saudacao";
			$arquivo = 'admin.php';
		}
	}	
?>