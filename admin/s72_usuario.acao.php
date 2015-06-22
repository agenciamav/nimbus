<?php
	include('inc/config.php');
	
	/*
	** Variáveis do FORM e SESSION. 
	*/
	$_SESSION['MENSAGEM'] = '';
	$_SESSION['ICONE'] = '';
	extract($_REQUEST);
	$arquivo = "admin.php?modulo=".$modulo;
	if($permissoes){$permissoes = implode(",", $permissoes);}
	
	/*
	** Aplicaçao dos Métodos de acordo com a "acao" do FORM.
	*/
	$usuario = new Usuario($id, $nome, $login, $senha, $permissoes, $template, $email);

	if (!empty($acao) && $acao != 'formulario'):
		switch($acao):
			case 'editar':
				$arquivo .= "&acao=formulario&id=".$id;
				if ($usuario->editar()):
					$usuario->inserirUsuarioAcao($acaoUser, $id);
					if (!empty($senha)):
						$usuario->trocarSenha();
					endif;
					$msg = 'Registro alterado com sucesso!';
				else:
					$erroMsg = 'Erro ao alterar o registro!';
				endif; 
				break;
			
			case 'inserir':
				if ($usuario->inserir()):
					$arquivo .= "&acao=formulario";
					$id = mysql_insert_id();
					$arquivo .= "&id=".$id;
					$usuario->inserirUsuarioAcao($acaoUser, $id);
					$msg = 'Registro inserido com sucesso!';	
				else:
					$erroMsg = 'Erro ao inserir o registro!';
				endif;
				break;

			case 'excluir':
				$idItens = $_GET['excluir'];
				foreach($idItens as $idItem){
					if ($usuario->deletar($idItem)):
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