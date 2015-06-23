<script type="text/javascript">
	$(document).ready(function() {
							   
		// validate
		$("#formAcao").validate();
		
		// alterar senha
		$("#senha").val('');
		$("#box_senha1, #box_senha2").hide();		
		$("#alterar_senha").change(function() {
			if(this.checked){
				$("#box_senha1, #box_senha2").show('fast');
			}else{
				$("#box_senha1, #box_senha2").hide('fast');
			}
		});
	});
</script>
<h1><span class="texto1">&raquo;</span>&nbsp;&nbsp;<?php echo $usuario->getModuloDescricao();?></h1>
<?php	
		
	# ACAO @EDITAR: Quando o item já possui um ID criado.
	if (!empty($_GET['id'])) {
		$id = $_GET['id'];
		$acao = 'trocar_senha';
		$img_bt = 'bt-editar.gif';
		
		$sqlResult = $usuario->listarPorId($id);																
		$row = mysql_fetch_array($sqlResult); 
?>
		<!--  [1 modulo]  - colocar os 2 [fieldset] em um [form] se assim for preciso. -->
		<!--  [2 modulos] - colocar colocar cada [fieldset] em seu [form] separado. -->
		<form method="post" action="<?php echo $arquivo_acao; ?>" name="formAcao" id="formAcao" class="form" >
			<input type="hidden" name="acao" id="acao" value="<?php echo $acao; ?>" />
			<input type="hidden" name="modulo" id="modulo" value="<?php echo $modulo; ?>" />
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
			
			<fieldset>
				<label>Nome:</label>
				<label><input name="nome" type="text" class="inputText required" id="nome" maxlength="100" value="<?php echo $row['nome']; ?>"  /></label><br />
				<label>Login:</label>
				<label><input name="login" type="text" class="inputText required" id="login" maxlength="100" value="<?php echo $row['login']; ?>" /></label><br /><br />
				<label><input type="checkbox" id="alterar_senha"  />&nbsp; * Marque essa op&ccedil;&atilde;o se desejar alterar a senha.</label><br />
				<label id="box_senha1">Senha:</label>
				<label id="box_senha2"><input name="senha" type="password" class="inputText" id="senha" maxlength="100" value="" /></label><br />
				<br />
				<br />		
				<br />
				<label style="display:inline;"><input type="image" name="image2"  src="img/template/<?php echo $usuario->getTemplate().'/'.$img_bt; ?>" /></label>
			</fieldset>
		</label>	
		<fieldset id="moduloInterno">
			<h1><span class="texto1">&#8250;</span>&nbsp;&nbsp;Template</h1>
			<br />
			<select id="template" name="template" class="inputSelect">
				<option <?php if($usuario->getTemplate() == 'azul') {echo "selected='selected'";} ?> value="azul">Azul</option>
				<option <?php if($usuario->getTemplate() == 'cinza') {echo "selected='selected'";} ?> value="cinza">Cinza</option>
				<option <?php if($usuario->getTemplate() == 'cinza-vermelho') {echo "selected='selected'";} ?> value="cinza-vermelho">Cinza-vermelho</option>
				<option <?php if($usuario->getTemplate() == 'verde') {echo "selected='selected'";} ?> value="verde">Verde</option>
				<option <?php if($usuario->getTemplate() == 'vermelho') {echo "selected='selected'";} ?> value="vermelho">Vermelho</option>
			</select>
			<br />
			<br />
		</fieldset>
		</form>
<?php	} else {	?>
			<p>Erro no sistema, contate o administrador.</p>
<?php	} ?>


