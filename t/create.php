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
		<link rel="stylesheet" type="text/css" href="../js/html/style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
		
		<script type="text/javascript" src="../js/markitup/jquery.markitup.js"></script>
		<script type="text/javascript" src="../js/markitup/sets/html/set.js"></script>
		
		<link rel="stylesheet" type="text/css" href="../js/markitup/skins/markitup/style.css" /><link rel="stylesheet" type="text/css" href="../js/markitup/sets/default/style.css" />
		
			<script src="../js/plugins.js"></script>
        <script src="../js/main.js"></script>

		
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
				<div id='h' class="tab">Settings</div>
				<div id='l' class="tab">Lists</div>
				<div id='c' class="tab">Campaigns</div>
			</div>
				<div id="main">
				<div id="padder">
					<form action="createAPI.php" method='post'>
									
					<label for="title">Name: </label><input style='position:relative;left:10px' type="textbox" name='title' id='title' value='Template Title'><br><br>
					
					<label for="markItUp">HTML:</label><textarea name="markItUp" id="markItUp" cols="30" rows="10">Some pretty html content.
					</textarea>
					
					<br>
					<input style='float:right;position:relative;right:10px;width:180px; border-radius:5px; background:#47c9e9; color:#fff; text-shadow:1px 1px 4px #000; height:30px;' type="submit" value='Create a New Template!'>
					</form>
					<script type="text/javascript" >
					   $(document).ready(function() {
						  $("#markItUp").markItUp(mySettings);
					   });
					</script>
				</div>
			</div>
		</div>
	</div>


	</body>
</html>
