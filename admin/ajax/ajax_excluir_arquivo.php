<?php
	require('ajax_config.php');
	require('../classes/s72_arquivo.class.php');
	
	$s72_Arquivo = new S72_Arquivo();
	
	$s72_Arquivo->setId($_POST['id_arquivo']);
	$s72_Arquivo->deletarArquivo();
?>