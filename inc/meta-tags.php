<?php
	$description 	= '';
	$keywords 		= '';
	switch($url[0]):
		case '':
		case 'home':
			$title = 'NIMBUS';
			break;
	endswitch;
?>
<head>
	<title><?php echo $title ?></title>
	<meta http-equiv="cache-control" content="public" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="language" content="pt-br" />
	<meta name="allow-search" content="yes" />
	<meta name="author" content="Studio72, http://www.s72.com.br" />
	<meta name="description" content="<?php echo $description ?>" />
	<meta name="keywords" content="<?php echo $keywords ?>" />
	<meta name="publisher-email" content="s72@s72.com.br" />
	<meta name="rating" content="general" />
	<meta name="revisit-after" content="4 days" />
	<meta name="robots" content="index, follow" />
	<meta name="DC.rights" content="Copyright© by Studio72 All rights reserved." />
	<meta name="geo.region" content="BR-RS" />
	
