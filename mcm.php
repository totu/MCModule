﻿<?php

	/* Function library for MCModule */
	
	require_once 'inc/MCAPI.class.php';
	require_once 'inc/config.inc.php';
	$api = new MCAPI($apikey);
	
	/* ============================ *
	 *  General tools *
	 * ============================ */
	
	//check for checkboxes
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
	
	
	/* ============================ *
	 *  Campaign related functions  *
	 * ============================ */
	
	function MCM_campaigns() {
		$retval = $api->campaigns();
		if ($api->errorCode) {
			$return = "Unable to pull list of Campaigns!";
		} else {
			$counter = 0;
			$return = "<table>
			<tr>
			<td>Name</td>
			<td>ID</td>
			<td>List</td>
			<td>Status</td>
			<td>Type</td>
			<td>Last time send</td>
			<td>Actions</td>
			</tr>";
			foreach($retval['data'] as $c) {
				$return += "<tr><td>" . ucfirst($c['title']) . "</td>
				<td>" . $c['id'] . "</td><td>
				<td>" . MCM_getListName($c['list_id']) . "</td>
				<td>" . MCM_fixStatus($c['stauts']) . "</td>
				<td>" . ucfirst($c['type']) . "</td>
				<td>" . MCM_fixDate($c['send_time']) . "</td>
				<td>" . MCM_generateActions($c['satus']) . "</td></tr>"; 
			}
		}
	}
	
	// function MCM_generateActions($status) {
		// if ($status == 'save') {
			// $return = 
		// }
	// }
	
	function MCM_fixStatus($str) {
		if ($str != null && $str != '') {
			if ($str == 'save') {
				$str = $str . 'd';
			}
			return ucfirst(strtolower($str));
		}
	}
	
	function MCM_fixDate($date) {
		if ($date != null && $date != '') {
			$t = explode(" ",$date);
			$t = explode("-",$t[0]);
			$num = (int)$t[1];
			switch ($num) {
				case 1:
					$m = 'Jan';
					break;
				case 2:
					$m = 'Feb';
					break;
				case 3:
					$m = 'Mar';
					break;
				case 4:
					$m = 'Apr';
					break;
				case 5:
					$m = 'May';
					break;
				case 6:
					$m = 'Jun';
					break;
				case 7:
					$m = 'Jul';
					break;
				case 8:
					$m = 'Aug';
					break;
				case 9:
					$m = 'Sep';
					break;
				case 10:
					$m = 'Oct';
					break;
				case 11:
					$m = 'Nov';
					break;
				case 12:
					$m = 'Dec';
					break;
			}
			$return = $t[2] . " " . $m . " " . $t[0];
		} else {
			$return = "Empty date";
		}
		return $return;
	}
	
	/* ======================== *
	 *  List related functions  *
	 * ======================== */
	 
	function getLists() {
		require_once 'inc/MCAPI.class.php'; // MailChimpAPI
		require 'inc/config.inc.php'; // contains apikey

		$api = new MCAPI($apikey);

		$retval = $api->lists(); // get lists() from MCAPI.class

		if ($api->errorCode){
			echo "Unable to load lists()!";
			echo "\n\tCode=".$api->errorCode;
			echo "\n\tMsg=".$api->errorMessage."\n";
			return false;
		} else {
			return $retval;
		}
	}
	 
	 function MCM_getListName($lid) {
		$retval = $api->lists();
		if ($api->errorCode) {
			$return = $api->errorCode;
		} else {
			$id = array();
			$name = array();
			foreach ($retval['data'] as $l) {
				array_push($id,$l['id']);
				array_push($name,$l['name']);
			}
			$return = $name[array_search($lid, $id)];
		}
		return $return;
	 }
	 
	 // renders list as a table
	function renderLists() {
		
		$retval = getLists();
		
		
		if($retval){
			echo "<table><tr>
			<td>Name</td>
			<td>ID</td>
			<td>Members</td>
			<td>Unsubscribed</td>
			<td>Cleaned</td>
			<td>Optiot</td>
			</tr>";
			// RESULTS
			$counter = 0;
			foreach ($retval['data'] as $list){
				$counter++;

				echo "<tr><td>" . ucfirst($list['name']) . "</td><td>" . $list['id'] . "</td>";
				echo "<td>" . $list['stats']['member_count'] . "</td>";
				echo "<td>" . $list['stats']['unsubscribe_count'] . "</td>";
				echo "<td>" . $list['stats']['cleaned_count'] . "</td>";
				echo "<td> 
				<input id='id" . $counter . "' type='hidden' name='id' value='" . $list['id'] . "'>
				<input id='t" . $counter . "' type='hidden' name='t' value='" . $list['name'] . "'>
				<img title='Modify' class='mo' id='m" . $counter . "' src='../img/modify.png' width='30' alt='Modify'/>
				<img title='Statistics' class='mo' id='s" . $counter . "' src='../img/statistics.png' width='30' alt='Statistics'/>
				</td></tr>";
			}
			echo "</table><br>";
			//echo "Lists that matched:".$retval['total']."<br>";
			//echo "Lists returned:".sizeof($retval['data'])."<br>";

		}
	}
	 
	 function getMembers($listId,$status){
		require_once '../inc/MCAPI.class.php'; // MailChimpAPI
		require '../inc/config.inc.php'; // contains apikey
		
		$api = new MCAPI($apikey);
	
		$retval = $api->listMembers($listId,$status, null, 0, 5000 );
		if(sizeof($retval['data'])==0){
			return;
		}
		
		if ($api->errorCode){
			echo "Unable to load listMembers()!";
			echo "\n\tCode=".$api->errorCode;
			echo "\n\tMsg=".$api->errorMessage."\n";
			throw new Exception('Failed to get Members');
			return false;
			} else {
				return $retval;
			}
	}
 
	function showMembers($listId,$status) {
			
		if (!($retval = getMembers($listId,$status))) {
			return false;
		} else {
			echo "<table>
			<tr><th ";
			if ($status == "unsubscribed"){
				echo "colspan='4'>";
			} else {
				echo "colspan='2'>";
			}
			echo  ucfirst($status) . "</th></tr>
			<tr>
			<td>Email</td>
			<td>Date</td>";
			if ($status == "unsubscribed") {
				echo "<td>Reason Type</td>
				<td>Reason</td>";
			}
			echo "</tr>";
			
			
			foreach($retval['data'] as $member){
				if ($member['timestamp'] != null) {
					$t = explode(" ",$member['timestamp']);
					$t = explode("-",$t[0]);
					$num = (int)$t[1];
					switch ($num) {
					case 1:
						$m = 'Jan';
						break;
					case 2:
						$m = 'Feb';
						break;
					case 3:
						$m = 'Mar';
						break;
					case 4:
						$m = 'Apr';
						break;
					case 5:
						$m = 'May';
						break;
					case 6:
						$m = 'Jun';
						break;
					case 7:
						$m = 'Jul';
						break;
					case 8:
						$m = 'Aug';
						break;
					case 9:
						$m = 'Sep';
						break;
					case 10:
						$m = 'Oct';
						break;
					case 11:
						$m = 'Nov';
						break;
					case 12:
						$m = 'Dec';
						break;
					}
					$date = $t[2] . " " . $m . " " . $t[0];
				}	
				echo "<tr><td>" . $member['email'] . "</td>";
				echo "<td>" . $date . "</td>";
				if($status == "unsubscribed") {
					echo "<td>" . ucfirst(strtolower($member['reason'])) . "</td>";
					if ($member['reason_text'] == ""){
						$member['reason_text'] = "-";
					}
					echo "<td>" . $member['reason_text'] . "</td>";
				}
				echo "</tr>";
				
			}
			echo "</table><br>";
			//echo "Members matched: ". $retval['total']. "\n";
			//echo "Members returned: ". sizeof($retval['data']). "\n";
		}
	}
	
	// gets filter from filter file
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
	
	// read database according to the filter
	function readCustomers() {
		require '../inc/config.inc.php';
		if(($filter = getFilter())){
			
			$con = mysql_connect($location,$user,$password);
			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}
			
			// select database, db found in config
			mysql_select_db($db, $con);
			
			// Get customers data. filter found in filter config
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
	
	function batchSubscribe($listId,$batch,$optin,$up_exist,$replace_int){
		require_once '../inc/MCAPI.class.php';
		require '../inc/config.inc.php'; //contains apikey
		$api = new MCAPI($apikey);
		
		
		$vals = $api->listBatchSubscribe($listId,$batch,$optin, $up_exist, $replace_int);

		// ERRORS
		if ($api->errorCode){
			echo "Batch Subscribe failed! <br>";
			echo "code:".$api->errorCode."<br>";
			echo "msg :".$api->errorMessage."<br>";
			throw new Exception('BatchSubscribe Failed');
		} else {
			// RESULTS
			return true;
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
	
	// clears list members
	function clearList() {
		$members = getMembers($_COOKIE["lid"],"Subscribers");
		$clearBatch = array();
		
		foreach($members['data'] as $member){
			array_push($clearBatch,$member['email']);
		}
		
		batchUnsubscribe($clearBatch,true,false,false);
	}
	
?>