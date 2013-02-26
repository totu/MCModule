<?php	

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
?> 