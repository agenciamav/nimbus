<?php
	if($_SERVER['HTTP_HOST'] == '192.168.0.66'){
		define('DIR', 'http://192.168.0.66/Motiva-Moveis/2013/site');
	} else {
		define('DIR', 'http://'.$_SERVER['HTTP_HOST']);
	}
	
	/* Medida preventiva para evitar que outros dominios sejam remetente da sua mensagem. */
	if (eregi('tempsite.ws$|locaweb.com.br$|hospedagemdesites.ws$|websiteseguro.com$', $_SERVER[HTTP_HOST])) {
		//$emailsender='no-reply@s72.com.br'; // Substitua essa linha pelo seu e-mail@seudominio
		$emailsender = "no-reply@" . $_SERVER[HTTP_HOST]; // Substitua essa linha pelo seu e-mail@seudominio
	} else {
		$emailsender = "no-reply@" . $_SERVER[HTTP_HOST];
		// Na linha acima estamos forcando que o remetente seja 'webmaster@seudominio',
		// Voce pode alterar para que o remetente seja, por exemplo, 'contato@seudominio'.
	}
	if(PATH_SEPARATOR == ";") $quebra_linha = "\r\n"; //Se for Windows
	else $quebra_linha = "\n"; //Se "nao for Windows"
	
	$para     = $email;
	$copia    = '';
	$assunto  = 'Motiva | Acesso Restrito '.$assuntoComplemento;
	
	$headers =  'MIME-Version: 1.0' . $quebra_linha.
				'Content-type: text/html; charset=iso-8859-1' . $quebra_linha.
				'From: Motiva <' . $emailsender . '>' . $quebra_linha.
				'Return-Path: ' . $emailsender . $quebra_linha.
				'Reply-To:' . $email . $quebra_linha.
				'Bcc: ' . $copia . $quebra_linha;
	
	#estrutura do E-mail
	$htmlMensagem = "
				<table width='700' border='0' cellspacing='0' cellpadding='0' >
					<tr>
					  <td style='text-align:left;'><img src='".DIR."/images/motiva-mobiliario-atual.png' alt='Motiva Mobiliário Atual' /></td>
					</tr>
				</table>
				<table width=100% border=0 cellspacing=0 cellpadding=0 style='padding:0 20px 0 20px;font-family:Arial, Helvetica, sans-serif;color:#8a8a8a;'>
					<tr>
						<td height='35'></td>
					</tr>
				   <tr  style='font-size:15px;line-height:30px;'>
					 <td>
						<b>".$nome."</b>, use os dados abaixo para ter acesso aos produtos <b>Motiva Mobili&aacute;rio Atual</b>.<br /><br />
					 </td>
					<tr>
					  <td height='0'></td>
					</tr>
				   </tr>
				   <tr>
					 <td style='font-size:14px;line-height:30px;'>
						<b>Nome:</b> " . $nome . "<br />
						<b>Empresa:</b> " . $empresa . "<br />
						<b>CNPJ:</b> " . $cnpj . "</b><br />
						<b>E-mail:</b> " . $email . "</b><br />
						<b>Senha:</b> " . $text . "</b><br /><br />
						<b>Endere&ccedil;o de acesso:</b> <a href='".DIR."/produtos' target='_blank'>".DIR."/produtos</a><br />
						Caso tenha alguma d&uacute;vida, <a href='".DIR."/contato' target='_blank'>entre em contato</a> conosco.
					 </td>
				   </tr>
				 </table>";
				 
	// MANDA FORMULARIO
	if($_SERVER['HTTP_HOST'] == '192.168.0.66'){
		
		die(
			'para: '.$para.'<br />
			mensagem:<br />'.
			$htmlMensagem);
		
	} else {
		mail($para, $assunto, $htmlMensagem, $headers ,"-r".$emailsender);
	}			 
	
?>