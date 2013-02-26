<?php

	/* Function library for MCModule */
	
	require_once 'MCAPI.class.php';
	
	$api = new MCAPI($apikey);
	
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
	
	function MCM_generateActions($status) {
		if ($status == 'save') {
			$return = 
		}
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
 
?>