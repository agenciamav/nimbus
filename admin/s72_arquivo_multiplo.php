<?php
	header('Content-type: text/html; charset="iso-8859-1"',true);
	ini_set('upload_max_filesize', '50M');
	ini_set('post_max_size', '50M');
	set_time_limit(0);
	session_cache_expire(3600);
	session_start();
	
	require('classes/s72_conexao.class.php');
	require('classes/s72_usuario.class.php');
	
	$conexao = new Conexao; 
	$usuario = new Usuario;
	
	$conexao->conectarMysql();

	extract($_REQUEST);
	require('inc/funcoes.php'); 
	require('classes/s72_arquivo.class.php');

	$objetoArquivo = new S72_Arquivo();	
	
	$objetoArquivo->setIdModulo($_REQUEST['id_modulo']);											// id do módulo.
	$objetoArquivo->setIdModuloItem($_REQUEST['id_produto']);										// id do item.
	$objetoArquivo->setTamanhoMaximo($_REQUEST['tamanhoMaximo']);									// tamanho máximo permitido em Bytes do arquivo: ex: 2097152 = 2MB
	$objetoArquivo->setExtPermitidas(array('pdf'));													// extensoes permitidas: ex: array('jpg','xlsx') ou 0 para permitir todas.
	$objetoArquivo->setCaminho($_REQUEST['caminhoArq']);											// caminho aonde irá ser salvo o arquivo. [lembre que a raiz é o site]
	$objetoArquivo->setArquivo($_FILES['Filedata']['tmp_name']);									// arquivo temporario.
	$objetoArquivo->setArquivoNome(strAmigavelGravacao($_REQUEST['arquivoNome']));					// nome do arquivo
//	$objetoArquivo->setArquivoNome(strAmigavelGravacao(utf8_decode(current(explode(".",$_FILES['Filedata']['name'])))));	// nome do arquivo
	$objetoArquivo->setTamanho($_FILES['Filedata']['size']);										// tamanho do arquivo.
	$objetoArquivo->setExt(end(explode(".", $_FILES['Filedata']['name'])));							// extensao.
	$objetoArquivo->setData(date('Y-m-d'));															// data.

	if($objetoArquivo->verificarExtensao() && $objetoArquivo->verificarTamanhoMaximo()){
		$objetoArquivo->inserir();
		$objetoArquivo->editarArquivo($objetoArquivo->getId(), $objetoArquivo->getArquivoNome().'_'.$objetoArquivo->getId().'.'. $objetoArquivo->getExt());		
		//include ('inc/envia_email.php');
	} 
	echo $_REQUEST['id_produto'];
?>
