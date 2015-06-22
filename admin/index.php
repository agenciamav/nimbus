<?php include('inc/config.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $_SESSION['TITULO']; ?></title>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" type="text/css" href="js/jquery-fg-menu/fg.menu.css">
<link rel="stylesheet" type="text/css" href="css/template/<?php echo $usuario->getTemplate();?>.css">
<!-- favicon -->
<link rel="shortcut icon" href="../images/favicon.gif" type="image/x-icon">
<!-- JS -->
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
<!-- JQUERY -->
<?php include('inc/jquery.php'); ?>
</head>
<body>
<?php	if (!empty($_SESSION['MENSAGEM'])) { include('inc/mensagens.php'); }?>
<div id="container">
	<div class="sombra"><script type="text/javascript">CompilaFlash("swf/sombra_left.swf",10,264);</script></div>
		<form id="form-1" class="form" method="post" action="s72_login.php" >
			<div id="logo" style="margin:0 0 10px 55px;"><img src="img/logo.jpg" alt="<?php echo $_SESSION['NOME']; ?>" title="<?php echo $_SESSION['NOME']; ?>"></div>
			<!-- Máximo IMG: width:150px, height:80px-->
			<fieldset>
				<h1>&#8250; <span>Efetuar Login</span></h1>
				<label> Usu&aacute;rio:<br />
					<input type="text" class="input" name="login" id="" />
				</label>
				<script language="javascript">
					document.getElementById('form-1').login.focus();
				</script>	
				<label>Senha:<br />
					<input type="password" class="input" name="senha" id=""  />
				</label>
				<label>
					<input type="submit" class="botao1" name"enviar" id="" value="Enviar" style="float:right;" />
				</label>
			</fieldset>
		</form>
	<div class="sombra"><script type="text/javascript">CompilaFlash("swf/sombra_right.swf",10,264);</script></div>
</div>
<div id="rodape">&copy; <?php echo date('Y');?> &#8250; <?php echo $_SESSION['TITULO']; ?>. Todos os direitos reservados.</div>
</body>
</html>