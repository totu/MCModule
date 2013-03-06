<?php

	require_once '../mcm.php';
	
	if(IsChecked('options','clear')){
		clearList();
	}
	if(!($batch = readCustomers())) {
		trigger_error('$batch is empty');
	}
	

	// OPTIONS
	$optin = IsChecked('options','optin'); //yes, send optin emails
	$up_exist = IsChecked('options','up_exist'); // yes, update currently subscribed users
	$replace_int = true; // no, add interest, don't replace
	$listId = $_COOKIE['lid'];
	
	if( batchSubscribe($listId, $batch,$optin,$up_exist,$replace_int) ){
		header( 'Location: .' ) ;
	}
	
	


?>