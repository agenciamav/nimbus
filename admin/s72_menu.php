<?php
	require('classes/s72_menu.class.php');

	$menu = new Menu();
?>
<script type="text/javascript">
	$(document).ready(function() {
							   
		// validate
		$("#formAcao").validate();
		
		// table sorter
		$("#tableSorter").tablesorter({
			headers: {
				2: {sorter: false}
			},
			widgets: ['zebra']
		});
		<?php
			// MONTAR A PAGINACAO - JQUERY
			$paginar = false;
			$registros = $menu->numRows($busca); // apenas modificar o nome do Objeto PHP.
			if ($registros > $registros_por_pagina){
				echo '$("#tableSorter").tablesorterPager({container: $("#pager")});';
				$paginar = true;
			}
		?>
	});
</script>
<h1><span class="texto1">&raquo;</span>&nbsp;&nbsp;<?php echo $usuario->getModuloDescricao(); ?></h1>
<?php	
	# ACAO @LISTAR: Quando a ação está vazia;
	if (empty($_GET['acao'])) {
?>
<form method="get" action="<?php echo $arquivo_acao; ?>" name="formExc" id="formExc">
	<input type="hidden" name="acao" id="acao" value="excluir" />
	<input type="hidden" name="modulo" id="modulo" value="<?php echo $modulo; ?>" />
	
	<table border="0" cellspacing="1" id="tableSorter" class="tablesorter"> 
		<thead> 
			<tr>
				<th align="left" width="40">ID</th>  
				<th align="left">MENU</th> 
				<th width="41">
					<img style="float:left; cursor:pointer;" src="img/ico-adicionar.png" onclick="location.href='<?php echo $arquivo; ?>&acao=formulario'" />
					<input style="float:right; cursor:pointer;" type="image" name="image" src="img/ico-excluir.png"  onclick="return confirm('Tem certeza que deseja excluir os registros selecionados? Todos os itens relacionados também ser&atilde;o exclu&iacute;dos.');" />
				</th>
			</tr> 
		</thead> 
		<tbody> 
			<?php	
				if($sqlResult = $menu->listar($busca, 'ORDER BY nome')){
					$marcar_todos = '<div id="checar"><a href="#" onClick="checkAll(1);">Marcar todos</a></div>';
					while ($row = mysql_fetch_array($sqlResult)) {
						$href_edit = $arquivo.'&acao=formulario&id='.$row['id'];
						echo '
							<tr>
								<td align="center">'.$row['id'].'</td>
								<td align="left"><a href="'.$href_edit.'" title="Editar '.str_replace('_', ' ', ucwords($modulo)).' - '.$row['nome'].' ">'.$row['nome'].'</a></td>
								<td class="tableExcluir">
									&nbsp;<a href="'.$href_edit.'" title="Editar '.ucfirst($modulo).' - '.$row['nome'].' " ><img src="img/ico-editar.png"></a>&nbsp;
									<input name="excluir[]" type="checkbox" value="'.$row['id'].'" class="chk" />
								</td>
							</tr>
						';
					}
				} else {
					echo '<tr><td colspan="3">&#8250; Nenhum registro encontrado!</td></tr>';
				}	
			?>
		</tbody>
	</table>
</form>
<?php echo $marcar_todos; ?>
<!-- PAGINACAO -->
<?php if ($paginar){ ?>
	<div id="pager" class="tablesorterPager">
		<form>
			<img src="js/jquery-tablesorter/addons/pager/icons/first.png" class="first" title="Primeira P&aacute;gina" /> <img src="js/jquery-tablesorter/addons/pager/icons/prev.png" class="prev" title="Retroceder" />
			<input type="text" class="pagedisplay texto1" readonly="readonly"/>
			<img src="js/jquery-tablesorter/addons/pager/icons/next.png"  class="next" 	title="Avan&ccedil;ar" /> <img src="js/jquery-tablesorter/addons/pager/icons/last.png" class="last" title="&Uacute;ltima P&aacute;gina" />
			<?php 
				echo '
					<select class="pagesize">
						<option selected="selected"  value="'.$registros_por_pagina.'">'.$registros_por_pagina.'</option>
						<option value="'.($registros_por_pagina + 10).'">'.($registros_por_pagina + 10).'</option>
						<option value="'.($registros_por_pagina + 20).'">'.($registros_por_pagina + 20).'</option>
						<option value="'.($registros_por_pagina + 30).'">'.($registros_por_pagina + 30).'</option>
					</select>
				';
			?>
		</form>
	</div>
<?php }
	echo '<br /><br /><span class="texto1">&#8250;</span> Total de registro(s): <span class="texto1">'.$registros.'</span>';
	
	# ACAO @INSERIR OU EDITAR: Quando a ação está preenchida; [é usado o mesmo formulário para as duas ações]
	} else {
		
		# ACAO @INSERIR: Quando o item não possui um ID criado.
		if (empty($_GET['id'])) {
			$acao = 'inserir';
			$img_bt = 'bt-confirmar.gif';
		
		# ACAO @EDITAR: Quando o item já possui um ID criado.
		} else {
			$id = $_GET['id'];
			$acao = 'editar';
			$img_bt = 'bt-editar.gif';
			
			$sqlResult = $menu->listarPorId($id);																
			$row = mysql_fetch_array($sqlResult);
		} 
		
?>
		<!--  [1 modulo]  - colocar os 2 [fieldset] em um [form] se assim for preciso. -->
		<!--  [2 modulos] - colocar colocar cada [fieldset] em seu [form] separado. -->
		<form method="post" action="<?php echo $arquivo_acao; ?>" name="formAcao" id="formAcao" class="form" >
			<input type="hidden" name="acao" id="acao" value="<?php echo $acao; ?>" />
			<input type="hidden" name="modulo" id="modulo" value="<?php echo $modulo; ?>" />
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
			
			<fieldset>
				<label>Nome:</label>
				<label><input name="nome" type="text" class="inputText required" id="nome" maxlength="100" value="<?php echo $row['nome'];?>"/></label><br />
				<br />
				<br />		
				<br />
				<label style="display:inline;"><img style="cursor:pointer;" onclick="location.href='<?php echo $arquivo?>';" src="img/template/<?php echo $usuario->getTemplate();?>/bt-voltar.gif" /></label>&nbsp;
				<label style="display:inline;"><input type="image" name="image2"  src="img/template/<?php echo $usuario->getTemplate().'/'.$img_bt;?>" /></label>
			</fieldset>
		</form>
<?php	}	?>