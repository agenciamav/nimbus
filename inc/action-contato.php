<?php
	// ESTRUTURA FORMULARIO 
	$para     = 'edson@s72.com.br'; // 
	$copia    = 'edson@s72.com.br';
	$assunto  = 'Fale Conosco';
	
	$headers =  'MIME-Version: 1.0' . $quebra_linha.
				'Content-type: text/html; charset=iso-8859-1' . $quebra_linha.
				'From: Nimbus <' . $emailsender . '>' . $quebra_linha.
				'Return-Path: ' . $emailsender . $quebra_linha.
				'Reply-To:' . $email . $quebra_linha.
				'Bcc: ' . $copia . $quebra_linha;
	
	// html detalhes
	$campos = array($nome=>"Nome: ", $email=>"E-mail: ", $fone=>"Fone: ");
	foreach($campos as $campo => $htmlCampo){
		if(!empty($campo)){
			$html_detalhes .= $htmlCampo . ' <font color="#333">' . $campo . '</font><br />';
		}
	}
	
	$htmlMensagem =  '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'.
				'<html>'.
				'<head>'.
				'<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'.
				'<title>Fale Conosco - Nimbus</title>'.
				'</head>'.
					'<body>
						<table width="700" border="0" cellspacing="0" cellpadding="0" style="padding:0 20px 0 20px;font-family:Arial, Helvetica, sans-serif;color:#8a8a8a;">	
							<tr>
							  <td height="30"></td>
							</tr>
							<tr style="font-size:15px;line-height:30px;">
								<td>
									<font color="#000;">'.$nome.'</font> acabou de enviar uma mensagem atrav&eacute;s do Fale Conosco<br />
								</td>
							</tr>
							<tr>
							  <td height="15"></td>
							</tr>
							<tr>
							  <td style="font-size:14px;line-height:30px;">
								'.$html_detalhes.'
							  </td>
							</tr>
							<tr>
							  <td height="5"></td>
							</tr>
							<tr>
							  <td style="font-size:14px;line-height:17px;text-align:justify;">
								Mensagem: <br /><font color="#333" >' .nl2br($msg). '</font>
							  </td>
							</tr>
							<tr>
								<td>
									<td height="35"></td>
								</td>
							</tr>
						</table>
					</body>'.
				'</html>';
	
	// MANDA FORMULARIO
	if($_SERVER['HTTP_HOST'] == '192.168.0.66'){
		die($assunto.'<br />'.$para.'<br />'.$headers.'<br />'.$htmlMensagem);
		$_SESSION['NIMBUS']['MENSAGEMCONTATO'] = 'Sua mensagem foi enviada com sucesso!';
		header('Location: '.DIR.'/fale-conosco');
	} else{
		if (mail($para, $assunto, $htmlMensagem, $headers)){
			$_SESSION['NIMBUS']['MENSAGEMCONTATO'] = 'Sua mensagem foi enviada com sucesso!';
			header('Location: '.DIR.'/fale-conosco');
		} 
	}
?>