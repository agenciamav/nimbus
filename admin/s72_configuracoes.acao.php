<?php
	include('inc/config.php');
	
	/*
	** Variáveis do FORM e SESSION. 
	*/
	$_SESSION['MENSAGEM'] = '';
	$_SESSION['ICONE'] = '';
	extract($_REQUEST);
	$arquivo = "admin.php?modulo=".$modulo."&id=".$id;
	
	/*
	** Aplicaçao dos Métodos de acordo com a "acao" do FORM.
	*/
	$usuario = new Usuario($id, $nome, $login, $senha, null, $template);
	
	if (!empty($id) && $acao != 'formulario'):
		
		if ($usuario->editarConta()):
			if (!empty($senha)):
				$usuario->trocarSenha();
			endif;
			$msg = 'Registro alterado com sucesso!';
		else:
			$erroMsg = 'Erro ao alterar o registro!';
		endif;
		
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