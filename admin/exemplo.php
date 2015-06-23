<?php
	require('classes/exemplo.class.php');
	$exemplo = new Exemplo();
?>
<link rel="stylesheet" type="text/css" href="js/jquery.uploadify-v2.1.4/uploadify.css">
<script type="text/javascript" src="js/jquery.uploadify-v2.1.4/swfobject.js"></script>
<script type="text/javascript" src="js/jquery.uploadify-v2.1.4/jquery.uploadify.v2.1.4.min.js"></script>
<!-- order imagens -->
<script type="text/javascript" src="js/jquery-sortable/ui.core.js"></script>
<script type="text/javascript" src="js/jquery-sortable/ui.widget.js"></script>
<script type="text/javascript" src="js/jquery-sortable/ui.mouse.js"></script>
<script type="text/javascript" src="js/jquery-sortable/ui.sortable.js"></script>
<!-- fim order imagens -->
<script type="text/javascript">
	$(document).ready(function() {
		$("#formAcao").validate();
		
		// botao excluir nas imagens
		$(".efeito-alpha").css('opacity', 0.5);   
		$(".efeito-alpha").mouseover(function(){
			$(this).animate({ 
				opacity: 1
			}, 250 );
		});
		$(".efeito-alpha").mouseout(function(){
			$(this).animate({ 
				opacity: 0.5
			}, 250 );
		});
		
		// table sorter
		$("#tableSorter").tablesorter({
			headers: {
				3: {sorter: false}
			},
			widgets: ['zebra']
		});
		<?php
			// MONTAR A PAGINACAO - JQUERY
			$paginar = false;
			$registros = $exemplo->numRows($busca); // apenas modificar o nome do Objeto PHP.
			if ($registros > $registros_por_pagina){
				echo '$("#tableSorter").tablesorterPager({container: $("#pager")});';
				$paginar = true;
			}
		?>
		// inserir imagem
		$("#image").fancybox({
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'autoScale'     	: false,
			'type'				: 'iframe',
			'width'				: '80%',
			'height'			: '90%',
			'onClosed': function() {parent.location.reload(true); ;}
		});
		// ampliar imagem
		$("a.imag").fancybox({
			'titleShow'		: true,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'autoScale' 	: false
		});
		 
	});
	function show_alert(){
		confirm("Tem certeza que deseja excluir os registros selecionados? Todos os itens relacionados também serão excluídos.");
	}
</script>
<h1><span class="texto1">&raquo;</span>&nbsp;&nbsp;Produtos&nbsp;&nbsp;<span class="texto1">&raquo;</span>&nbsp;&nbsp;<?php echo $usuario->getModuloDescricao();?><span style="float:right;"><a href="<?php echo $arquivo; ?>&acao=formulario" title="Adicionar <?php echo str_replace('_', ' ', ucfirst($modulo)); ?>" ><?php if ($_GET['id']) {echo $usuario->getAcaoAdicionar(); }?></a></span></h1>
<?php	
	# ACAO @LISTAR: Quando a a&ccedil;&atilde;o está vazia;
	if (empty($_GET['acao'])) {
?>
<br />
<form method="get" action="<?php echo $arquivo_acao;?>" name="formExc" id="formExc">
	<input type="hidden" name="acao" id="acao" value="excluir" />
	<input type="hidden" name="modulo" id="modulo" value="<?php echo $modulo; ?>" />
	<?php 
		if (isset($_GET['palavra'])){
			echo '<span class="texto1">Resultado da busca por : <em>'.strtoupper($_GET['palavra']).'</em></span>';
		}
	?>
	<table border="0" cellspacing="1" id="tableSorter" class="tablesorter">
		<thead>
			<tr>
				<th width="40" align="left" title="Ordenar <?php echo $usuario->getModuloDescricao();?> por Identifica&ccedil;&atilde;o">ID</th>
				<th align="left" title="Ordenar <?php echo $usuario->getModuloDescricao();?> por Nome">NOME</th>
				<th align="left" width="60" title="Ordenar <?php echo $usuario->getModuloDescricao();?> por Status">STATUS</th>
				<th width="41"> 
					<a href="<?php echo $arquivo; ?>&acao=formulario" title="Adicionar <?php echo str_replace('_', ' ', ucfirst($modulo)); ?>" ><?php echo $usuario->getAcaoAdicionar(); ?></a>
					<?php echo $usuario->getAcaoExcluir(); ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php	
				$sqlResult = $exemplo->listar($busca, 'ORDER BY nome');
				if($sqlResult){
					
					while ($row = mysql_fetch_array($sqlResult)) {
						if ($usuario->getAcaoEditarTrue()){
							$href_edit = $usuario->getAcaoEditarTrue().$row['id'].'" title="Editar '.str_replace('_', ' ', ucfirst($modulo)).' - '.$row['nome'].' ">';
						} else {
							$href_edit = '<a href="'.$arquivo.'&acao=formulario&id='.$row['id'].'" title="Visualizar '.str_replace('_', ' ', ucfirst($modulo)).' - '.$row['nome'].' ">';
						}
						if ($usuario->getAcaoExcluirInput()){
							$marcar_todos = '<div id="checar"><a href="#" onClick="checkAll(1);">Marcar todos</a></div>';
							$inputExcluir = '<input name="excluir[]" type="checkbox" value="'.$row['id'].'" class="chk" />';
						}
						unset($style);
						$status = 'Inativo';
						$style = 'style="color:red;"';
						if ($row['status'] == 'A') { $status = 'Ativo'; $style = '';}
						echo '
							<tr>
								<td align="center">'.$row['id'].'</td>
								<td align="left">'.$href_edit.$row['nome'].'</a></td>
								<td align="left">'.$href_edit.'<span '.$style.'>'.$status.'</span></a></td>
								<td class="tableExcluir">
									&nbsp;'.$href_edit.$usuario->getAcaoEditar().'</a>&nbsp;
									'.$inputExcluir.'
								</td>
							</tr>
						';
					}
				} else {
					echo '<tr><td colspan="5">&#8250; Nenhum registro encontrado!</td></tr>';
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

	# ACAO @INSERIR OU EDITAR: Quando a a&ccedil;&atilde;o está preenchida; [é usado o mesmo formulário para as duas ações]
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
			
			$sqlResult = $exemplo->listarPorId($id);																
			$row = mysql_fetch_array($sqlResult);
		} 
		/*$autoOrdem = 3;
		if($resultOrdem = $produtoCat->listar('', 'ORDER BY ordem DESC LIMIT 1')){
			$rowOrdem = mysql_fetch_object($resultOrdem);
			$autoOrdem = $rowOrdem->ordem + 3;
		}*/
		?>
		<!--  [1 modulo]  - colocar os 2 [fieldset] em um [form] se assim for preciso. --> 
		<!--  [2 modulos] - colocar colocar cada [fieldset] em seu [form] separado. -->
		<form method="post" action="<?php echo $arquivo_acao;?>" name="formAcao" id="formAcao" class="form" enctype="multipart/form-data" />
			<input type="hidden" name="acao" id="acao" value="<?php echo $acao; ?>" />
			<input type="hidden" name="modulo" id="modulo" value="<?php echo $modulo; ?>" />
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
			<fieldset>
                <label>Nome:</label>
                <label>
                    <input type="text" name="nome" id="nome" class="inputText required" tabindex="1" value="<?php echo $row['nome']; ?>"/>
                </label><br /><br />
				<label><input name="status" id="status" type="checkbox" class="inputCheckbox" <?php if($row['status'] == 'A' || !isset($row['status']) ) {echo 'checked="checked"';} ?> value="A"/>Marque essa op&ccedil;&atilde;o para ativar Exemplo.</label>
				<br class="clear" />
				<br />
				<label style="display:inline;"><img style="cursor:pointer;" onclick="location.href='?modulo=<?php echo $modulo;?>'" src="img/template/<?php echo $usuario->getTemplate();?>/bt-voltar.gif" /></label>
				&nbsp;
				<?php if ($usuario->getAcaoEditarTrue()){ ?>
					<label style="display:inline;">
						<input type="image" name="image2"  src="img/template/<?php echo $usuario->getTemplate().'/'.$img_bt;?>" />
					</label>
				<?php } ?>
			</fieldset>
		</form>
		<fieldset id="moduloInterno">
			<h1><span class="texto1">&#8250;</span>&nbsp;&nbsp;Imagem</h1>
			<br />
			<?php 	
				if (isset($id)){
					require('classes/s72_imagem.class.php');
					$s72_Imagem = new S72_Imagem(null,null,null,null,null,null);
					#dados da imagem pequena
					$metodoP	= 'redimensiona';
					$widthP		= '230';
					$heightP	= '189';
					$tipoP		= 'crop';
					#dados da imagem média
					$metodoM	= 'redimensiona';
					$widthM		= '375';
					$heightM	= '206';
					$tipoM		= 'crop';
					#dados da imagem grande
					$metodoG	= 'redimensiona';
					$widthG		= '800';
					$heightG	= '';
					$tipoG		= 'crop';
					#nome da pasta onde está a imagem, lembrando que está sempre na raiz img/
					$pastaImagem = 'exemplo';
					$arquivoNome = strConverte($row['nome']);
					$imagemComCrop = false;		# modificar para ( false ) para não aparecer o botão ( Recortar Imagem )
					$imagemSemCrop = true;		# modificar para ( false ) para não aparecer o botão ( Upload múltiplos )
					$ordenarImagens= false;		# modificar para ( false ) para não aparecer o botão ( Ordenar Imagens )
			?>
			<script type="text/javascript">
				// [BEGIN] ONREADY
				$(document).ready(function() {
					// [BEGIN] UPLOAD MULTIPLO
					$("#uploadify").uploadify({
						'uploader'       : 'js/jquery.uploadify-v2.1.4/uploadify.swf',
						'script'         : 's72_imagem.php',
						'fileExt'        : '*.jpg;*.gif;*.xlsx;*.doc;*.docx;*.pdf;*.zip;*.rar;*.cdr;*.ai;*.ttf;*.psd',
						'cancelImg'      : 'js/jquery.uploadify-v2.1.4/cancel.png',
						'buttonImg'      : 'img/template/<?php echo $usuario->getTemplate();?>/bt-imagem-sem-crop.jpg',
						'folder'         : 'studio72',
						'queueID'        : 'fileQueue',
						'auto'           : true,
						'multi'          : false,
						'scriptData'     : {'id_modulo':'<?php echo $usuario->getModuloId(); ?>','id_modulo_item':'<?php echo $id; ?>','nome_modulo':'<?php echo $pastaImagem; ?>','arquivo_nome':'<?php echo $arquivoNome;?>','metodoP':'<?php echo $metodoP; ?>','widthP':'<?php echo $widthP; ?>','heightP':'<?php echo $heightP; ?>','tipoP':'<?php echo $tipoP; ?>','metodoM':'<?php echo $metodoM; ?>','widthM':'<?php echo $widthM; ?>','heightM':'<?php echo $heightM; ?>','tipoM':'<?php echo $tipoM; ?>','metodoG':'<?php echo $metodoG; ?>','widthG':'<?php echo $widthG; ?>','heightG':'<?php echo $heightG; ?>','tipoG':'<?php echo $tipoG; ?>','acaoImagem':'semCrop'},
						onAllComplete: function() {
							//$('#status-message').text('upload realizado');
							//alert('complete');
							location.reload();
						}
					});
					// [END] UPLOAD MULTIPLO
				});
				// [END] ONREADY
			</script>
			<?php	
					if($sqlVerificad = $s72_Imagem->listar('WHERE id_modulo = '.$usuario->getModuloId().' AND id_modulo_item = '.$id)){
						$imagemSemCrop = false;
					}
					
					if ($imagemComCrop === true) {
						echo '
							<div style="float:left;">
								<a id="image" href="s72_imagem.php?acao=inserir&nome_modulo='.$pastaImagem.'&id_modulo='.$usuario->getModuloId().'&id_modulo_item='.$id.'&arquivo_nome='.$arquivoNome.'&metodoP='.$metodoP.'&widthP='.$widthP.'&heightP='.$heightP.'&tipoP='.$tipoP.'&metodoM='.$metodoM.'&widthM='.$widthM.'&heightM='.$heightM.'&tipoM='.$tipoM.'&metodoG='.$metodoG.'&widthG='.$widthG.'&heightG='.$heightG.'&tipoG='.$tipoG.'"><img hspace="10" src="img/template/'.$usuario->getTemplate().'/bt-imagem-com-crop.jpg" /></a>
							</div><br /><br />
						';
					}
					if ($imagemSemCrop === true) {
						echo '	
							<div style="float:left;">
								<input style="margin-top:20px;" id="uploadify" type="file" name="Filedata" />
							</div>
						';
					}
					if ($ordenarImagens === true) {
						echo '
							<div style="float:right;">
								<input type="image" src="img/template/'.$usuario->getTemplate().'/bt-ordenar-imagens.jpg" style="cursor:pointer;" id="order_images"  value="Ordenar Imagens" />
							</div>
						';
					}
					if ($imagemSemCrop === true) {
						echo '
							<br /><br />
							<div id="fileQueue"></div>
							<div id="status-message"></div>
						';	
					}
				
					//if ($imagemSemCrop === false) { echo '<br /><br />'; }
					$where = 'WHERE id_modulo = '.$usuario->getModuloId().' AND id_modulo_item = '.$id.' ORDER BY ordem';
					$caminho = '../img/'.$pastaImagem.'/';
					
					$res_img = $s72_Imagem->listar($where);
					if ($res_img) {
						
						// REORDENACAO DE IMAGENS
						while ($row_img = mysql_fetch_array($res_img)) {
							$sort_li .= '<li id="recordsArray_'.$row_img["id"].'" ><img src="'.$caminho.'p/'.$row_img['arquivo'].'" title="Arraste as imagens" /></li>';
						}
						
						// VOLTA O PONTEIRO
						mysql_data_seek($res_img, 0);
						
						$i = 1;
						while ($row_img = mysql_fetch_array($res_img)) {
							$style = 'style=" position:relative; margin-left:40px; width:231px;"';
							if ($row_img['id'] != '') {
								echo '
									<div '.$style.' class="img_conteudo" align="center" >
										<a class="imag" href="'.$caminho.'p/'.$row_img['arquivo'].'" rel="galeria" title="'.$row_img['legenda'].'">
											<img src="'.$caminho.'p/'.$row_img['arquivo'].'" title="Ampliar Imagem" />
										</a>
										<a style=" background-color:#FFFFFF;position:absolute; top:6px; left:6px;" href="'.$arquivo_acao.'?acao=excluirImg&id_pai='.$id.'&arquivo_nome='.$row_img['arquivo'].'&idImg='.$row_img['id'].'" title="Excluir Imagem"><img class="efeito-alpha" src="img/ico_del.gif" style="border:0px;" /></a>
										<!--
										<div align="left" style="margin-top:0px;">
											Legenda: <input type="text" id="legenda_'.$row_img['id'].'" class="inputText" style="width:110px;" value="'.$row_img['legenda'].'" />&nbsp;<input class="btlegendaImg" id="'.$row_img['id'].'" type="button" value="Ok" title="Clique para salvar Legenda" style="height:23px;" />
										</div>
										-->
									</div>
								';
							}
						}
					} else {
						echo '<br />Nenhuma imagem cadastrada.';
					}
				} else {
					echo 'Para inserir imagem, salve';
				}
			?>
		</fieldset>
<?php }	?>
