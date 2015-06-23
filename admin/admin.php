<?php include('inc/config.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $_SESSION['TITULO']; ?></title>
<!-- JS ANTIGOS -->
<script type="text/javascript" src="js/mascaras.js"></script>
<script type="text/javascript" src="js/javascript.js"></script>
<script type="text/javascript" src="js/geral.js"></script>
<!-- JQUERY -->
<?php include('inc/jquery.php'); ?>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="css/admin.css">
<link rel="stylesheet" type="text/css" href="css/template/<?php echo $usuario->getTemplate();?>.css">
<!-- favicon -->
<link rel="shortcut icon" href="../images/favicon.gif" type="image/x-icon">

</head>
<body>
<?php	if(!empty($_SESSION['MENSAGEM'])) { include('inc/mensagens.php'); }?>
<div id="tudo">
	<div id="container_master">
		<div class="sombra"><script type="text/javascript">CompilaFlash("swf/sombra_left.swf",10,264);</script></div>
		<div id="container">
			<div id="topo">
				<div id="logo"><a href="admin.php"><img src="img/logo.jpg" width="149" alt="<?php echo $_SESSION['NOME-TITULO']; ?>" title="<?php echo $_SESSION['NOME-TITULO']; ?>" /></a></div><!-- Máximo IMG: width:149px, height:80px-->
				<div id='busca'>
					<?php	
						if (!empty($_GET['modulo']) && empty($_GET['acao']) && $_GET['modulo'] != 'galeria_imagem' && $_GET['modulo'] != 'galeria_video') { 	
							include('inc/busca.php');
						}
					?>
				</div>
			</div>
			<div id="menu"><?php include('inc/menu.php'); ?></div>
			<div id="modulo">
				<?php 
					// checa se existe o arquivo para incluir.
					if (!file_exists($modulo.'.php')) {
						$_SESSION['STUDIO72_ERRO'] = 'STUDIO72 - O arquivo '.$modulo.'.php não existe. <br />Tente novamente ou contate o administrador do sistema - (54) 3055-2264.';
						include('inc/saudacao.php'); 
					} else {
						include($modulo.'.php'); 
					}
				?>
			</div>
		</div>
		<div class="sombra"><script type="text/javascript">CompilaFlash("swf/sombra_right.swf",10,264);</script></div>
	</div>
	<div style="clear:both;"></div><!-- nao retirar -->
	<div id="rodape">&copy; <?php echo date('Y');?> &#8250; <?php echo $_SESSION['TITULO']; ?>. Todos os direitos reservados.</div>
</div>
</body>
</html>