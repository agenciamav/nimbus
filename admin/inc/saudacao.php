<?php
	// verifica se aconteceu algum erro
	if(isset($_SESSION['STUDIO72_ERRO'])){
		$msgErro = $_SESSION['STUDIO72_ERRO'];
		unset($_SESSION['STUDIO72_ERRO']);
	} 
?>
<div id="saudacao" style="padding-top:5%; text-align:center;">
	<p>
		<?php
			if (isset($msgErro)){
				echo '<span class="error" style="font-size:20px; font-weight:bold;">Ooops,</span><br /><br /><span class="error" style="font-size:14px;">'.$msgErro.'</span>';
			} else {
				echo '<span class="texto1" style="font-size:20px;">Ol&aacute;, '.$_SESSION['NOME'].'!</span>';
			}
		?>
		</span>
		<br />
		<br />
		Seja bem vindo ao <?php echo $_SESSION['TITULO']; ?>.
		<br />
		<br />
		Voc&ecirc; acessou o sistema <?php echo $_SESSION['QTD_ACESSO']; ?> vezes e seu &uacute;ltimo acesso foi no dia <?php echo dt2br(substr($_SESSION['ULT_ACESSO'], 0, 10)).'&nbsp;&agrave;s&nbsp;'.substr($_SESSION['ULT_ACESSO'], 11, 8); ?>.
		<br />
		<img src="img/relogio.jpg" hspace="5" />
		<br />
		<br />
		<div id="relogio" class="texto1" style="font-size:20px;"></div>
		<br />
		<br />
		<br />
	</p>
</div>
<script language="javascript">relogio();</script>
