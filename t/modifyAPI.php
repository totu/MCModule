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

	$value = array('name'=> $_POST['title'] , 
		  'html' => $_POST['markItUp']
		);
	$retval = $api->templateUpdate($cid, $value);

	if ($api->errorCode){
		echo "Unable to Update Template! html";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n<br><br>";
	}else {	
		header( 'Location: .' ) ;
	}
	?>
</body>
</html>