<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<?php
	require_once 'inc/MCAPI.class.php';
	require_once 'inc/config.inc.php'; //contains apikey
	
	$cid = $_COOKIE['cid'];
	$api = new MCAPI($apikey);

	$field = 'title';
	$value = $_POST['title'];

	$retval = $api->campaignUpdate($cid, $field, $value);

	if ($api->errorCode){
		echo "Unable to Update Campaign!";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n";
	} else {
		echo "SUCCESS! \n";
	}

	?>
</body>
</html>