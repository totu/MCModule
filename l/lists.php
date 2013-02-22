
<?php
  
  // This code shows specified account's subscription lists
  // Account is specified with the $apikey
  
  require_once '../inc/MCAPI.class.php'; // MailChimpAPI
  require_once '../inc/config.inc.php'; // contains apikey
  
  $api = new MCAPI($apikey);

  $retval = $api->lists(); // get lists() from MCAPI.class
  
  // ERRORS
  if ($api->errorCode){
	echo "Unable to load lists()!";
	echo "\n\tCode=".$api->errorCode;
	echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  
  // RESULTS
	echo "Lists that matched:".$retval['total']."<br>";
	echo "Lists returned:".sizeof($retval['data'])."<br>";
	foreach ($retval['data'] as $list){
		echo "Id = ".$list['id']." - ".$list['name']."<br>";
		echo "Web_id = ".$list['web_id']."<br>";
		echo "\tSub = ".$list['stats']['member_count'];
		echo "\tUnsub=".$list['stats']['unsubscribe_count'];
		echo "\tCleaned=".$list['stats']['cleaned_count']."<br>";
	}
}

?>