<?php
	require_once '../inc/MCAPI.class.php';
	require_once '../inc/config.inc.php'; //contains apikey

	$api = new MCAPI($apikey);

	function readCustomers() {
		$con = mysql_connect("localhost","testi","");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		
		// select php_testi
		mysql_select_db("php_testi", $con);
		
		// Get customers data and echo it
		$customers = mysql_query("SELECT DISTINCT * FROM Customers");
		
		while($row = mysql_fetch_array($customers))
		{
			// takes the name (first and surname) that was fetched from database and explodes it
			// 
			$name = explode(" ",$row['Name']);
			$firstname = $name[0];
			$lastname = $name[1];
			
			$email = $row['Email'];
			$batch[] = array('EMAIL'=>$email, 'FNAME'=>$firstname, 'LNAME'=>$lastname);
			
			// DEBUG
			//echo $row['Name'] . ", " . $row['Email'] . "<br>";
		}

		mysql_close($con);
		
		return $batch;
	}

	$batch = readCustomers();


	$optin = false; //yes, send optin emails
	$up_exist = true; // yes, update currently subscribed users
	$replace_int = false; // no, add interest, don't replace
	// List ID can be changed in the config. Get lists with lists.php.

	$vals = $api->listBatchSubscribe($listId,$batch,$optin, $up_exist, $replace_int);

	// ERRORS
	if ($api->errorCode){
		echo "Batch Subscribe failed! <br>";
		echo "code:".$api->errorCode."<br>";
		echo "msg :".$api->errorMessage."<br>";
	} else {
	// RESULTS
	echo "added:   ".$vals['add_count']."<br>";
	echo "updated: ".$vals['update_count']."<br>";
	echo "errors:  ".$vals['error_count']."<br>";
	
	foreach($vals['errors'] as $val){
		echo $val['email_address']. " failed<br>";
		echo "code:".$val['code']."<br>";
		echo "msg :".$val['message']."<br>";
	}}


?>