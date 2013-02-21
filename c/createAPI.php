<?php
require_once '../inc/MCAPI.class.php';
require_once '../inc/config.inc.php'; //contains apikey

$api = new MCAPI($apikey);

$opts['list_id'] = $_POST['lid'];
$opts['subject'] = $_POST['subject'];
$opts['from_email'] = $_POST['from_email']; 
$opts['from_name'] = $_POST['from_name'];

$opts['tracking']=array('opens' => true, 'html_clicks' => true, 'text_clicks' => true);

$opts['authenticate'] = true;
if ($_POST['analytics'] != null && $_POST['analytics'] != '') {
	$opts['analytics'] = $_POST['analytics'];
}
$opts['title'] = $_POST['title'];

$content = array('html'=> $_POST['html'] , 
		  'text' => $_POST['text']
		);

$retval = $api->campaignCreate('regular', $opts, $content);

if ($api->errorCode){
	echo "Unable to Create New Campaign!";
	echo "\n\tCode=".$api->errorCode;
	echo "\n\tMsg=".$api->errorMessage."\n";
} else {
	//echo "New Campaign ID:".$retval."\n";
	header( 'Location: .' ) ;
}

?>
