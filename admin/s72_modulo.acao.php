<?php
	include('inc/config.php');
	require('classes/s72_modulo.class.php');
	
	/*
	** Vari�veis do FORM e SESSION. 
	*/
	$_SESSION['MENSAGEM'] = '';
	$_SESSION['ICONE'] = '';
	extract($_REQUEST);
	$arquivo = "admin.php?modulo=".$modulo;
	if (empty($ativo)){$ativo = 'N';}
	
	/*
	** Aplica�ao dos M�todos de acordo com a "acao" do FORM.
	*/
	$moduloObject = new Modulo($id,$id_menu,$descricao,$modulo_nome,$ativo);

	if (!empty($acao) && $acao != 'formulario'):
		switch($acao):
			case 'editar':
				if ($moduloObject->editar()):
					$msg = 'Registro alterado com sucesso!';
				else:
					$erroMsg = 'Erro ao alterar o registro!';
				endif; 
				break;
			
			case 'inserir':
				if ($moduloObject->inserir()):
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
					if ($moduloObject->deletar($idItem)):
						$msg .= "Registro ".$idItem." deletado com sucesso!";
					else:
						$erroMsg .= "Erro ao deletar Registro ".$idItem. "!";
					endif;	
				}
				break;
		endswitch;
	endif;	

	/*
	** Configura�ao das mensagens ao usu�rio e retorno do arquivo.
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