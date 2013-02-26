<?php
	
	function getFilter(){
		require './filters.inc.php';
		
		// get selected filterName and then use that to get the wanted query.
		$filterName = $_POST['formFilter'];
		if(isset($filterName)){
				return $filters[$filterName];
		} else {
			echo 'No filter found';
			return false;
		} 
	}
	// for checking checkboxes
	function IsChecked($chkname,$value)
    {
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }
	
	// read database according to the filter
	function readCustomers() {
		require '../inc/config.inc.php';
		if(($filter = getFilter())){
			
			$con = mysql_connect($location,$user,$password);
			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}
			
			// select php_testi
			mysql_select_db($db, $con);
			
			// Get customers data
			$customers = mysql_query($filter);
			
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
		} else {
			return false;
		}
	}
	
	function batchUnsubscribe($emails,$delete,$bye,$notify){
		require_once '../inc/MCAPI.class.php';
		require '../inc/config.inc.php'; //contains apikey

		$api = new MCAPI($apikey);

		$vals = $api->listBatchUnsubscribe($_COOKIE["lid"], $emails, $delete, $bye, $notify);

		if ($api->errorCode){
			// an api error occurred
			echo "code:".$api->errorCode."\n";
			echo "msg :".$api->errorMessage."\n";
			throw new Exception('batchUnsubscribe Failed');
		} else {
			return;
		}
	}
	
	function clearList() {
		require './listMembers.php';
		
		$members = getMembers($_COOKIE["lid"],"Subscribers");
		$clearBatch = array();
		
		foreach($members['data'] as $member){
			array_push($clearBatch,$member['email']);
		}
		
		batchUnsubscribe($clearBatch,true,false,false);
	}
	
/////////////////////////// START ////////////////////////////////
	
	require_once '../inc/MCAPI.class.php';
	require '../inc/config.inc.php'; //contains apikey
	$api = new MCAPI($apikey);


	if(IsChecked('options','clear')){
		clearList();
	}
	
	
	
	if(!($batch = readCustomers())) {
		trigger_error('$batch is empty');
	}
	

	// OPTIONS
	$optin = IsChecked('options','optin'); //yes, send optin emails
	$up_exist = IsChecked('options','up_exist'); // yes, update currently subscribed users
	$replace_int = IsChecked('options','replace_int'); // no, add interest, don't replace
	$listId = $_COOKIE['lid'];

	$vals = $api->listBatchSubscribe($listId,$batch,$optin, $up_exist, $replace_int);

	// ERRORS
	if ($api->errorCode){
		echo "Batch Subscribe failed! <br>";
		echo "code:".$api->errorCode."<br>";
		echo "msg :".$api->errorMessage."<br>";
		throw new Exception('addToList Failed');
		
	} else {
	// RESULTS
		header( 'Location: .' ) ;
	}
	


?>