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

	$retval = $api->campaignDelete($cid, $cid);

	if ($api->errorCode){
		echo "Unable to Update Campaign! title";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n";
	}
	
		header( 'Location: .' ) ;
	?>
</body>
</html>