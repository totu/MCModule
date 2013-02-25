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
 
	$retval = $api->campaignSendNow($cid);
	 
	if ($api->errorCode){
		echo "Unable to Send Campaign!";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n";
	} else {
		echo "Campaign Sent!\n";
		header( 'Location: .' ) ;
	}
	?>
</body>
</html>