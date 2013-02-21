<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Campaings</title>
 	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/main.css">
	<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Cuprum|Text+Me+One' rel='stylesheet' type='text/css'>
</head>

<body>
	<!--[if lt IE 7]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->

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
				<div id="padder">	
					<form action="createAPI.php" method='post'>
					<table id='createcampaigntable'>
					<tr>
					<td><label for='lid'>Select a list</label></td>
					<?php
						require_once '../inc/MCAPI.class.php';
						require_once '../inc/config.inc.php'; //contains apikey	
						$api = new MCAPI($apikey);
						$retval = $api->lists();
						if ($api->errorCode){
							echo "Unable to load lists()!";
							echo "<br>Code=".$api->errorCode;
							echo "<br>Msg=".$api->errorMessage."<br>";
						} else {
							foreach ($retval['data'] as $list){
								echo "<td><select name='lid'>
										<option value='" . $list['id'] . "'>" . $list['name'] . "</option>
									</select></td></tr>";
					
							}
						}
					?>
					<br>
					<tr><td><label for='subject'>Subject: </label></td><td><input type="textbox" name='subject' value='Newsletter Subject'></td></tr>
					<tr><td><label for="from_email">From address: </label></td><td><input type="textbox" name='from_email' value='you@example.com'></td></tr>
					<tr><td><label for="from_name">From name: </label></td><td><input type="textbox" name='from_name' value='John Doe'></td></tr>
					<tr><td><label for="analytics">Google analytics key: </label></td><td><input type="textbox" name='analytics' value='UA-XXXXX-X'></td></tr></table>
					<hr>
					<label for="title">Title: </label><input style='position:relative;left:10px' type="textbox" name='title' value='Newsletter Title'><br>
					<label for="html">HTML:</label><textarea name="html" id="html" cols="30" rows="10">Some pretty html content *|UNSUB|* message
					</textarea>
					<label for="text">Plain text: </label>
					<textarea name="text" id="text" cols="30" rows="10">Text text text *|UNSUB|*
					</textarea>
					<br>
					<input style='float:right;position:relative;right:10px;' type="submit" value='Create a New Campaing!'>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
	<script src="../js/plugins.js"></script>
	<script src="../js/main.js"></script>

	</body>
</html>
