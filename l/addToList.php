<?php
	require_once '../inc/MCAPI.class.php';
	require_once '../inc/config.inc.php'; //contains apikey
	
	$api = new MCAPI($apikey);
	
	
	function getFilter(){
		require_once './filters.inc.php';
		
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
	
		if(($filter = getFilter())){
		
			$con = mysql_connect("localhost","testi","");
			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}
			
			// select php_testi
			mysql_select_db("php_testi", $con);
			
			// Get customers data and echo it
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

	if(!($batch = readCustomers())) {
		trigger_error('$batch is empty');
	}
	

	// OPTIONS
	$optin = IsChecked('options','optin'); //yes, send optin emails
	$up_exist = IsChecked('options','up_exist'); // yes, update currently subscribed users
	$replace_int = IsChecked('options','replace_int'); // no, add interest, don't replace
	$listId = $_COOKIE['cid'];

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
		}
		header( 'Location: .' ) ;
	}
	


?>