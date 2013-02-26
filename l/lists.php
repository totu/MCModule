<?php
function getLists() {
	require_once '../inc/MCAPI.class.php'; // MailChimpAPI
	require_once '../inc/config.inc.php'; // contains apikey
      
	$api = new MCAPI($apikey);

	$retval = $api->lists(); // get lists() from MCAPI.class
	
	if ($api->errorCode){
		echo "Unable to load lists()!";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n";
		throw new Exception('getLists Failed');
	} else {
		return $retval;
	}
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
?>