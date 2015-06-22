<?php
	$erro_mensagem = $_SESSION['MENSAGEM'];
	$erro_icone = $_SESSION['ICONE'];
	unset($_SESSION['MENSAGEM']);
	unset($_SESSION['ICONE']);
?>
<script type="text/javascript">
	$(document).ready(function() {
		function fecharMensagem(){
			setTimeout("lightbox_disable()", 4000);
		}
		fecharMensagem();
	});
</script>
<div id='light' class='white_content'>
	<p id="msg_erro">
		<br />
		<img src="img/ico_msg_<?php echo $erro_icone; ?>.png" />
		<?php echo $erro_mensagem; ?>
		<br />
		<br />
		<input type="submit" class="botao1" name"enviar" value="OK" onclick="lightbox_disable();" />
	</p>
</div>
<div id='fade' class='black_overlay'></div>
<script language='javascript'>lightbox_enable();</script>
