<?
	/*
	** Inicializaçao da Sessao.
	*/
	
	session_cache_expire(3600);
	session_start();
	
	require('classes/s72_conexao.class.php');
	require('classes/s72_usuario.class.php');
	
	/*
	** Inicializaçao dos Objetos.
	*/
	
	$conexao = new Conexao; 
	$usuario = new Usuario;
	
	/*
	** Variáveis do FORM.
	*/
	
	extract($_POST);
	
	
	/*
	** Verificaçao da conexao com o Banco de Dados.
	*/
	
	if(!$conexao->conectarMysql()) {
		$erro_msg = "Imposs&iacute;vel conectar ao banco de dados. Por favor, contate o administrador do sistema.";
	} 
	
	/*
	** Verificaçao do usuário
	*/
	
	if(empty($login) || empty($senha) ){
		$erro_msg = 'Usu&aacute;rio ou senha n&atilde;o informados!';
	}
	
	/*
	** Login ou Erro.
	*/
	
	if(empty($erro_msg)){
		$usuario->login($login, $senha);
	} else{
		$_SESSION['MENSAGEM'] = $erro_msg;
		$_SESSION['ICONE'] = 'alert';
		header("location: index.php");
		exit();
	}
?>