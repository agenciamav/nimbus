<?php
	/*
	* Controle de Path
	*/
	if($_SERVER['HTTP_HOST'] == '192.168.0.66'){
		define('DIR', 'http://192.168.0.66/Nimbus/2015/site');
	} else {
		define('DIR', 'http://'.$_SERVER['HTTP_HOST']);
	}

	include('../admin/inc/funcoes.php'); 
	include('../admin/classes/s72_conexao.class.php');
	$conexao = new Conexao(); 
	$conexao->conectarMysql();
		
	session_start();
	ini_set('upload_max_filesize', '10M');
	ini_set('post_max_size', '10M');
	set_time_limit(0);
	session_cache_expire(3600);
	session_start();

	/* Medida preventiva para evitar que outros dominios sejam remetente da sua mensagem. */
	if (eregi('tempsite.ws$|locaweb.com.br$|hospedagemdesites.ws$|websiteseguro.com$', $_SERVER[HTTP_HOST])) {
		//$emailsender='no-reply@s72.com.br'; // Substitua essa linha pelo seu e-mail@seudominio
		$emailsender = "noreply@" . $_SERVER[HTTP_HOST]; // Substitua essa linha pelo seu e-mail@seudominio
	} else {
		$emailsender = "noreply@" . $_SERVER[HTTP_HOST];
		// Na linha acima estamos forcando que o remetente seja 'webmaster@seudominio',
		// Voce pode alterar para que o remetente seja, por exemplo, 'contato@seudominio'.
	}
	if(PATH_SEPARATOR == ";") $quebra_linha = "\r\n"; //Se for Windows
	else $quebra_linha = "\n"; //Se "nao for Windows"

	$_POST = validaParametro($_POST);
	$_GET = validaParametro($_GET);
	extract($_REQUEST);
	extract($_POST);

	// Verifica qual formulário para iniciar ação 
	switch($acao):
/*******************************************************  FALE-CONOSCO  ****************************************/	
		case 'contato':
			if (!strstr($mensagem, 'http')) {
				include('action-contato.php');
			}
			break;
	endswitch;
?>