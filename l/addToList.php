<?php
	
	require_once '../mcm.php';
		
	if(IsChecked('options','clear')){
		MCM_clearList();
	}

	if(!($batch = MCM_readCustomers())) {
		trigger_error('$batch is empty');
	}

	// OPTIONS
	$optin = IsChecked('options','optin'); //yes, send optin emails
	$up_exist = IsChecked('options','up_exist'); // yes, update currently subscribed users
	$replace_int = true; // no, add interest, don't replace
	$listId = $_COOKIE['lid'];
	
	if( MCM_batchSubscribe($listId, $batch,$optin,$up_exist,$replace_int) ){
		header( 'Location: .' ) ;
	}

?>