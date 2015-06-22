<?php
	# inicia a gravação da imagem sem as funções de recortar imagem
	if ($_REQUEST['acaoImagem'] == 'semCrop') {

		header('Content-type: text/html; charset="iso-8859-1"',true);
		ini_set('upload_max_filesize', '10M');
		ini_set('post_max_size', '10M');
		set_time_limit(0);
		session_cache_expire(3600);
		session_start();
		
		require('classes/s72_conexao.class.php');
		require('classes/s72_usuario.class.php');
		
		$conexao = new Conexao; 
		$usuario = new Usuario;
		
		$conexao->conectarMysql();
		
		require('inc/funcoes.php'); 
		require('classes/s72_imagem.class.php');
		include('classes/s72_imagem_crop.class.php');

		$objetoImagem = new S72_Imagem($id, $id_modulo, $id_modulo_item, $legenda, $arquivo, $caminho);	
	
		$objetoImagem->setIdModulo($_REQUEST['id_modulo']);
		$objetoImagem->setIdModuloItem($_REQUEST['id_modulo_item']);
		$objetoImagem->setCaminho($_REQUEST['nome_modulo']);
		
		$imagem		= isset( $_FILES['Filedata'] ) ? $_FILES['Filedata'] : NULL;
		$tem_crop	= false;
		$img		= '';
		
		if( $imagem['tmp_name'] )
		{
			$imagesize = getimagesize( $imagem['tmp_name'] );
			if( $imagesize !== false )
			{
				$objetoImagem->inserir();
				$ultimo_id_imagem = mysql_insert_id();
				
				if ($sqlVerifica = $objetoImagem->numRows('WHERE id_modulo = '.$objetoImagem->getIdModulo().' AND id_modulo_item = '.$_REQUEST['id_modulo_item'])){
					if ($sqlVerifica == 1){
						$query = "UPDATE s72_imagem SET ordem = 1 WHERE id = " . $ultimo_id_imagem;
						mysql_query($query);
					}
				}
				
				$imagem['name'] = $_REQUEST['arquivo_nome'].'_'.$objetoImagem->getIdModuloItem().'_'.$ultimo_id_imagem.'.jpg';
				// alterar nome do arquivo
				$objetoImagem->editarArquivo($ultimo_id_imagem, $imagem['name']);
				
				if( move_uploaded_file( $imagem['tmp_name'], $objetoImagem->getCaminho().'/o/'.$imagem['name'] ) )
				{
					// carrega a imagem original ("O") e seta nas variaveis 
					$oImg = new Imagem( $objetoImagem->getCaminho().'/o/'.$imagem['name'] );
					$gImg = new Imagem( $objetoImagem->getCaminho().'/o/'.$imagem['name'] );
					$mImg = new Imagem( $objetoImagem->getCaminho().'/o/'.$imagem['name'] );
					$pImg = new Imagem( $objetoImagem->getCaminho().'/o/'.$imagem['name'] );
					
					if( $oImg->valida() == 'OK' )
					{
						// imagem original
						$oImg->redimensiona( '1200', '', 'crop' );
						$oImg->grava( $objetoImagem->getCaminho().'/o/'.$imagem['name'], '90' );
						// imagem grande
						//$gImg->rgb(230,230,230);
						$gImg->$_REQUEST["metodoG"]($_REQUEST["widthG"], $_REQUEST["heightG"], $_REQUEST["tipoG"]);
						$gImg->grava( $objetoImagem->getCaminho().'/g/'.$imagem['name'], '90' );
						// imagem media
						$mImg->$_REQUEST["metodoM"]($_REQUEST["widthM"], $_REQUEST["heightM"], $_REQUEST["tipoM"]);
						$mImg->grava( $objetoImagem->getCaminho().'/m/'.$imagem['name'], '90' );
						// imagem pequena
						$pImg->$_REQUEST["metodoP"]($_REQUEST["widthP"], $_REQUEST["heightP"], $_REQUEST["tipoP"]);
						$pImg->grava( $objetoImagem->getCaminho().'/p/'.$imagem['name'], '90' );
						
						echo $objetoImagem->getIdModulo();
					}
				}
			}
		}
		
	} else {

		require('inc/config.php');
		extract($_POST);
		
		# gravação do video quando inserido o link do youtube
		if (isset($_POST['youtube']) && $_POST['youtube'] == 'youtube'){
			
			require('classes/s72_arquivo.class.php');
			$s72_arquivo = new S72_Arquivo();
			$s72_arquivo->setIdModulo($id_modulo);
			$s72_arquivo->setIdModuloItem($id_modulo_item);
			$s72_arquivo->setLegenda($legenda);
			$s72_arquivo->setCaminho($link);
			$s72_arquivo->setData(dt2us($data));
			$s72_arquivo->inserirLink();
			$idVideo = mysql_insert_id();
			
			$_SESSION['ID-VIDEO'] = $idVideo;
		} 
		
		# gravação do video quando inserido o video FLV
		if (isset($_POST['arq']) && $_POST['arq'] == 'arq'){
			
			require('classes/s72_arquivo.class.php');
			$s72_arquivo = unserialize($_SESSION['s72_arquivo']);
			
			if($_FILES['file']['size'] > 0){
				$s72_arquivo->setIdModuloItem(1);												// id do item.
				$s72_arquivo->setArquivo($_FILES['file']['tmp_name']);							// arquivo temporario.
				$s72_arquivo->setArquivoNome(current(explode(".",$_FILES['file']['name'])));	// nome do arquivo
				$s72_arquivo->setTamanho($_FILES['file']['size']);								// tamanho do arquivo.
				$s72_arquivo->setLegenda($legenda);												// legenda.
				$s72_arquivo->setExt(end(explode(".", $_FILES['file']['name'])));				// extensao.
				$s72_arquivo->setData(dt2us($s72_arquivo_data));								// data.
				
				if(!empty($legenda)){
					$s72_arquivo->setArquivoNome(strSemAcentos($legenda));
				}
				if($s72_arquivo->verificarExtensao() && $s72_arquivo->verificarTamanhoMaximo()){
					$s72_arquivo->inserir();
					// inserir o nome do arquivo no banco de dados
					$s72_arquivo->editarArquivo($s72_arquivo->getId(), $s72_arquivo->getArquivoNome().'_'.$s72_arquivo->getId().'.'. $s72_arquivo->getExt());
				} else {
					$erroMsg = $s72_arquivo->getMsgErro();
				}
				$_SESSION['ID-VIDEO'] = $s72_arquivo->getId();
			}
		}
		# variaveis para inserção da imagem após inserção do vídeo
		if (isset($_POST['youtube']) || isset($_POST['arq'])){
			$_SESSION['ID-MODULO-PV'] = $id_modulo;
			$_SESSION['ID-MODULO-ITEM-PV'] = $id_modulo_item;
			$_SESSION['NOME-MODULO-PV'] = $nome_modulo;
			$_SESSION['ARQUIVO-NOME-PV'] = $arquivo_nome;
			# dados da imagem PEQUENA coloca na sessão, para ser utilizado no crop
			$_SESSION['METODO-PV']	= $metodoP;
			$_SESSION['WIDTH-PV']  	= $widthP;
			$_SESSION['HEIGHT-PV'] 	= $heightP;
			$_SESSION['TIPO-PV'] 	= $tipoP;
			# dados da imagem MÉDIA coloca na sessão, para ser utilizado no crop
			$_SESSION['METODO-MV'] 	= $metodoM;
			$_SESSION['WIDTH-MV'] 	= $widthM;
			$_SESSION['HEIGHT-MV'] 	= $heightM;
			$_SESSION['TIPO-MV'] 	= $tipoM;
			# dados da imagem MÉDIA coloca na sessão, para ser utilizado no crop
			$_SESSION['METODO-GV'] 	= $metodoG;
			$_SESSION['WIDTH-GV'] 	= $widthG;
			$_SESSION['HEIGHT-GV'] 	= $heightG;
			$_SESSION['TIPO-GV'] 	= $tipoG;
		}
		
		include('classes/s72_imagem_crop.class.php');
		include('classes/s72_imagem.class.php');
		$objetoImagem = new S72_Imagem($id, $id_modulo, $id_modulo_item, $legenda, $arquivo, $caminho);	
		$objetoImagem->setIdModulo($_REQUEST['id_modulo']);
		$objetoImagem->setIdModuloItem($_REQUEST['id_modulo_item']);
		$objetoImagem->setCaminho($_REQUEST['nome_modulo']);
		
		/*
		** Configurações do SCRIPT para gravação da imagem com possibilidade de recortar
		*/
		// verifica se está passando os post da imagem selecionada
		if (isset($_GET['imgcrop'])){
			if( $_SERVER['REQUEST_METHOD'] == 'POST' )
			{
				// salva a imagem recortada
				$imgcrop = $_GET['imgcrop'];
				$objetoImagem->setCaminho($_GET['caminhoImg']);
				
				$oImg = new Imagem( $_POST['img'] );
				if( $oImg->valida() == 'OK' )
				{
					$oImg->posicaoCrop( $_POST['x'], $_POST['y'] );
					$oImg->redimensiona( $_POST['w'], $_POST['h'], 'crop' );
					$oImg->grava( $_POST['img'] );
				}
				// carrega a imagem da pasta G e coloca nas variaveis quando cortada
				$gImg = new Imagem( $objetoImagem->getCaminho().'/g/'.$imgcrop );
				$mImg = new Imagem( $objetoImagem->getCaminho().'/g/'.$imgcrop );
				$pImg = new Imagem( $objetoImagem->getCaminho().'/g/'.$imgcrop );
				
				if( $oImg->valida() == 'OK' )
				{
					// redimensiona imagem nos tamanhos definidos
					$gImg->rgb('255', '255', '255');
					$gImg->$_SESSION['METODO-G']($_SESSION['WIDTH-G'], $_SESSION['HEIGHT-G'], $_SESSION['TIPO-G']);
					// salva a imagem recortada para o tamanho definido na pasta M
					$gImg->grava( $objetoImagem->getCaminho().'/g/'.$imgcrop, '90' );
					
					// redimensiona imagem nos tamanhos definidos
					$mImg->rgb('255', '255', '255');
					$mImg->$_SESSION['METODO-M']($_SESSION['WIDTH-M'], $_SESSION['HEIGHT-M'], $_SESSION['TIPO-M']);
					// salva a imagem recortada para o tamanho definido na pasta M
					$mImg->grava( $objetoImagem->getCaminho().'/m/'.$imgcrop, '90' );
					
					// redimensiona imagem nos tamanhos definidos
					$pImg->rgb('255', '255', '255');
					$pImg->$_SESSION['METODO-P']($_SESSION['WIDTH-P'], $_SESSION['HEIGHT-P'], $_SESSION['TIPO-P']);
					// salva a imagem recortada para o tamanho definido na pasta P
					$pImg->grava( $objetoImagem->getCaminho().'/p/'.$imgcrop, '90' );
				}
			}
		}
?>
	<html>
	<head>
	<script type="text/javascript" src="js/jquery-jcrop/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-jcrop/jquery.Jcrop.js"></script>
	<link rel="stylesheet" href="js/jquery-jcrop/jquery.crop.css" type="text/css" />
	</head>
	<body style="width:auto;">
	<?php
		// processa arquivo 
		$imagem		= isset( $_FILES['imagem'] ) ? $_FILES['imagem'] : NULL;
		$tem_crop	= false;
		$img		= '';
		if( $imagem['tmp_name'] )
		{
			$imagesize = getimagesize( $imagem['tmp_name'] );
			if( $imagesize !== false )
			{
				$objetoImagem->inserir();
				$ultimo_id_imagem = mysql_insert_id();
				
				// atualiza a primeira imagem como posição 1
				if ($sqlVerifica = $objetoImagem->numRows('WHERE id_modulo = '.$id_modulo.' AND id_modulo_item = '.$_REQUEST['id_modulo_item'])){
					if ($sqlVerifica == 1){
						$query = "UPDATE s72_imagem SET ordem = 1 WHERE id = " . $ultimo_id_imagem;
						mysql_query($query);
					}
				}
				
				if (!empty($_REQUEST["idVideo"])){
					$imagem['name'] = $_POST['arquivo_nome'].'_'.$_REQUEST['id_modulo_item'].'_'.$_REQUEST["idVideo"].'_'.$ultimo_id_imagem.'.jpg';
				} else {
					$imagem['name'] = $_POST['arquivo_nome'].'_'.$_REQUEST['id_modulo_item'].'_'.$ultimo_id_imagem.'.jpg';
				}
				
				// alterar nome do arquivo
				$objetoImagem->editarArquivo($ultimo_id_imagem, $imagem['name']);
				
				if( move_uploaded_file( $imagem['tmp_name'], $objetoImagem->getCaminho().'/o/'.$imagem['name'] ) )
				{
					// carrega a imagem original ("O") e seta nas variaveis 
					$oImg = new Imagem( $objetoImagem->getCaminho().'/o/'.$imagem['name'] );
					$gImg = new Imagem( $objetoImagem->getCaminho().'/o/'.$imagem['name'] );
					$mImg = new Imagem( $objetoImagem->getCaminho().'/o/'.$imagem['name'] );
					$pImg = new Imagem( $objetoImagem->getCaminho().'/o/'.$imagem['name'] );
					
					if( $oImg->valida() == 'OK' )
					{
						// imagem com tamanhos original armazenada somente para arquivo caso venha precisar posterior 
						$oImg->redimensiona( '1000', '', 'crop' );
						$oImg->grava( $objetoImagem->getCaminho().'/o/'.$imagem['name'], '90' );
						// imagem grande
						$gImg->rgb('255', '255', '255');
						$gImg->$_REQUEST["metodoG"]($_REQUEST["widthG"], $_REQUEST["heightG"], $_REQUEST["tipoG"]);
						$gImg->grava( $objetoImagem->getCaminho().'/g/'.$imagem['name'], '90' );
						// imagem media
						$mImg->rgb('255', '255', '255');
						$mImg->$_REQUEST["metodoM"]($_REQUEST["widthM"], $_REQUEST["heightM"], $_REQUEST["tipoM"]);
						$mImg->grava( $objetoImagem->getCaminho().'/m/'.$imagem['name'], '90' );
						// imagem pequena
						$pImg->rgb('255', '255', '255');
						$pImg->$_REQUEST["metodoP"]($_REQUEST["widthP"], $_REQUEST["heightP"], $_REQUEST["tipoP"]);
						$pImg->grava( $objetoImagem->getCaminho().'/p/'.$imagem['name'], '90' );
						// configurações para imagem no campo de visualização e corte da mesma
						$imagesize 	= getimagesize( $objetoImagem->getCaminho().'/g/'.$imagem['name'] );
						$img		= '<img src="'.$objetoImagem->getCaminho().'/g/'.$imagem['name'].'" id="jcrop" '.$imagesize[3].' />';
						$preview	= '<img src="'.$objetoImagem->getCaminho().'/g/'.$imagem['name'].'" id="preview" '.$imagesize[3].' />';
						$tem_crop 	= true;	
						
						$caminhoImg = $_REQUEST["nome_modulo"];
						# dados da imagem PEQUENA coloca na sessão, para ser utilizado no crop
						$_SESSION['METODO-P']	= $_REQUEST["metodoP"];
						$_SESSION['WIDTH-P']  	= $_REQUEST["widthP"];
						$_SESSION['HEIGHT-P'] 	= $_REQUEST["heightP"];
						$_SESSION['TIPO-P'] 	= $_REQUEST["tipoP"];
						# dados da imagem MÉDIA coloca na sessão, para ser utilizado no crop
						$_SESSION['METODO-M'] 	= $_REQUEST["metodoM"];
						$_SESSION['WIDTH-M'] 	= $_REQUEST["widthM"];
						$_SESSION['HEIGHT-M'] 	= $_REQUEST["heightM"];
						$_SESSION['TIPO-M'] 	= $_REQUEST["tipoM"];
						# dados da imagem MÉDIA coloca na sessão, para ser utilizado no crop
						$_SESSION['METODO-G'] 	= $_REQUEST["metodoG"];
						$_SESSION['WIDTH-G'] 	= $_REQUEST["widthG"];
						$_SESSION['HEIGHT-G'] 	= $_REQUEST["heightG"];
						$_SESSION['TIPO-G'] 	= $_REQUEST["tipoG"];
					}
				}
			}
		}
		if( $tem_crop === true ): 
?>
		<h2 id="tit-jcrop">Recortar Imagem</h2><br />
		<div id="info"> 
			* Clique na imagem para iniciar o corte;<br />
			* Arraste a sele&ccedil;&atilde;o conforme o tamanho desejado;<br />
			* Ap&oacute;s clique no bot&atilde;o salvar abaixo da imagem.
		</div>
		<div id="div-jcrop"> <?php echo $img; ?> <br />
			<br />
			<input type="image" name="image2" src="img/template/azul/bt-salvar.gif" id="bt-crop"/>
		</div>
		<div id="debug">
			<div id="div-preview"> <?php echo $preview; ?> </div>
			<form style="height:100px; margin-left:10px;">
				<div id="dimensoes-caixa">
					<div class="dimensoes-titulo">X</div>
					<div class="dimensoes-imput">
						<input type="text" id="x" size="5" disabled />
						x
						<input type="text" id="x2" size="5" disabled />
					</div>
					<div class="dimensoes-titulo">Y</div>
					<div class="dimensoes-imput">
						<input type="text" id="y" size="5" disabled />
						x
						<input type="text" id="y2" size="5" disabled />
					</div>
					<div class="dimensoes-titulo">Dimens&otilde;es</div>
					<div class="dimensoes-imput">
						<input type="text" id="h" size="5" disabled />
						x
						<input type="text" id="w" size="5" disabled />
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript">
			var img = '<?php echo $objetoImagem->getCaminho().'/g/'.$imagem['name']; ?>';
		
			$(function(){
				$('#jcrop').Jcrop({
					onChange: exibePreview,		// exibe a imagem na seleção
					onSelect: exibePreview,		// exibe a imagem na seleção
					minSize		: [ 100, 100 ],	// tamanho minimo da seleção X, Y
					maxSize		: [ 0, 0 ],		// tamanho maximo sa seleção X, Y
					allowResize	: true			// ativa aumenta da seleção
					//addClass	: 'custom'		// inicia o recorte
					//aspectRatio: 1				//seleção proporcional
				});
				$('#bt-crop').click(function(){
					$.post( 's72_imagem.php?imgcrop=<?php echo $imagem['name']; ?>&caminhoImg=<?php echo $caminhoImg; ?>', {
						img:img, 
						x: $('#x').val(), 
						y: $('#y').val(), 
						w: $('#w').val(), 
						h: $('#h').val()
					}, function(){
						$('#div-jcrop').html( '<img src="' + img + '?' + Math.random() + '" width="'+$('#w').val()+'" height="'+$('#h').val()+'" />' );
						$('#debug').hide();
						$('#tit-jcrop').html('Imagem Recortada');
						$('#info').html('* Clique no canto superior direito para fechar');
					});
					return false;
				});
			});
			
			function exibePreview(c)
			{
				var rx = 100 / c.w;
				var ry = 100 / c.h;
			
				$('#preview').css({
					width: Math.round(rx * <?php echo $imagesize[0]; ?>) + 'px',
					height: Math.round(ry * <?php echo $imagesize[1]; ?>) + 'px',
					marginLeft: '-' + Math.round(rx * c.x) + 'px',
					marginTop: '-' + Math.round(ry * c.y) + 'px'
				});
				
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#x2').val(c.x2);
				$('#y2').val(c.y2);
				$('#w').val(c.w);
				$('#h').val(c.h);
				
			}
		</script>
		<?php 
			else: 
			
			if (isset($_GET['adicionar']) && $_GET['adicionar'] == 'video') {
				include ('inc/jquery.php');
		?>
				<script type="text/javascript">
					$(document).ready(function() {
						$("#link-youtube").hide();
						$("#video-flv").hide();
						
						$('#bt-youtube').click(function() {
							$("#link-youtube").show('slow');
							$("#video-flv").hide();
						});
						$('#bt-flv').click(function() {
							$("#link-youtube").hide();
							$("#video-flv").show('slow');
						});
						// datepicker
						$("#data").datepicker({
							showOn: "button",
							buttonImage: "img/calendar.gif",
							buttonImageOnly: true
						});
						// validate
						$("#youtube").validate();
					
					});
				</script>
				<link rel="stylesheet" href="css/galeria-video.css" type="text/css" />
				<h2>Selecione a forma de envio do V&iacute;deo</h2>
				<br />
				<input name="image" id="bt-youtube"type="image" src="img/template/cinza-vermelho/bt-link-youtube.jpg" />
				<input style="margin-left:130px;" name="image" id="bt-flv"type="image" src="img/template/cinza-vermelho/bt-video-flv.jpg" />
				
				<div id="link-youtube">
					<form name="youtube" id="youtube" action="s72_imagem.php" method="post" style="background-color:#FFF; padding:6px;" />
						<input type="hidden" name="youtube" id="youtube" value="youtube">
						<input type="hidden" name="id_modulo" id="id_modulo" value="<?php echo $_GET['id_modulo']; ?>" />
						<input type="hidden" name="id_modulo_item" id="id_modulo_item" value="<?php echo $_GET['id_modulo_item']; ?>" />
						<input type="hidden" name="nome_modulo" id="nome_modulo" value="<?php echo $_GET['nome_modulo']; ?>" />
						<input type="hidden" name="arquivo_nome" id="arquivo_nome" value="<?php echo $_GET['arquivo_nome']; ?>" />
						
						<input type="hidden" name="metodoP" id="metodoP" value="<?php echo $_GET['metodoP']; ?>" />
						<input type="hidden" name="widthP" id="widthP" value="<?php echo $_GET['widthP']; ?>" />
						<input type="hidden" name="heightP" id="heightP" value="<?php echo $_GET['heightP']; ?>" />
						<input type="hidden" name="tipoP" id="tipoP" value="<?php echo $_GET['tipoP']; ?>" />
						
						<input type="hidden" name="metodoM" id="metodoM" value="<?php echo $_GET['metodoM']; ?>" />
						<input type="hidden" name="widthM" id="widthM" value="<?php echo $_GET['widthM']; ?>" />
						<input type="hidden" name="heightM" id="heightM" value="<?php echo $_GET['heightM']; ?>" />
						<input type="hidden" name="tipoM" id="tipoM" value="<?php echo $_GET['tipoM']; ?>" />
						
						<input type="hidden" name="metodoG" id="metodoG" value="<?php echo $_GET['metodoG']; ?>" />
						<input type="hidden" name="widthG" id="widthG" value="<?php echo $_GET['widthG']; ?>" />
						<input type="hidden" name="heightG" id="heightG" value="<?php echo $_GET['heightG']; ?>" />
						<input type="hidden" name="tipoG" id="tipoG" value="<?php echo $_GET['tipoG']; ?>" />
						
						<fieldset style="border:0;">
							<label>Data:</label>
							<input name="data" id="data" class="inputText" type="text" style="width:90px;" value="<?php echo date('d/m/Y'); ?>" />
							<br /><br />
							<label>legenda:</label>
							<input name="legenda" id="legenda" type="text" class="inputText" value=""/>
							<br /><br />
							<label>Cole aqui link do YouTube do v&iacute;deo:</label>
							<textarea name="link" id="link" class="textarea required" ></textarea>
							<br />
							<br />
							<input type="image" name="image2" src="img/template/cinza-vermelho/bt-confirmar.gif" />
						</fieldset>
					</form>
				</div>
				<div id="video-flv">
					<form method="post" action="s72_imagem.php" name="formAcao" id="formAcao" style="background-color:#FFF;" class="form" enctype="multipart/form-data"/>
						<input type="hidden" id="arq" name="arq" value="arq">
						
						<input type="hidden" name="id_modulo" id="id_modulo" value="<?php echo $_GET['id_modulo']; ?>" />
						<input type="hidden" name="id_modulo_item" id="id_modulo_item" value="<?php echo $_GET['id_modulo_item']; ?>" />
						<input type="hidden" name="nome_modulo" id="nome_modulo" value="<?php echo $_GET['nome_modulo']; ?>" />
						<input type="hidden" name="arquivo_nome" id="arquivo_nome" value="<?php echo $_GET['arquivo_nome']; ?>" />
						
						<input type="hidden" name="metodoP" id="metodoP" value="<?php echo $_GET['metodoP']; ?>" />
						<input type="hidden" name="widthP" id="widthP" value="<?php echo $_GET['widthP']; ?>" />
						<input type="hidden" name="heightP" id="heightP" value="<?php echo $_GET['heightP']; ?>" />
						<input type="hidden" name="tipoP" id="tipoP" value="<?php echo $_GET['tipoP']; ?>" />
						
						<input type="hidden" name="metodoM" id="metodoM" value="<?php echo $_GET['metodoM']; ?>" />
						<input type="hidden" name="widthM" id="widthM" value="<?php echo $_GET['widthM']; ?>" />
						<input type="hidden" name="heightM" id="heightM" value="<?php echo $_GET['heightM']; ?>" />
						<input type="hidden" name="tipoM" id="tipoM" value="<?php echo $_GET['tipoM']; ?>" />
						
						<input type="hidden" name="metodoG" id="metodoG" value="<?php echo $_GET['metodoG']; ?>" />
						<input type="hidden" name="widthG" id="widthG" value="<?php echo $_GET['widthG']; ?>" />
						<input type="hidden" name="heightG" id="heightG" value="<?php echo $_GET['heightG']; ?>" />
						<input type="hidden" name="tipoG" id="tipoG" value="<?php echo $_GET['tipoG']; ?>" />
						
						<fieldset style="text-align:left; border:0; margin-left:15px; float:left;">
							<!-- BEGIN MODULO DE UPLOAD -->
							<?php 	
								/*
								** OBS: Nao esqueça do enctype="multipart/form-data" no FORM.
								** OBS: Nao esqueça que esse modulo pertence ao mesmo FORM das informaçoes, fechar o form APÓS esse modulo.
								*/
								include('classes/s72_arquivo.class.php');
								
								$s72_arquivo = new S72_Arquivo();
								
								$s72_arquivo->setIdModulo($_GET['id_modulo']);		// id do módulo.
								$s72_arquivo->setCaminho("img/arquivos/videos/");	// caminho aonde irá ser salvo o arquivo. [lembre que a raiz é o site]
								$s72_arquivo->setTamanhoMaximo(31457280);			// tamanho máximo permitido em Bytes do arquivo: ex: 2097152 = 2MB
								$s72_arquivo->setLegendaFlag(1);					// se o arquivo tem legenda[1] ou nao[0].
								$s72_arquivo->setExtPermitidas(array('flv'));		// extensoes permitidas: ex: array('jpg','xlsx') ou 0 para permitir todas.
								$s72_arquivo->setMaximoArquivos(1);					// número máximo de uploads
								$s72_arquivo->setModuloNome('Upload');				// altera o nome padrao 'Upload de Arquivos' do módulo de uploads.
								include("s72_arquivo.php");
								
								// o objeto é passado por sessao ao arquivo s72_arquivo.php.
								$_SESSION['s72_arquivo'] = serialize($s72_arquivo);									
							?>
							<!-- END MODULO DE UPLOAD -->
						</fieldset>
					</form>
				</div>
				
		<?php 
			} 
			if (!isset($_GET['adicionar'])) { 
				if (!isset($erroMsg)){
		?>
					<form name="frm-jcrop" id="frm-jcrop" method="post" action="s72_imagem.php" enctype="multipart/form-data" />
					
						<input type="hidden" name="id_modulo" id="id_modulo" value="<?php echo $_GET['id_modulo'].$_SESSION['ID-MODULO-PV']; ?>" />
						<input type="hidden" name="id_modulo_item" id="id_modulo_item" value="<?php echo $_GET['id_modulo_item'].$_SESSION['ID-MODULO-ITEM-PV']; ?>" />
						<input type="hidden" name="nome_modulo" id="nome_modulo" value="<?php echo $_GET['nome_modulo'].$_SESSION['NOME-MODULO-PV']; ?>" />
						<input type="hidden" name="arquivo_nome" id="arquivo_nome" value="<?php echo $_GET['arquivo_nome'].$_SESSION['ARQUIVO-NOME-PV']; ?>" />
						
						<input type="hidden" name="metodoP" id="metodoP" value="<?php echo $_GET['metodoP'].$_SESSION['METODO-PV']; ?>" />
						<input type="hidden" name="widthP" id="widthP" value="<?php echo $_GET['widthP'].$_SESSION['WIDTH-PV']; ?>" />
						<input type="hidden" name="heightP" id="heightP" value="<?php echo $_GET['heightP'].$_SESSION['HEIGHT-PV']; ?>" />
						<input type="hidden" name="tipoP" id="tipoP" value="<?php echo $_GET['tipoP'].$_SESSION['TIPO-PV']; ?>" />
						
						<input type="hidden" name="metodoM" id="metodoM" value="<?php echo $_GET['metodoM'].$_SESSION['METODO-MV']; ?>" />
						<input type="hidden" name="widthM" id="widthM" value="<?php echo $_GET['widthM'].$_SESSION['WIDTH-MV']; ?>" />
						<input type="hidden" name="heightM" id="heightM" value="<?php echo $_GET['heightM'].$_SESSION['HEIGHT-MV']; ?>" />
						<input type="hidden" name="tipoM" id="tipoM" value="<?php echo $_GET['tipoM'].$_SESSION['TIPO-MV']; ?>" />
						
						<input type="hidden" name="metodoG" id="metodoG" value="<?php echo $_GET['metodoG'].$_SESSION['METODO-GV']; ?>" />
						<input type="hidden" name="widthG" id="widthG" value="<?php echo $_GET['widthG'].$_SESSION['WIDTH-GV']; ?>" />
						<input type="hidden" name="heightG" id="heightG" value="<?php echo $_GET['heightG'].$_SESSION['HEIGHT-GV']; ?>" />
						<input type="hidden" name="tipoG" id="tipoG" value="<?php echo $_GET['tipoG'].$_SESSION['TIPO-GV']; ?>" />
						<input type="hidden" name="idVideo" id="idVideo" value="<?php echo $_SESSION['ID-VIDEO']; ?>" />
						<p>
							<label>Selecione uma imagem do seu computador<?php if ($_SESSION['ID-MODULO-PV'] == 7) { echo ' para acoplar ao v&iacute;deo';}?>:</label><br /><br />
							<input type="file" name="imagem" id="imagem" />
							<br />
							<br />
							<input type="image" name="image2" title="salvar imagem" src="img/template/geral/salvar-imagem.png" />
						</p>
					</form>
		<?php 
					 unset($_SESSION['ID-MODULO-PV']);
					 unset($_SESSION['ID-MODULO-ITEM-PV']);
					 unset($_SESSION['NOME-MODULO-PV']);
					 unset($_SESSION['ARQUIVO-NOME-PV']);
					 unset($_SESSION['METODO-PV']);
					 unset($_SESSION['WIDTH-PV']);
					 unset($_SESSION['HEIGHT-PV']);
					 unset($_SESSION['TIPO-PV']);
					 unset($_SESSION['METODO-MV']);
					 unset($_SESSION['HEIGHT-MV']);
					 unset($_SESSION['TIPO-MV']);
					 unset($_SESSION['WIDTH-MV']);
					 unset($_SESSION['METODO-GV']);
					 unset($_SESSION['WIDTH-GV']);
					 unset($_SESSION['HEIGHT-GV']);
					 unset($_SESSION['TIPO-GV']);
					 unset($_SESSION['ID-VIDEO']);
				} else {
					echo '<h2 style="font-size:14px; color:red;">'.$erroMsg.'</h2>';
				}
			} 
			endif; 
		?>
		</body>
		</html>

<?php } ?>