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

	$field = 'title';
	$value = $_POST['title'];

	$retval = $api->campaignUpdate($cid, $field, $value);

	if ($api->errorCode){
		echo "Unable to Update Campaign! title";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n";
	} else {
		$posted_title = true;
	}
	
	$field = 'content';
	$value = array('html'=> $_POST['html'] , 
		  'text' => $_POST['text']
		);
	$retval = $api->campaignUpdate($cid, $field, $value);

	if ($api->errorCode){
		echo "Unable to Update Campaign! html";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n<br><br>";
	}else{
		$posted_content = true;
	}
	
	if ($posted_content && $posted_title) {
		header( 'Location: .' ) ;
	}
	?>
</body>
</html>