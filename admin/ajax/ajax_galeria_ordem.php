<?php
	require('ajax_config.php');
	
	$action = $_POST['action'];
	$id_produto_item = $_POST['id_produto_item'];
	$updateRecordsArray = $_POST['recordsArray'];
	
	if ($action == "updateRecordsListings"){
		
		$listingCounter = 1;
		
		foreach ($updateRecordsArray as $recordIDValue) { 
			$query = "UPDATE s72_imagem SET ordem = " . $listingCounter . " WHERE id = " . $recordIDValue;
			mysql_query($query) or die('Error, insert query failed.'.$query);
			$listingCounter++;
		}
	}
?>