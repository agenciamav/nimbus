<script type="text/javascript">
	// inicialização dos menus em JS
	$(function(){
		// BUTTONS
		$('.fg-button').hover(
			function(){ $(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
			function(){ $(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
		);
		
		// PREPARA OS MENUS DINAMICOS   
		<?php
			$sqlMenu = 'SELECT * FROM s72_menu MEN INNER JOIN s72_modulo MOU ON MEN.id = MOU.id_menu WHERE MOU.id in (' . $_SESSION['PERMISSOES'] . ') AND MOU.ativo = "S" AND MOU.fixo = "N" GROUP BY MOU.id_menu';
			$resMenu = mysql_query($sqlMenu);
			if($resMenu){
				while ($rowMenu = mysql_fetch_array($resMenu)) {
					echo "$('#menu_".$rowMenu[id_menu]."').menu({ content: $('#menu_".$rowMenu[id_menu]."').next().html(), showSpeed: 400 });";
				}
			}
		?>
	});
</script>

<?php
	//  [MENU DINAMICO]
	$sqlMenu = 'SELECT * FROM s72_menu MEN INNER JOIN s72_modulo MOU ON MEN.id = MOU.id_menu WHERE MOU.id in (' . $_SESSION['PERMISSOES'] . ') AND MOU.ativo = "S" AND MOU.fixo = "N" GROUP BY MOU.id_menu ORDER BY MEN.nome' ;
	if($resMenu = mysql_query($sqlMenu)){
		while ($rowMenu = mysql_fetch_array($resMenu)) {
			
			echo '<a tabindex="0" href="#" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-all" id="menu_'.$rowMenu['id_menu'].'"><span class="ui-icon ui-icon-triangle-1-s"></span><span class="texto1">'.$rowMenu['nome'].'</span></a>';
			echo '<div class="hidden"><ul>';
	
			$sqlModulo = 'SELECT * FROM s72_menu MEN INNER JOIN s72_modulo MOU ON MEN.id = MOU.id_menu WHERE MOU.id_menu = '.$rowMenu["id_menu"].' AND MOU.id in (' . $_SESSION['PERMISSOES'] . ')  AND MOU.ativo = "S" AND MOU.fixo = "N" ORDER BY MOU.descricao';
			$resModulo = mysql_query($sqlModulo);
			while ($rowModulo = mysql_fetch_array($resModulo)) {
				echo "<li><a href='admin.php?modulo=".$rowModulo['modulo']."' title='M&oacute;dulo ".$rowModulo['descricao']."'>".$rowModulo['descricao']."</a></li>";
			}
			echo '</ul></div>';
		}
	} else {
		echo utf8_decode("Você não tem permissão em nenhum módulo do sistema. Maiores dúvidas, contate o administrador.");
		print_r($_SESSION['PERMISSOES']);
	}
?>
	<br class="clear" />
	<br />
	<br />
<?php
	//  [MENU FIXO] - nos menus fixos é sempre enviado por GET a ID da sessão. Esses módulos são padrão do sistema e não é preciso verificar as permissões.
	$sqlMenuFixo = 'SELECT * FROM s72_modulo MOU WHERE MOU.ativo = "S" AND MOU.fixo = "S"';
	$resMenuFixo = mysql_query($sqlMenuFixo);
	while ($rowMenuFixo = mysql_fetch_array($resMenuFixo)) {
		echo '<a tabindex="0" href="admin.php?modulo='.$rowMenuFixo[modulo].'&id='.$_SESSION["ID"].'" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-all bg-menu-template" id="menu_minhaconta"><span class="textoMenuFixo">'.$rowMenuFixo[descricao].'</span></a>';
	}
?>