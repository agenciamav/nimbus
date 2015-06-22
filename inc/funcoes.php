<?php
	
	/* antiInjection
	** @str - qualquer string que voce desejar proteger contra injection.
	*/
	function antiInjection($str){		
		//$str = preg_replace(sql_regcase("/(\n|\r|%0a|%0d|Content-Type:|bcc:|to:|cc:|Autoreply:|from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "", $str); # Remove palavras suspeitas de injection.
		$str = preg_replace("/(\r|%0a|%0d|Content-Type:|bcc:|to:|cc:|Autoreply:|from|select|insert|delete|update|where|replace|drop|drop table|show tables|#|\*|--|\\\\)/i", '', $str);
		$str = trim($str); # Remove espaços vazios.
		$str = strip_tags($str); # Remove tags HTML e PHP.
		$str = addslashes($str); # Adiciona barras invertidas a uma string.
		return($str);
	} 
	
	/* validaParametro
	** @vetor - qualquer vetor que voce desejar proteger contra injection. 
	** Ex: validaParametro($_POST).
	** OBS: precisa da function "antiInjection" para funcionar.
	*/
	function validaParametro($vetor){
		if (is_array($vetor)){
			foreach ($vetor as $chave => $valor){
				if (is_array($valor)){
					$vetor[$chave] = validaParametro($valor);
				} else $vetor[$chave] = antiInjection($valor);
			}
		} else $vetor[$chave] = validaParametro($valor);
		return($vetor);
	}
	
	/* getHtmlEstados
	** @sigla_comparar - sigla a comparar com as siglas de estados.
	** @name - name do select
	** @id - id do select
	** @css_class - classe css
	** @option_vazio_txt - nome do campo vazio do select
	** Ex: getHtmlEstados() - retorna todos estados sem nenhum marcado.
	*/
	function getHtmlEstados($sigla_comparar='DF', $name='estado', $id='estado', $css_class='inputSelect', $option_vazio_txt='-- Selecione um estado --', $tipo_lista='descricao'){
		$estados = array('AC'=>'Acre', 'AL'=>'Alagoas', 'AM'=>'Amazonas', 'AP'=>'Amap&aacute;', 'BA'=>'Bahia', 
						 'CE'=>'Cear&aacute;', 'DF'=>'Distrito Federal', 'ES'=>'Esp&iacute;rito Santo', 'GO'=>'Goi&aacute;s', 'MA'=>'Maranh&atilde;o', 
						 'MT'=>'Mato Grosso', 'MS'=>'Mato Grosso do Sul', 'MG'=>'Minas Gerais', 'PA'=>'Paran&aacute;', 'PB'=>'Pernambuco', 
						 'PR'=>'Paran&aacute;', 'PE'=>'Pernambuco', 'PI'=>'Piau&iacute;', 'RJ'=>'Rio de Janeiro', 'RN'=>'Rio Grande do Norte', 
						 'RS'=>'Rio Grande do Sul', 'RO'=>'Rond&ocirc;nia', 'RR'=>'Roraima', 'SP'=>'S&atilde;o Paulo', 'SC'=>'Santa Catarina',
						 'SE'=>'Sergipe', 'TO'=>'Tocantins');
		
		foreach($estados as $sigla=>$descricao){
			
			unset($html_selected);
			
			if($sigla_comparar == $sigla){
				$html_selected = 'selected="selected"';
			}
			
			if($tipo_lista == 'sigla'){
				$html_option .= '<option style="width:20px;" value="'.$sigla.'" '.$html_selected.' >'.$sigla.'</option>';	
			} else {
				$html_option .= '<option value="'.$sigla.'" '.$html_selected.' >'.$descricao.'</option>';
			}
			
			
		}
		
		$html_select = '<select style="width:240px !important;" class="'.$css_class.'" name="'.$name.'" id="'.$id.'">';
		$html_select .= '<option value="">'.$option_vazio_txt.'</option>';
		$html_select .= $html_option;
		$html_select .= '</select>';
		
		return($html_select);
	}
	
	// Função que Montas as REGEXP
	function stringParaBusca($str) {
		//Transformando tudo em minúsculas
		$str = trim(strtolower($str));
	
		//Tirando espaços extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
		while ( strpos($str,"  ") )
			$str = str_replace("  "," ",$str);
		
		//Agora, vamos trocar os caracteres perigosos "ã,á..." por coisas limpas "a"
		$caracteresPerigosos = array ("Ã","ã","Õ","õ","á","Á","é","É","í","Í","ó","Ó","ú","Ú","ç","Ç","à","À","è","È","ì","Ì","ò","Ò","ù","Ù","ä","Ä","ë","Ë","ï","Ï","ö","Ö","ü","Ü","Â","Ê","Î","Ô","Û","â","ê","î","ô","û","!","?",",","“","”","-","\"","\\","/");
		$caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
		$str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
		
		//Agora que não temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
		//vamos montar a expressão regular para o MySQL
		$caractresSimples = array("a","e","i","o","u","c");
		$caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
		$str = str_replace($caractresSimples,$caractresEnvelopados,$str);
		$caracteresParaRegExp = array(
			"(a|ã|á|à|ä|â|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|Ã|Á|À|Ä|Â|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
			"(e|é|è|ë|ê|&eacute;|&egrave;|&euml;|&ecirc;|É|È|Ë|Ê|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
			"(i|í|ì|ï|î|&iacute;|&igrave;|&iuml;|&icirc;|Í|Ì|Ï|Î|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
			"(o|õ|ó|ò|ö|ô|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|Õ|Ó|Ò|Ö|Ô|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
			"(u|ú|ù|ü|û|&uacute;|&ugrave;|&uuml;|&ucirc;|Ú|Ù|Ü|Û|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
			"(c|ç|Ç|&ccedil;|&Ccedil;)" );
		$str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
		
		//Trocando espaços por .*
		$str = str_replace(" ",".*",$str);
		
		//Retornando a String finalizada!
		return $str;
	}	
	
	/* getEstadoPorSigla
	** @sigla - sigla a comparar com as siglas de estados.
	** Ex: getEstadoPorSigla('RS') - retorna "Rio Grande do sul".
	*/
	function getEstadoPorSigla($sigla){
		switch($sigla){
			case "AC":
				$nome_estado = "Acre";
				break; 
			case "AL":
				$nome_estado = "Alagoas";
				break; 
			case "AM":
				$nome_estado = "Amazonas";
				break; 
			case "AP":
				$nome_estado = "Amapá";
				break; 
			case "BA":
				$nome_estado = "Bahia";
				break; 
			case "CE":
				$nome_estado = "Ceará";
				break; 
			case "DF":
				$nome_estado = "Distrito Federal";
				break; 
			case "ES":
				$nome_estado = "Espírito Santo";
				break; 
			case "GO":
				$nome_estado = "Goiás";
				break; 
			case "MA":
				$nome_estado = "Maranhão";
				break; 
			case "MG":
				$nome_estado = "Minas Gerais";
				break; 
			case "MS":
				$nome_estado = "Mato Grosso do Sul";
				break; 
			case "MT":
				$nome_estado = "Mato Grosso";
				break; 
			case "PA":
				$nome_estado = "Pará";
				break; 
			case "PB":
				$nome_estado = "Paraíba";
				break; 
			case "PE":
				$nome_estado = "Pernambuco";
				break; 
			case "PI":
				$nome_estado = "Piauí";
				break; 
			case "PR":
				$nome_estado = "Paraná";
				break; 
			case "RJ":
				$nome_estado = "Rio de Janeiro";
				break; 
			case "RN":
				$nome_estado = "Rio Grande do Norte";
				break; 
			case "RS":
				$nome_estado = "Rio Grande do Sul";
				break; 
			case "RO":
				$nome_estado = "Rondônia";
				break; 
			case "RR":
				$nome_estado = "Roraima";
				break; 
			case "SC":
				$nome_estado = "Santa Catarina";
				break; 
			case "SP":
				$nome_estado = "São Paulo";
				break; 
			case "SE":
				$nome_estado = "Sergipe";
				break; 
			case "TO":
				$nome_estado = "Tocantins";
				break;
		}
		return($nome_estado);
	}
	function getEstadoPorDescricao($descricao){
		switch($descricao){
			case "Acre":
				$sigla_estado = "AC";
				break; 
			case "Alagoas":
				$sigla_estado = "AL";
				break; 
			case "Amazonas":
				$sigla_estado = "AM";
				break; 
			case "Amapá":
				$sigla_estado = "AP";
				break; 
			case "Bahia":
				$sigla_estado = "BA";
				break; 
			case "Ceará":
				$sigla_estado = "CE";
				break; 
			case "Distrito Federal":
				$sigla_estado = "DF";
				break; 
			case "Espírito Santo":
				$sigla_estado = "ES";
				break; 
			case "Goiás":
				$sigla_estado = "GO";
				break; 
			case "Maranhão":
				$sigla_estado = "MA";
				break; 
			case "Minas Gerais":
				$sigla_estado = "MG";
				break; 
			case "Mato Grosso do Sul":
				$sigla_estado = "MS";
				break; 
			case "Mato Grosso":
				$sigla_estado = "MT";
				break; 
			case "Pará":
				$sigla_estado = "PA";
				break; 
			case "Paraíba":
				$sigla_estado = "PB";
				break; 
			case "Pernambuco":
				$sigla_estado = "PE";
				break; 
			case "Piauí":
				$sigla_estado = "PI";
				break; 
			case "Paraná":
				$sigla_estado = "PR";
				break; 
			case "Rio de Janeiro":
				$sigla_estado = "RJ";
				break; 
			case "Rio Grande do Norte":
				$sigla_estado = "RN";
				break; 
			case "Rio Grande do Sul":
				$sigla_estado = "RS";
				break; 
			case "Rondônia":
				$sigla_estado = "RO";
				break; 
			case "Roraima":
				$sigla_estado = "RR";
				break; 
			case "Santa Catarina":
				$sigla_estado = "SC";
				break; 
			case "São Paulo":
				$sigla_estado = "SP";
				break; 
			case "Sergipe":
				$sigla_estado = "SE";
				break; 
			case "Tocantins":
				$sigla_estado = "TO";
				break;
		}
		return($sigla_estado);
	}
	function mesInteiro($sigla){
		switch($sigla){
			case "Jan":
				$nome_estado = "Janeiro";
				break; 
			case "Fev":
				$nome_estado = "Fevereiro";
				break; 
			case "Mar":
				$nome_estado = "Mar&ccedil;o";
				break; 
			case "Abr":
				$nome_estado = "Abril";
				break; 
			case "Mai":
				$nome_estado = "Maio";
				break; 
			case "Jun":
				$nome_estado = "Junho";
				break; 
			case "Jul":
				$nome_estado = "Julho";
				break; 
			case "Ago":
				$nome_estado = "Agosto";
				break; 
			case "Set":
				$nome_estado = "Setembro";
				break; 
			case "Out":
				$nome_estado = "Outubro";
				break; 
			case "Nov":
				$nome_estado = "Novembro";
				break; 
			case "Dez":
				$nome_estado = "Dezembro";
				break; 
		}
		return($nome_estado);
	}
	## FUNCOES COMUNS ##	
	
	function strEmpty($str){
		if(empty($str)){
			$str = ' ';
		}
		return($str);
	}
	
	function limpaDados($campo,$editor = 0) {
		global $dadosPassados;
		
		if (!isset($_POST[$campo])) {
			echo '<p>Erro no envio dos dados.</p>';
			echo $campo;
			exit();
		}
		$var = $_POST[$campo];
		if (!$editor) {
			$var = nl2br(htmlspecialchars($var));
			$var = str_replace("\n", "", $var);
			$var = str_replace("\r", "", $var);
			$var = str_replace("\t", "", $var);
		}
		$var = trim($var);
	
		$dadosPassados .= $campo.'='.$var.'&';
		return $var;
	}

	function maiusculas($entrada) {
		$saida = strtr(strtoupper($entrada),"àáâãäåæçèéêëìíîïğñòóôõö÷øùüúşÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖ×ØÙÜÚŞß");
		return $saida;
	}
	
	function minusculas($entrada) {
		$saida = strtr(strtolower($entrada),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖ×ØÙÜÚŞß","àáâãäåæçèéêëìíîïğñòóôõö÷øùüúşÿ");
		return $saida;
	}
	
	function strSemAcentos($string) {  
		if(!empty($string)) {
			$com_acento = "àáâãäèéêëìíîïòóôõöùúûüÀÁÂÃÄÈÉÊËÌÍÎÒÓÔÕÖÙÚÛÜçÇñÑ";   
			$sem_acento = "aaaaaeeeeiiiiooooouuuuAAAAAEEEEIIIOOOOOUUUUcCnN";   
			$especiais = array(' ', ':', '/', '@', '"');
			
			$string = preg_replace( '/'.chr(149).'/', "_", $string );    				# bullet .
			$string = preg_replace( '/'.chr(150).'/', "_", $string );    				# en dash
			$string = preg_replace( '/'.chr(151).'/', "_", $string );    				# em dash
			$string = preg_replace( '/'.chr(153).'/', "_", $string );    		     	# trademark
			$string = preg_replace( '/'.chr(169).'/', "_", $string );    			 	# copyright mark
			$string = preg_replace( '/'.chr(174).'/', "_", $string );        			# registration mark  - &reg;
			
			$string = str_replace(' ', '_', $string);
			$string = strtr($string, $com_acento, $sem_acento);
			$string = strtolower($string);
			
			return $string;
		} else {
			return '';
		}
	}
	
	function strAmigavel($string) {  
		if(!empty($string)) {
			$com_acento = "àáâãäèéêëìíîïòóôõöùúûüÀÁÂÃÄÈÉÊËÌÍÎÒÓÔÕÖÙÚÛÜçÇñÑ";   
			$sem_acento = "aaaaaeeeeiiiiooooouuuuAAAAAEEEEIIIOOOOOUUUUcCnN";   
			$especiais = array(' ', ':', '/', '@', '"');
			
			$string = preg_replace( '/'.chr(149).'/', "+", $string );    				# bullet .
			$string = preg_replace( '/'.chr(150).'/', "+", $string );    				# en dash
			$string = preg_replace( '/'.chr(151).'/', "+", $string );    				# em dash
			$string = preg_replace( '/'.chr(153).'/', "+", $string );    		     	# trademark
			$string = preg_replace( '/'.chr(169).'/', "+", $string );    			 	# copyright mark
			$string = preg_replace( '/'.chr(174).'/', "+", $string );        			# registration mark  - &reg;
			
			$string = str_replace($especiais, '+', $string);
			$string = strtr($string, $com_acento, $sem_acento);
			$string = strtolower($string);
			
			return $string;
		} else {
			return '';
		}
	}

	function strConverte($string) {  
		if(!empty($string)) {
			$com_acento = "àáâãäèéêëìíîïòóôõöùúûüÀÁÂÃÄÈÉÊËÌÍÎÒÓÔÕÖÙÚÛÜçÇñÑ";   
			$sem_acento = "aaaaaeeeeiiiiooooouuuuAAAAAEEEEIIIOOOOOUUUUcCnN";   
			$especiais = array(' ', ':', '/', ',', '.', '&', '%', '(', ')', '[', ']', '#', '@', '*', '$', '!', '?', 'ª', 'º', '|');
			
			$string = preg_replace( '/'.chr(149).'/', "-", $string );    				# bullet .
			$string = preg_replace( '/'.chr(150).'/', "-", $string );    				# en dash
			$string = preg_replace( '/'.chr(151).'/', "-", $string );    				# em dash
			$string = preg_replace( '/'.chr(153).'/', "-", $string );    		     	# trademark
			$string = preg_replace( '/'.chr(169).'/', "-", $string );    			 	# copyright mark
			$string = preg_replace( '/'.chr(174).'/', "-", $string );        			# registration mark  - &reg;
			
			$string = str_replace($especiais, '-', $string);
			$string = strtr($string, $com_acento, $sem_acento);
			$string = strtolower($string);
			
			return $string;
		} else {
			return '';
		}
	}

	function comAcento($entrada) {
		$saida = strtr(strtoupper($entrada),"aaaaaaceeeeiiiinooooouuuyAAAAAACEEEEIIIINOOOOOUUU","àáâãäåçèéêëìíîïñòóôõöùüúÿÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÜÚ");
		return $saida;
	}

	function dt2br($dateus){
		if (!empty($dateus)){
			if (ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})",$dateus,$regs)){
				return($regs[3]."/".$regs[2]."/".$regs[1]);
			} else {
				return(substr($dateus,6,2)."/".substr($dateus,4,2)."/".substr($dateus,0,4));
			}
		} else {
			return("");
		}
	}
	
	function dttm2br($dateus){
		if(!empty($dateus) && $dateus != '0000-00-00 00:00:00'){
			$dateus = explode(' ', $dateus);
			$dt = explode('-', $dateus[0]);
			$hr = explode(':', $dateus[1]);
			return $dt[2].'/'.$dt[1].'/'.$dt[0].' '.$hr[0].':'.$hr[1].':'.$hr[2];
		} else {
			return '';
		}
	}
	
	function dttm2us($dateus){
		if(!empty($dateus) && $dateus != '00/00/0000 00:00:00'){
			$dateus = explode(' ', $dateus);
			$dt = explode('/', $dateus[0]);
			$hr = explode(':', $dateus[1]);
			return $dt[2].'-'.$dt[1].'-'.$dt[0].' '.$hr[0].':'.$hr[1].':'.$hr[2];
		} else {
			return '';
		}
	}
	
	function dt2us($datebr){
		if (!empty($datebr)){
			if (ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})",$datebr,$regs)){
				return($regs[3]."-".$regs[2]."-".$regs[1]);
			} else {
				return(substr($datebr,4,4)."-".substr($datebr,2,2)."-".substr($datebr,0,2));
			}
		} else {
			return("");
		}
	}
	
	function strzero($Valor,$Tamanho) {
		$AuxStr='';
		for ($I=0; $I<$Tamanho; $I++) {
			$AuxStr.='0';
		}
		$AuxStr.=$Valor;
		return(substr($AuxStr,strlen($AuxStr)-$Tamanho,$Tamanho));
	}
	
	function validaCPF($cpf) {
		$soma = 0;
		if (strlen($cpf) <> 11)
			return false;
		// Verifica 1º digito      
		for ($i = 0; $i < 9; $i++) {         
			$soma += (($i+1) * $cpf[$i]);
		}
		$d1 = ($soma % 11);
		if ($d1 == 10) {
			$d1 = 0;
		}
		$soma = 0;
		// Verifica 2º digito
		for ($i = 9, $j = 0; $i > 0; $i--, $j++) {
			$soma += ($i * $cpf[$j]);
		}
		$d2 = ($soma % 11);
		if ($d2 == 10) {
			$d2 = 0;
		}      
		if ($d1 == $cpf[9] && $d2 == $cpf[10]) {
			return true;
		} else {
			return false;
		}
	}
   
	function validaCNPJ($cnpj) {
		if (strlen($cnpj) <> 14)
		return false;
		$soma = 0;
		$soma += ($cnpj[0] * 5);
		$soma += ($cnpj[1] * 4);
		$soma += ($cnpj[2] * 3);
		$soma += ($cnpj[3] * 2);
		$soma += ($cnpj[4] * 9);
		$soma += ($cnpj[5] * 8);
		$soma += ($cnpj[6] * 7);
		$soma += ($cnpj[7] * 6);
		$soma += ($cnpj[8] * 5);
		$soma += ($cnpj[9] * 4);
		$soma += ($cnpj[10] * 3);
		$soma += ($cnpj[11] * 2);
		$d1 = $soma % 11;
		$d1 = $d1 < 2 ? 0 : 11 - $d1;
		$soma = 0;
		$soma += ($cnpj[0] * 6);
		$soma += ($cnpj[1] * 5);
		$soma += ($cnpj[2] * 4);
		$soma += ($cnpj[3] * 3);
		$soma += ($cnpj[4] * 2);
		$soma += ($cnpj[5] * 9);
		$soma += ($cnpj[6] * 8);
		$soma += ($cnpj[7] * 7);
		$soma += ($cnpj[8] * 6);
		$soma += ($cnpj[9] * 5);
		$soma += ($cnpj[10] * 4);
		$soma += ($cnpj[11] * 3);
		$soma += ($cnpj[12] * 2);
		$d2 = $soma % 11;
		$d2 = $d2 < 2 ? 0 : 11 - $d2;
		if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
			return true;
		} else {
			return false;
		}
	}
	
	function pontoCPF($cpf) {
		$aux = substr($cpf,0,3);
		$cpfval = $aux.'.';
		$aux = substr($cpf,3,3);
		$cpfval .= $aux.'.';
		$aux = substr($cpf,6,3);
		$cpfval .= $aux.'-';
		$aux = substr($cpf,9,2);
		$cpfval .= $aux;
		return $cpfval;
	}

	function pontoCNPJ($cnpj) {
		$aux = substr($cnpj,0,2);
		$cnpjval = $aux.'.';
		$aux = substr($cnpj,2,3);
		$cnpjval .= $aux.'.';
		$aux = substr($cnpj,5,3);
		$cnpjval .= $aux.'/';
		$aux = substr($cnpj,8,4);
		$cnpjval .= $aux.'-';
		$aux = substr($cnpj,12,2);
		$cnpjval .= $aux;
		return $cnpjval;
	}
	
	function mesExtenso($mes) {
		if ($mes == '01') {
			$mes_extenso = 'Janeiro';
		} else if ($mes == '02') {
			$mes_extenso = 'Fevereiro';
		} else if ($mes == '03') {
			$mes_extenso = 'Março';
		} else if ($mes == '04') {
			$mes_extenso = 'Abril';
		} else if ($mes == '05') {
			$mes_extenso = 'Maio';
		} else if ($mes == '06') {
			$mes_extenso = 'Junho';
		} else if ($mes == '07') {
			$mes_extenso = 'Julho';
		} else if ($mes == '08') {
			$mes_extenso = 'Agosto';
		} else if ($mes == '09') {
			$mes_extenso = 'Setembro';
		} else if ($mes == '10') {
			$mes_extenso = 'Outubro';
		} else if ($mes == '11') {
			$mes_extenso = 'Novembro';
		} else {
			$mes_extenso = 'Dezembro';
		}
		return $mes_extenso;
	}

	function UnsharpMask($img, $amount, $radius, $threshold)    { 
	
		// $img is an image that is already created within php using 
		// imgcreatetruecolor. No url! $img must be a truecolor image. 
	
		// Attempt to calibrate the parameters to Photoshop: 
		if ($amount > 500) $amount = 500; 
		$amount = $amount * 0.016; 
		if ($radius > 50) $radius = 50; 
		$radius = $radius * 2; 
		if ($threshold > 255) $threshold = 255; 
		 
		$radius = abs(round($radius));     // Only integers make sense. 
		if ($radius == 0) { 
			return $img; imagedestroy($img); break;        
		} 
		$w = imagesx($img); $h = imagesy($img); 
		$imgCanvas = imagecreatetruecolor($w, $h); 
		$imgBlur = imagecreatetruecolor($w, $h); 
		 
		if (function_exists('imageconvolution')) { // PHP >= 5.1  
				$matrix = array(  
				array( 1, 2, 1 ),  
				array( 2, 4, 2 ),  
				array( 1, 2, 1 )  
			);  
			imagecopy ($imgBlur, $img, 0, 0, 0, 0, $w, $h); 
			imageconvolution($imgBlur, $matrix, 16, 0);  
		}  
		else {  
	
		// Move copies of the image around one pixel at the time and merge them with weight 
		// according to the matrix. The same matrix is simply repeated for higher radii. 
			for ($i = 0; $i < $radius; $i++)    { 
				imagecopy ($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h); // left 
				imagecopymerge ($imgBlur, $img, 1, 0, 0, 0, $w, $h, 50); // right 
				imagecopymerge ($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50); // center 
				imagecopy ($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h); 
	
				imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 33.33333 ); // up 
				imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 25); // down 
			} 
		} 
	
		if($threshold>0){ 
			// Calculate the difference between the blurred pixels and the original 
			// and set the pixels 
			for ($x = 0; $x < $w-1; $x++)    { // each row
				for ($y = 0; $y < $h; $y++)    { // each pixel 
						 
					$rgbOrig = ImageColorAt($img, $x, $y); 
					$rOrig = (($rgbOrig >> 16) & 0xFF); 
					$gOrig = (($rgbOrig >> 8) & 0xFF); 
					$bOrig = ($rgbOrig & 0xFF); 
					 
					$rgbBlur = ImageColorAt($imgBlur, $x, $y); 
					 
					$rBlur = (($rgbBlur >> 16) & 0xFF); 
					$gBlur = (($rgbBlur >> 8) & 0xFF); 
					$bBlur = ($rgbBlur & 0xFF); 
					 
					// When the masked pixels differ less from the original 
					// than the threshold specifies, they are set to their original value. 
					$rNew = (abs($rOrig - $rBlur) >= $threshold)  
						? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))  
						: $rOrig; 
					$gNew = (abs($gOrig - $gBlur) >= $threshold)  
						? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))  
						: $gOrig; 
					$bNew = (abs($bOrig - $bBlur) >= $threshold)  
						? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))  
						: $bOrig; 
					 
					if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) { 
						$pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew); 
						ImageSetPixel($img, $x, $y, $pixCol); 
					} 
				} 
			} 
		} else { 
			for ($x = 0; $x < $w; $x++) { // each row 
				for ($y = 0; $y < $h; $y++) { // each pixel 
					$rgbOrig = ImageColorAt($img, $x, $y); 
					$rOrig = (($rgbOrig >> 16) & 0xFF); 
					$gOrig = (($rgbOrig >> 8) & 0xFF); 
					$bOrig = ($rgbOrig & 0xFF); 
					 
					$rgbBlur = ImageColorAt($imgBlur, $x, $y); 
					 
					$rBlur = (($rgbBlur >> 16) & 0xFF); 
					$gBlur = (($rgbBlur >> 8) & 0xFF); 
					$bBlur = ($rgbBlur & 0xFF); 
					 
					$rNew = ($amount * ($rOrig - $rBlur)) + $rOrig; 
						if($rNew>255){$rNew=255;} 
						elseif($rNew<0){$rNew=0;} 
					$gNew = ($amount * ($gOrig - $gBlur)) + $gOrig; 
						if($gNew>255){$gNew=255;} 
						elseif($gNew<0){$gNew=0;} 
					$bNew = ($amount * ($bOrig - $bBlur)) + $bOrig; 
						if($bNew>255){$bNew=255;} 
						elseif($bNew<0){$bNew=0;} 
					$rgbNew = ($rNew << 16) + ($gNew <<8) + $bNew; 
						ImageSetPixel($img, $x, $y, $rgbNew); 
				} 
			} 
		} 
		imagedestroy($imgCanvas); 
		imagedestroy($imgBlur); 
		 
		return $img; 
	} 
	
	function create_thumb($name,$mime_type,$filename,$new_w){
		
		# criando imagem temporaria
		if(preg_match("/^image\/png$/", $mime_type)) {
			$tmp_img = imagecreatefrompng($name);
		} else if(preg_match("/^image\/jpe?g$/", $mime_type)){
			$tmp_img = imagecreatefromjpeg($name);
		}else if(preg_match("/^image\/gif$/", $mime_type)){
			$tmp_img = imagecreatefromgif($name);
		}else{
			return false;
		}
		
		# verificando dimensoes da imagem
		$old_x = imagesx($tmp_img);
		$old_y = imagesy($tmp_img);
		
		# ajustando dimensoes do thumbnail
		$thumb_w = $new_w;
		$thumb_h = floor( $new_w * ( $old_y / $old_x ) );
		
		# criando nova imagem temporaria com as dimensoes novas
		$new_img = imagecreatetruecolor($thumb_w,$thumb_h);
		
		# copiando e redimencionamdo a imagem para o thumbnail 
		imagecopyresampled($new_img, $tmp_img, 0,0,0,0, $thumb_w, $thumb_h, $old_x, $old_y);

		# APLICA EFEITOS DE SHARP
		$new_img = UnsharpMask($new_img, 75, 0.5, 0);
		
		# salvando imagem para o arquivo
		if(preg_match("/^image\/png$/", $mime_type)){
			imagepng($new_img,$filename);
		} else if(preg_match("/^image\/jpe?g$/", $mime_type)){
			imagejpeg($new_img,$filename);
		} else if(preg_match("/^image\/gif$/", $mime_type)){
			imagegif($new_img,$filename);
		}
		
		# destruindo imagens temporarias para liberar memoria
		imagedestroy($new_img);
		imagedestroy($tmp_img);
		
	}

	// Limpa o nome de um arquivo e faz com que possa salva-lo em "safe-mode"
	/* NOTA: Adaptada do Drupal */
	function sanitize_filename($name) {
		$name = strtolower(semAcento($name));
		
		$special_chars = array ("#","$","%","^","&","*","!","~","‘","\"","’","'","=","?","/","[","]","(",")","|","<",">",";","\\",",",".");
		$name = preg_replace("/^[.]*/","",$name); // remove leading dots
		$name = preg_replace("/[.]*$/","",$name); // remove trailing dots
		
		$lastdotpos=strrpos($name, "."); // save last dot position
		
		$name = str_replace($special_chars, "", $name);  // remove special characters
		
		$name = str_replace(' ','_',$name); // replace spaces with _
		
		$afterdot = "";
		if ($lastdotpos !== false) { // Split into name and extension, if any.
		if ($lastdotpos < (strlen($name) - 1))
			$afterdot = substr($name, $lastdotpos);
		
		$extensionlen = strlen($afterdot);
		
		if ($lastdotpos < (50 - $extensionlen) )
			$beforedot = substr($name, 0, $lastdotpos);
		else
			$beforedot = substr($name, 0, (50 - $extensionlen));
		}
		else   // no extension
			$beforedot = substr($name,0,50);
		
		
		if ($afterdot)
			$name = $beforedot . "." . $afterdot;
		else
			$name = $beforedot;
		
		return $name;
	
	}

	function uploadSimples($arquivo,$caminho,$id,$extensao){
		if(!(empty($arquivo))){
			$destino = $caminho.$id.'.'.$extensao;
			if(!move_uploaded_file($arquivo['tmp_name'],$destino)){
				die('Erro ao enviar o arquivo. Pressione f5.<br>');
			}
		}
	}

	function uploadArquivos2($arquivo,$caminho){
		if(!(empty($arquivo))){
			$arquivo1 = $arquivo;
			$arquivo_minusculo = strtolower($arquivo1['name']);
			$arquivo_minusculo = str_replace(" ","_",$arquivo_minusculo);			
			$caracteres = array("ç","~","^","]","[","{","}",";",":","´",",",">","<","-","/","|","@","$","%","ã","â","á","à","é","è","ó","ò","+","=","*","&","(",")","!","#","?","`","ã","©");
			$arquivo_tratado = str_replace($caracteres,"",$arquivo_minusculo);
			$destino = $caminho."/".$arquivo_tratado;
			if(move_uploaded_file($arquivo1['tmp_name'],$destino)){
				#echo 'Arquivo enviado com sucesso.<br>';
			} else {
				echo 'Erro ao enviar o arquivo.<br>';
			}
		}
	}
	
	# Upload de Arquivos com Permissão de Arquivos e Renomear
	function uploadArquivos($campoFile, $diretorio, $renomear){
		
		# Caso fique com o nome original, remove acentos especiais
		if (empty($renomear)){
			# Limpa o nome do arquivo
			$nomeArq = sanitize_filename($_FILES[$campoFile]['name']);
			
			# Verifica se o arquivo existe
			if (file_exists($diretorio . '/' . $nomeArq)) {
				$nomeArqCru = explode('.', $nomeArq);
	
				$extArqCru = array_pop($nomeArqCru);
				$nomeArqCru = implode('.', $nomeArqCru);
				
				for ($i=0; file_exists($diretorio . '/' . $nomeArq); $i++) {
					$nomeArq = $nomeArqCru . $i . '.' . $extArqCru;
				}
			}
		} else {
			# Renomear arquivo forçadamente
			$nomeArq = $renomear;	
		}
					
		# Move para o diretório correto
		move_uploaded_file($_FILES[$campoFile]['tmp_name'], $diretorio . '/' . $nomeArq);
		
		# Permissao no arquivo de leitura e escrita
		chmod($diretorio . '/' . $nomeArq, 0777);
		
		return $nomeArq;
	}
	
	# Upload de Arquivos com Permissão de Arquivos e Renomear
	function apagaArquivos($arquivo, $diretorio){
				
		if (!empty($arquivo) && file_exists($diretorio.'/'.$arquivo) && is_writable($diretorio.'/'.$arquivo)) {
			unlink($diretorio.'/'.$arquivo);			
			return true;
		} else {
			return false;	
		}
	}

	//FUNCAO LEGENDA
	function legenda($texto, $chars = 15){
		$texto = strip_tags($texto);
		//$texto = htmlentities($texto, ENT_NOQUOTES, 'ISO-8859-1');
		if(strlen($texto) > $chars){
			$texto = substr($texto, 0, ($chars-3))."...";
		}
		return $texto;
	}

	//FUNÇÃO MAIL
	function enviaEmail($from, $to, $cc, $bcc, $assunto, $mensagem){
		
		#provisorio testes
		if ($from == 'edson@s72.com.br') {
			$to = $from;
		}
	
		if(PATH_SEPARATOR == ";"){ 
			$quebra = "\r\n"; #Se for Windows
		} else {
			$quebra = "\n";
		}
			
		# Montando o cabeçalho da mensagens
		$headers = "MIME-Version: 1.1" .$quebra;
		$headers .= "Content-type: text/html; charset=iso-8859-1" .$quebra;
		$headers .= "From: " . $from . $quebra;	
		if (!empty($bcc)){
			$headers .= "Bcc: " . $bcc . $quebra;
		}
		$headers .= "Reply-To: " . $from . $quebra;
			
		mail($to, $assunto, $mensagem, $headers);
	}
	
	// função converter bytes
	function tamanhoMb($tamanho) {
		
		$bytes = $tamanho;
		$precision = 2;
		$kilobyte = 1024;
		$megabyte = $kilobyte * 1024;
		$gigabyte = $megabyte * 1024;
		$terabyte = $gigabyte * 1024;
	   
		if (($bytes >= 0) && ($bytes < $kilobyte)) {
			return $bytes . ' B';
	 
		} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
			return round($bytes / $kilobyte, $precision) . ' KB';
	 
		} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
			return round($bytes / $megabyte, $precision) . ' MB';
	 
		} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
			return round($bytes / $gigabyte, $precision) . ' GB';
	 
		} elseif ($bytes >= $terabyte) {
			return round($bytes / $gigabyte, $precision) . ' TB';
		} else {
			return $bytes . ' B';
		}
	}
	
	function geraSenha($tamanho = 8, $maiusculas = true, $minusculas = true, $numeros = true, $simbolos = false){
		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		
		$retorno = '';
		$caracteres = '';
		
		if ($minusculas) $caracteres .= $lmin;
		if ($maiusculas) $caracteres .= $lmai;
		if ($numeros) $caracteres .= $num;
		if ($simbolos) $caracteres .= $simb;
		
		$len = strlen($caracteres);
		
		for ($n = 1; $n <= $tamanho; $n++) {
			$rand = mt_rand(1, $len);
			$retorno .= $caracteres[$rand-1];
		}
		
		return $retorno;
	}
	
	function reduz_imagem($img, $max_x, $max_y, $nome_foto) {
		list($width, $height) = getimagesize($img);
		$original_x = $width;
		$original_y = $height;
		if($original_x > $original_y) {
			$porcentagem = (100 * $max_x) / $original_x;
		} else {
			$porcentagem = (100 * $max_y) / $original_y;
		}
		$tamanho_x = $original_x * ($porcentagem / 100);
		$tamanho_y = $original_y * ($porcentagem / 100);
		$image_p = imagecreatetruecolor($tamanho_x, $tamanho_y);
		$image = imagecreatefromjpeg($img);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $tamanho_x, $tamanho_y, $width, $height);
		imagejpeg($image_p, $nome_foto, 100);
	}
	
?>
