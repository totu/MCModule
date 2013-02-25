<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/main.css">
        <script src="../js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<div id="explain"></div>
        <div id="wrapper">
			<div id="header">
				<input type="textbox" id='username' name='username' value='Username'>
				<input type="password" id='password' name='password' value='abcdefgh'>
				<input type="button" id='login' name='login' value='Login'>
			</div>
			<div id="body">
				<div id="tabs">
					<div id='h' class="tab">Home</div>
					<div id='l' class="tab">Lists</div>
					<div id='c' class="tab">Campaigns</div>
				</div>
				<div id="main">
					
					<?php
					require_once '../inc/MCAPI.class.php';
					require_once '../inc/config.inc.php';
					$cid = $_COOKIE['cid'];
					$api = new MCAPI($apikey);

					$retval = $api->campaigns();
					if ($api->errorCode){
						echo "Unable to Pull list of Campaign!";
						echo "\n\tCode=".$api->errorCode;
						echo "\n\tMsg=".$api->errorMessage."\n";
					} else {
						$mcid = array();
						$cname = array();
						foreach($retval['data'] as $c) {
							array_push($mcid,$c['id']);
							array_push($cname,$c['title']);				
						}
					}
					
					/* BASIC STATS */
					
					$retval = $api->campaignStats($cid);
 
					if ($api->errorCode){
						echo "Unable to Load Campaign Stats!";
						echo "\n\tCode=".$api->errorCode;
						echo "\n\tMsg=".$api->errorMessage."\n";
					} else {
						echo "<table id='stattable'><tr>
							<th colspan='9'> Stats for  " . 
							ucfirst($cname[array_search($cid, $mcid)]) . "</th></tr><tr>
							<td class='hb'>Hard Bounces</td>
							<td class='sb'>Soft Bounces</td>
							<td>Abuse Reports</td>
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
							<td>" . $retval['last_click'] . "</td>
							<td>" . $retval['emails_sent'] . "</td>
							</tr>";
					}
					echo "</table>";
					echo "<hr>";
					/* URL STATS */	
					
					$stats = $api->campaignClickStats($cid);

					if ($api->errorCode){
						echo "Unable to Pull list of Campaign!";
						echo "\n\tCode=".$api->errorCode;
						echo "\n\tMsg=".$api->errorMessage."\n";
					} else {
						if (sizeof($stats)==0){
							echo "<center>No stats for this campaign yet!</center>";
						} else {
							echo "<table id='urltable'><tr>
							<td>URL</td><td>Clicks</td><td>Unique</td></tr>";
							foreach($stats as $url=>$detail){
								echo "<tr><td>" . $url . "</td><td>" . $detail['clicks']. "</td><td>" . $detail['unique'] . "</td></tr>";
							}
							echo "</table>";
						}
					}
					echo "<hr>";
					/* UNSUBS */
					
					$stats = $api->campaignUnsubscribes($cid);
					
					if ($api->errorCode){
						echo "Unable to Pull list of Campaign!";
						echo "\n\tCode=".$api->errorCode;
						echo "\n\tMsg=".$api->errorMessage."\n";
					} else {
						if ($stats['total'] <= 0) {
							echo "<p style='text-align:center'>Yay! No one has unsubscribed.</p>";
						}else{
							echo "<table id='unsubtable'><tr>
							<td>Unsubscribed addresses</td><td>Reason</td><td>Optional text</td></tr>";
							foreach($stats['data'] as $d) {
								$reason = '-';
								if ($d['reason_text'] != '') { $reason = $d['reason_text'];}
								echo "<tr><td>" . $d['email'] . "</td><td>" . ucfirst(strtolower($d['reason'])) . "</td><td>" . $reason . "</td></tr>";
							}
							echo "</table>";
						}
					}
					?>
				</div>
			</div>
		</div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
        <script src="../js/plugins.js"></script>
        <script src="../js/main.js"></script>

    </body>
</html>
