<script type="text/javascript">
	$(document).ready(function() {
		$('#box-rep, #box-lojas').jScrollPane({verticalGutter: 8});
	});
</script>
<?php
	include('ajax_config.php');
	include('../inc/funcoes.php');
	include('../classes/representante.class.php');
	include('../classes/loja_exclusiva.class.php');
	include('../classes/s72_imagem.class.php');
	
	$representante = new Representante();
	$lojaExclusiva = new LojaExclusiva();
	$s72_imagem = new S72_Imagem();
	
	extract($_POST);
	
	switch($acao){
		case 'listaRepresentante':
			
			if ($result = $representante->listarPorRegiao($uf)){
				$resultado = '
					<h2 class="desc-estado">'.getEstadoPorSigla(strtoupper($uf)).'</h2>
					<div id="box-rep" class="left">
				';
				while($row = mysql_fetch_object($result)){

					unset($fones);
					unset($emails);
					unset($area);
					$fones = str_replace('(', '', $row->telefone_1);
					$fones = 'Fone: '.str_replace(')', '', $fones).'<br />';
					if (!empty($row->telefone_2)){
						$fones = str_replace('(', '', $row->telefone_1).' / '.str_replace('(', '', $row->telefone_2);
						$fones = 'Fones: '.str_replace(')', '', $fones).'<br />';
					}
					if (!empty($row->email_1)){
						$emails = '<a href="mailto:'.$row->email_1.'">'.$row->email_1.'</a><br />';
					}
					if (!empty($row->email_2)){
						$emails = '<a href="mailto:'.$row->email_1.'">'.$row->email_1.'</a><br /><a href="mailto:'.$row->email_2.'">'.$row->email_2.'</a><br />';
					}
					if (!empty($row->atuacao_descricao)){
						$area = 'Área de Atuação: <br />'.nl2br($row->atuacao_descricao);
					}
					$resultado .= '
						<p class="representante left primeira-loja" >
							<strong>'.$row->nome.'</strong><br />	
							'.$row->endereco.'<br />
							'.$row->cidade.' - '.$row->estado.' - '.$row->cep.' <br />
							'.$fones.'
							'.$emails.'
							'.$area.'
						</p>	
					';
				}
				$resultado .= '</div>';
			} else {
				$resultado = '
					<h2 class="desc-estado">'.getEstadoPorSigla(strtoupper($uf)).'</h2>
					<div id="box-rep" class="left">
						<p class="representante left primeira-loja">
							<strong>Norberto Luiz Faccini</strong><br />	
							Contato direto na empresa<br />
							Fone: 54 9609.9328 <br />
							<a href="mailto:norberto.comercial@dalmobile.com.br">norberto.comercial@dalmobile.com.br</a><br />
						</p>
					</div>	
				';
			}
			echo $resultado;
			break;
			
		case 'retorna_cidade':

			if ($result = $lojaExclusiva->listarCidade($uf)){
				
				$select_retorno .= '
					<select id="filtro_cidade" name="filtro_cidade" style="z-index:9999;">
						<option value=""> Selecione a Cidade </option>
				';				
						while($row = mysql_fetch_object($result)){
							$select_retorno .= '<option name="cidade['.$row->cidade.']" '.$selected.' value="'.$row->cidade.'">'.ucwords(minusculas($row->cidade)).'</option>';
						}
				$select_retorno .= '
					</select>
				';		

			} else {
				$select_retorno = '
					<p style="margin-left:-5px;" class="representante left "> 
						<strong>Norberto Luiz Faccini</strong><br />
						Contato direto na empresa<br />
						Fone: 54 9609.9328<br />
						<a href="mailto:norberto.comercial@dalmobile.com.br">norberto.comercial@dalmobile.com.br</a><br />
					</p>
				';		
			}
			echo $select_retorno;
			break;

		case 'retorna_loja':
			if($result = $lojaExclusiva->listarPorCidade(utf8_decode($cidade))){
				$select_retorno = '<div id="box-lojas" class="left">';
				$i = 1;
				while($row = mysql_fetch_object($result)){
					
					unset($html_detalhes);
					unset($email1);
					unset($email2);
					unset($site);
					if (!empty($row->email_1)){
						$email1 = '<a href="mailto:'.$row->email_1.'">'.$row->email_1.'</a>';
					}
					if (!empty($row->email_2)){
						$email2 = '<a href="mailto:'.$row->email_2.'">'.$row->email_2.'</a>';
					}
					if (!empty($row->site)){
						$site = '<a target="_blank" href="http://'.$row->site.'">'.$row->site.'</a>';
					}
					if (!empty($row->atuacao_descricao)){
						$googleMaps = '<a target="_blank" href="'.$row->atuacao_descricao.'">Veja a Localização do Mapa</a>';
					}
					$campos = array($row->razao=>'', $row->endereco=>'', $row->bairro=>'', '<strong>'.$row->cidade.'</strong>'=>'', $row->telefone_1.' '.$row->telefone_2=>'', $email1=>'', $email2=>'', $site=>'', $googleMaps=>'');
					foreach($campos as $campo => $htmlCampo){
						
						if(!empty($campo)){
							$html_detalhes .= $htmlCampo . $campo . "<br />";
						}
					}
					$class = '';
					if($i == 1){
						$class = 'primeira-loja';
					}
					unset($img);
					if($sqlImg = $s72_imagem->listarPorPai($row->id, 'AND id_modulo = 7')){
						$rowImg = mysql_fetch_object($sqlImg);
						$img = '
							<div class="img-loja '.$class.'">
								<img src="'.DIR.'/'.$rowImg->caminho.'m/'.$rowImg->arquivo.'"/>
							</div>
						';
					} else {
						$img = '
							<div class="img-loja-vazio '.$class.'"></div>
						';
					}
					$select_retorno .= '
						'.$img.'
						<p style="padding-top:0;" class="representante left">
							<strong>'.$row->nome.'</strong><br />
							'.$html_detalhes.'
						</p>
					';
					$i++;
				} 
				$select_retorno .= '</div>';
			}  else {
				$select_retorno = '<div id="box-lojas" class="left">';
				$select_retorno .= '
					<p class="representante left primeira-loja"> 
						<strong>Norberto Luiz Faccini</strong><br />
						Contato direto na empresa<br />
						Fone: 54 9609.9328<br />
						<a href="mailto:norberto.comercial@dalmobile.com.br">norberto.comercial@dalmobile.com.br</a><br />
					</p>
				';	
				$select_retorno .= '</div>';	
			}
			
			echo $select_retorno;
			break;
	}
?>			
