<?php
	require('ajax_config.php');
	include('../classes/newsletter.class.php');
	$news = new Newsletter();
	
	header("Content-Description: File Transfer");
	header("Content-type: application/msexcel");
	header("Content-Disposition: attachment; filename=newsletter.xls");
	
	if($result = $news->listar()){
		$html = '
			<table>
				<tr>
					<td>Nome</td>
					<td>E-mail</td>
				</tr>
		';
		while($row = mysql_fetch_object($result)){
			$html .= '
				<tr>
					<td>'.$row->nome.'</td>
					<td>'.$row->email.'</td>
				</tr>
			';
		}
		$html .= '
			</table>
		';
	}
	echo $html;
?>