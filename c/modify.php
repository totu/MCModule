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
					<br>
					<form action="modifyAPI.php" method="post">
					<label for="title">Title: </label>
					<?php
						require_once '../inc/MCAPI.class.php';
						require_once '../inc/config.inc.php'; //contains apikey
						
						$cid = $_COOKIE['cid'];
						$api = new MCAPI($apikey);

						$retval = $api->campaignContent($cid);
						echo "<input style='position:relative;left:10px' type='textbox' name='title' value='" . $_COOKIE['ct'] . "'><br>";
						echo '<label for="html">HTML: </label><textarea name="html" id="html">' . $retval['html'] . '</textarea>';
						echo '<label for="text">Text: </label><textarea name="text" id="text">' . $retval['text'] . '</textarea>';
					?>
					<br>
					<input id='modify' type="submit" value='Modify'>
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
