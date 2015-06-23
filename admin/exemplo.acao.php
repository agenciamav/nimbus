<?php
	include('inc/config.php');
	require('classes/exemplo.class.php');
	
	/*
	** Variáveis do FORM e SESSION. 
	*/
	$_SESSION['MENSAGEM'] = '';
	$_SESSION['ICONE'] = '';
	extract($_REQUEST);
	$arquivo = "admin.php?modulo=".$modulo;
	$exemplo = new Exemplo($id,trim($nome),strConverte(trim($nome)),$status);
	
	/*
	** Aplicaçao dos Métodos de acordo com a "acao" do FORM.
	*/
	if (!empty($acao) && $acao != 'formulario'):
		switch($acao):
			case 'editar':
				if ($exemplo->editar()):
					$msg = 'Registro alterado com sucesso!';
				else:
					$erroMsg = 'Erro ao alterar o registro!';
				endif; 
				//$arquivo .= "&acao=formulario&id=".$id;
				break;
			
			case 'inserir':
				if ($exemplo->inserir()):
					$arquivo .= "&acao=formulario";
					$id = mysql_insert_id();
					$arquivo .= "&id=".$id;
					$msg = 'Registro inserido com sucesso!';	
				else:
					$erroMsg = 'Erro ao inserir o registro!';
				endif;
				break;

			case 'excluir':
				$idItens = $_GET['excluir'];
				foreach($idItens as $idItem){
					if ($exemplo->deletar($idItem)):
						$msg .= "Registro ".$idItem." deletado com sucesso!";
					else:
						$erroMsg .= "Erro ao deletar Registro ".$idItem. "!";
					endif;	
				}
				break;

			case 'excluirImg':
				require('classes/s72_imagem.class.php');
				$s72_Imagem = new S72_Imagem();
				if ($s72_Imagem->deletar($idImg)):
					$caminho = '../img/exemplo/';
					if (file_exists($caminho.'o/'.$arquivo_nome)):
						unlink($caminho.'o/'.$arquivo_nome);
					endif;
					if (file_exists($caminho.'g/'.$arquivo_nome)):
						unlink($caminho.'g/'.$arquivo_nome);
					endif;
					if (file_exists($caminho.'m/'.$arquivo_nome)):
						unlink($caminho.'m/'.$arquivo_nome);
					endif;
					if (file_exists($caminho.'p/'.$arquivo_nome)):
						unlink($caminho.'p/'.$arquivo_nome);
					endif;
					$msg .= "Imagem deletado com sucesso";
					$arquivo = "admin.php?modulo=exemplo&acao=formulario&id=".$id_pai;
				else:
					$erroMsg .= "Erro ao deletar Registro ".$idImg;
				endif;
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