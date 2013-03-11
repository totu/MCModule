<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<?php
	require_once '../inc/MCAPI.class.php';
	require_once '../inc/config.inc.php'; //contains apikey
	
	$cid = $_COOKIE['cid'];
	$api = new MCAPI($apikey);
	
	$retval = $api->templateAdd($_POST['title'], $_POST['markItUp']);

	if ($api->errorCode){
		echo "Unable to Create Template! html";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n<br><br>";
	}else{
		header( 'Location: .' ) ;
	}
	?>
</body>
</html>