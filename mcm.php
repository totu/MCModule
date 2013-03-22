<?php

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
	 *  Template related functions  *
	 * ============================ */
	function MCM_templates() {
		require_once '../inc/MCAPI.class.php';
		require  '../inc/config.inc.php';
		$api = new MCAPI($apikey);
		
		$retval = $api->templates();
		if ($api->errorCode) {
			$return = "Unable to load templates.";
		} elseif (sizeof($retval['user']) <= 0) {
			$return = "<br><br>You have no custom templates.";
		} else {
			$c = 0;
			$return ="<table>
			<tr><td>Name</td>
			<td>ID</td>
			<td>Layout</td>
			<td>Created</td>
			<td>Actions</td></tr>";
			foreach($retval['user'] as $t) {
				$return .= "<tr>
				<td>" . $t['name'] . "</td>
				<td>" . $t['id'] . "</td>
				<td>" . $t['layout'] . "</td>
				<td>" . MCM_fixDate($t['date_created']) . "</td>
				<td>
					<input id='id" . $c . "' type='hidden' name='id' value='" . $t['id'] . "'>
					<input id='t" . $c . "' type='hidden' name='t' value='" . $t['name'] . "'>
					<img title='Modify' class='mo' id='m" . $c . "' src='../img/modify.png' width='30' alt='Modify' /> 
				</td>
				</tr>";
				$c++;
			}
			$return .= "</table>";
		}
		return $return;
	}
	
	function MCM_templateDropdown() {
		require_once '../inc/MCAPI.class.php';
		require  '../inc/config.inc.php';
		$api = new MCAPI($apikey);
		
		$retval = $api->templates();
		if ($api->errorCode) {
			$return = "Unable to load lists()!";
		} else {
			$return = "<select name='tid'>";
			foreach ($retval['user'] as $l) {
				$return .= "<option value='" . $l['id'] . "'>" . MCM_getName($l['id'], 'template') . "</option>";
			}
			$return .= "</select>";
		}
		return $return;
	}
	
	/* ============================ *
	 *  Campaign related functions  *
	 * ============================ */
	function MCM_campaignUnsubs($cid) {
		require_once '../inc/MCAPI.class.php';
		require  '../inc/config.inc.php';
		$api = new MCAPI($apikey);

		$retval = $api->campaignUnsubscribes($cid);
		if ($api->errorCode) {
			$return = $api->errorMessage;
		} elseif ($retval['total'] <= 0) {
			$return = "Yay! No one has unsubscribed because of this campaign.";
		} else {
			$return = "<table>
			<tr><td style='width:400px;'>Unsubscribed address</td>
			<td>Reason</td>
			<td style='width:300px;'>Optional text</td></tr>";
			foreach($retval['data'] as $d) {
				$r = '-';
				if ($d['reason_text'] != '') { $r = $d['reason_text']; }
				$return .= "<tr>
				<td>" . $d['email'] . "</td>
				<td>" . ucfirst(strtolower($d['reason'])) . "</td>
				<td>" . $r . "</td></tr>";
			}
			$return .= "</table>";
		}
		return $return;
	}
	
	function MCM_campaignClicks($cid) {
		require_once '../inc/MCAPI.class.php';
		require  '../inc/config.inc.php';
		$api = new MCAPI($apikey);
		
		$retval = $api->campaignClickStats($cid);
		if ($api->errorCode || sizeof($retval) == 0) {
			$return = "No detailed click statistics available for this campaign yet!";
		} else {
			$return = "<script type='text/javascript'>
				var s1 = []
				</script><table>
			<tr><td style='width:500px;'>URL</td>
			<td>Clicks</td>
			<td style='width:200px'>Unique</td></tr>";
			$counter = 0;
			foreach($retval as $url=>$d) {
				$counter++;
				$return .= "<tr>
				<td>" . $url . "</td>
				<td>" . $d['clicks'] . "</td>
				<td>" . $d['unique'] . "</td>
				<script type='text/javascript'>
				s1.push(['URL " . $counter . "', " . $d['clicks'] . "]);
				</script></tr>"
				;
			}
			$return .= "</table>
			    <div id='pie8' style='margin:0 auto; width:300px; height:300px;'></div>
				<script class='code' type='text/javascript'>$(document).ready(function(){ 
						
					var plot8 = $.jqplot('pie8', [s1], {
						grid: {
							drawBorder: false, 
							drawGridlines: false,
							background: '#ffffff',
							shadow:false
						},
						axesDefaults: {
							
						},
						seriesDefaults:{
							renderer:$.jqplot.PieRenderer,
							rendererOptions: {
								showDataLabels: true
							}
						},
						legend: {
							show: true,
							location: 's'
						}
					}); 
				});</script>";
			
			
			
		}
		return $return;
	}
	
	function MCM_campaignStats($cid) {
		require_once '../inc/MCAPI.class.php';
		require  '../inc/config.inc.php';
		$api = new MCAPI($apikey);
		
		$retval = $api->campaignStats($cid);
		if ($api->errorCode) {
			$return = "Unable to load campaign statistics!";
		} else {
			$return = "<table>
			<tr><td colspan='7' style='font-weight:700;font-size:20px;'> Statistics for " . MCM_getName($cid, 'campaign') . "</td></tr><tr>
			<td class='hb'>Hard Bounces</td>
			<td class='sb'>Soft Bounces</td>
			<td>Abuses</td>
			<td class='explain'>Opens</td>
			<td class='explain'>Clicks</td>
			<td>Last Click</td>
			<td>Emails Sent</td>
			</tr><tr>
			<td class='hb'>" . $retval['hard_bounces'] . "</td>
			<td class='sb'>" . $retval['soft_bounces'] . "</td>
			<td>" . $retval['abuse_reports'] . "</td>
			<td class='explain'>" . $retval['unique_opens'] . " (" . $retval['opens'] . ")</td>
			<td class='explain'>" . $retval['unique_clicks'] . " (" . $retval['clicks'] . ")</td>
			<td>" . MCM_fixDate($retval['last_click']) . "</td>
			<td>" . $retval['emails_sent'] . "</td></tr>
			</table>";
		}
		return $return;
	}
	
	function MCM_campaigns() {
		require_once '../inc/MCAPI.class.php';
		require '../inc/config.inc.php';
		$api = new MCAPI($apikey);
		
		$retval = $api->campaigns();
		if ($api->errorCode) {
			$return = "Unable to pull list of Campaigns!";
		} else {
			$counter = 0;
			$return = "<table>
			<tr>
			<th>Name</th>
			<th>ID</th>
			<th>List</th>
			<th>Status</th>
			<th>Type</th>
			<th>Last time send</th>
			<th>Actions</th>
			</tr>";
			foreach($retval['data'] as $c) {
				$return .= "<tr><td>" . ucfirst($c['title']) . "</td>
				<td>" . $c['id'] . "</td>
				<td>" . MCM_getName($c['list_id'], 'list') . "</td>
				<td>" . MCM_fixStatus($c['status']) . "</td>
				<td>" . ucfirst($c['type']) . "</td>
				<td>" . MCM_fixDate($c['send_time']) . "</td>
				<td style='text-align:left;'>" . MCM_generateActions($c['status'], $c['id'], $c['title'], $counter) . "</td></tr>"; 
				$counter++;
			}
			$return .= "</table>";
		}
		return $return;
	}
	
	function MCM_generateActions($status, $id, $title, $c) {
		require_once '../inc/MCAPI.class.php';
		require  '../inc/config.inc.php';
		$api = new MCAPI($apikey);
		
		$return = "<input id='id" . $c . "' type='hidden' name='id' value='" . $id . "'>
		<input id='t" . $c . "' type='hidden' name='t' value='" . $title . "'>";
		if ($status == 'save') {
			$return .= "
			<img title='Modify' class='mo' id='m" . $c . "' src='../img/modify.png' width='30' alt='Modify' />
			<img title='Delete' class='mo' id='d" . $c . "' src='../img/delete.png' width='30' alt='Delete' />
			<img title='Send' class='mo' id='n" . $c . "' src='../img/send.png' width='30' alt='Send' />";
		} else {
			$return .= "
			<img title='Statistics' class='mo' id='s" . $c . "' src='../img/statistics.png' width='30' alt='Statistics' />
			<img title='Delete' class='mo' id='d" . $c . "' src='../img/delete.png' width='30' alt='Delete' />";
		}
		return $return;
	}
	
	function MCM_fixStatus($str) {
		if ($str != null && $str != '') {
			if ($str == 'save') {
				$str = $str . 'd';
			}
			return ucfirst(strtolower($str));
		}
	}
	
	function MCM_fixDate($date) {
		if ($date != null || $date != '') {
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
			$return = "";
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
	 
	 
	function MCM_getName($lid, $opt) {
		require_once '../inc/MCAPI.class.php';
		require  '../inc/config.inc.php';
		$api = new MCAPI($apikey);
		
		if ($opt == 'list') {
			$retval = $api->lists();
			$v = 'name';
		} elseif ($opt == 'template') {
			$retval = $api->templates();
			$v = 'name';
			if ($api->errorCode) {
				$return = $api->errorCode;
			} else {
				$id = array();
				$name = array();
				foreach ($retval['user'] as $l) {
					array_push($id,$l['id']);
					array_push($name,$l[$v]);
				}
				$return = $name[array_search($lid, $id)];
			}
			return ucfirst(strtolower($return));
		} else {
			$retval = $api->campaigns();
			$v = 'title';
		}
			if ($api->errorCode) {
				$return = $api->errorCode;
			} else {
				$id = array();
				$name = array();
				foreach ($retval['data'] as $l) {
					array_push($id,$l['id']);
					array_push($name,$l[$v]);
				}
				$return = $name[array_search($lid, $id)];
			}
		return ucfirst(strtolower($return));
	}
	
	function MCM_listDropdown() {
		require_once '../inc/MCAPI.class.php';
		require  '../inc/config.inc.php';
		$api = new MCAPI($apikey);
		
		$retval = $api->lists();
		if ($api->errorCode) {
			$return = "Unable to load lists()!";
		} else {
			$return = "<select name='lid'>";
			foreach ($retval['data'] as $l) {
				$return .= "<option value='" . $l['id'] . "'>" . MCM_getName($l['id'], 'list') . "</option>";
			}
			$return .= "</select>";
		}
		return $return;
	}
	 
	 // renders list as a table
	function MCM_showLists() {
		
		$retval = getLists();
		
		
		if($retval){
			echo "<table id='slt'><tr>
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
	 
	 function MCM_getMembers($listId,$status){
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
 
	function MCM_showMembers($listId,$status) {
			
		if (!($retval = MCM_getMembers($listId,$status))) {
			return false;
		} else {
			echo "<table class='ls'>
			<tr><th style='font-weight:bold;' ";
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
					$date = MCM_fixDate($member['timestamp']);
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
			echo "</table><br> <br>";
			
			//echo "Members matched: ". $retval['total']. "\n";
			//echo "Members returned: ". sizeof($retval['data']). "\n";
		}
	}
	
	// gets filter from filter file
	function MCM_getFilter(){
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
	function MCM_readCustomers() {
		require '../inc/config.inc.php';
		if(($filter = MCM_getFilter())){
			
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
	
	function MCM_batchSubscribe($listId,$batch,$optin,$up_exist,$replace_int){
		require_once '../inc/MCAPI.class.php';
		require '../inc/config.inc.php'; //contains apikey
		$api = new MCAPI($apikey);
		
		
		$vals = $api->listBatchSubscribe($listId,$batch,$optin, $up_exist, $replace_int);

		// ERRORS
		if ($api->errorCode){
			echo "Batch Subscribe failed! <br>";
			echo "code:".$api->errorCode."<br>";
			echo "msg :".$api->errorMessage."<br>";
			throw new Exception('MCM_batchSubscribe Failed');
		} else {
			// RESULTS
			return true;
		}
	
	
	}
	
	function MCM_batchUnsubscribe($emails,$delete,$bye,$notify){
		require_once '../inc/MCAPI.class.php';
		require '../inc/config.inc.php'; //contains apikey

		$api = new MCAPI($apikey);

		$vals = $api->listBatchUnsubscribe($_COOKIE["lid"], $emails, $delete, $bye, $notify);

		if ($api->errorCode){
			// an api error occurred
			echo "code:".$api->errorCode."\n";
			echo "msg :".$api->errorMessage."\n";
			throw new Exception('MCM_batchUnsubscribe Failed');
		} else {
			return;
		}
	}
	
	// clears list members
	function MCM_clearList() {
		$members = MCM_getMembers($_COOKIE["lid"],"Subscribers");
		$clearBatch = array();
		
		if( $members == null ) {
			return;
		}
		
		foreach($members['data'] as $member){
			array_push($clearBatch,$member['email']);
		}
		
		MCM_batchUnsubscribe($clearBatch,true,false,false);
	}
	
?>