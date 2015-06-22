<?php
	require('ajax_config.php');
	require('../classes/s72_imagem.class.php');
	require('../classes/s72_arquivo.class.php');
	
	if (isset($_POST['arquivo'])){
		$objetoArquivo = new S72_Arquivo();
		$objetoArquivo->setLegenda(utf8_decode($_POST['legenda']));
		$objetoArquivo->setId($_POST['id_imagem']);
		$objetoArquivo->editarLegenda();
	} else {
		$objetoImagem = new S72_imagem();
		$objetoImagem->setLegenda(utf8_decode($_POST['legenda']));
		$objetoImagem->setId($_POST['id_imagem']);
		$objetoImagem->editarLegenda();
	}
?>