<?php
	include('inc/config.php');
	require('classes/s72_menu.class.php');
	
	/*
	** Variáveis do FORM e SESSION. 
	*/
	$_SESSION['MENSAGEM'] = '';
	$_SESSION['ICONE'] = '';
	extract($_REQUEST);
	$arquivo = "admin.php?modulo=".$modulo;
	
	$menu = new Menu($id,$nome);
	
	/*
	** Aplicaçao dos Métodos de acordo com a "acao" do FORM.
	*/
	if (!empty($acao) && $acao != 'formulario'):
		switch($acao):
			case 'editar':
				if ($menu->editar()):
					$msg = 'Registro alterado com sucesso!';
				else:
					$erroMsg = 'Erro ao alterar o registro!';
				endif; 
				break;
			
			case 'inserir':
				if ($menu->inserir()):
					$id_modulo = mysql_insert_id();
					$arquivo .= "&id=".$id_modulo;
					$msg = 'Registro inserido com sucesso!';	
				else:
					$erroMsg = 'Erro ao inserir o registro!';
				endif;
				break;

			case 'excluir':
				$idItens = $_GET['excluir'];
				foreach($idItens as $idItem){
					if ($menu->deletar($idItem)):
						$msg .= "Registro ".$idItem." deletado com sucesso!";
					else:
						$erroMsg .= "Erro ao deletar Registro ".$idItem. "!";
					endif;	
				}
				break;
		endswitch;
	endif;	

	/*
	** Configuraçao das mensagens ao usuário e retorno do arquivo.
	*/
	if (!empty($erroMsg)):
		$_SESSION['MENSAGEM'] = $erroMsg;
		$_SESSION['ICONE'] = 'del';
	else:
		$_SESSION['MENSAGEM'] = $msg;
		$_SESSION['ICONE'] = 'ok';
	endif;

	die(header("Location: $arquivo"));
?>