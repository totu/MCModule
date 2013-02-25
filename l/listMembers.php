<?php	

	function showMembers($listId,$status) {
		require_once '../inc/MCAPI.class.php'; // MailChimpAPI
		include '../inc/config.inc.php'; // contains apikey
		
		$api = new MCAPI($apikey);
	
		$retval = $api->listMembers($listId,$status, null, 0, 5000 );
		if(sizeof($retval['data'])==0){
			return;
		}
		
		if ($api->errorCode){
			echo "Unable to load listMembers()!";
			echo "\n\tCode=".$api->errorCode;
			echo "\n\tMsg=".$api->errorMessage."\n";
		} else {		
			echo "<table>
			<tr>	<th colspan='9'>" . ucfirst($status) . "</th></tr>
			<tr>
			<td>Email</td>
			<td>Date</td>";
			if ($status == "unsubscribed") {
				echo "<td>Reason Type</td>
				<td>Reason</td>";
			}
			echo "</tr>";
			
			
			foreach($retval['data'] as $member){
				echo "<tr><td>" . $member['email'] . "</td>";
				echo "<td>" . $member['timestamp'] . "</td>";
				if($status == "unsubscribed"){
					echo "<td>" . $member['reason'] . "</td>";
					if ($member['reason_text'] == ""){
						$member['reason_text'] = "no reason given";
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