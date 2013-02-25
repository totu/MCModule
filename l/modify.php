<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Lists - Modify</title>
    <meta name="description" content>
    <meta name="viewport" content="width=device-width">
    
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css"
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
          <div id='h' class="tab">Home</div>
          <div id='l' class="tab">Lists</div>
          <div id='c' class="tab">Campaigns</div>
        </div>
        <div id="main">
    
			<?php
				require_once "./filters.inc.php";
				
				// form for Batch update. You can choose filter from dropdown list
				echo '<h1 style="margin-left:30px;">' . $_COOKIE['lt'] . '</h1>';
				echo '<form name="batch" action="addToList.php" method="post">';
				echo '<select style=" width:100px; margin-left:30px;" name="formFilter">';
				foreach ($filters as $key => $value ){
					echo '<option value=' .  $key . '>' . ucfirst($key) . '</option>';
				}
				
				echo "</select> <br> <br>";
				echo '<input style=" width:20px; margin-left:30px;" type="checkbox" name="options[]" value="optin">Send optin emails<br>';
				echo '<input style=" width:20px; margin-left:30px;" type="checkbox" name="options[]" value="up_exist">Update currently subscribed users<br>';
				echo '<input style=" width:20px; margin-left:30px;" type="checkbox" name="options[]" value="replace_int">Replace interests<br>';
				
				echo "<input style='float:right; width:180px; border-radius:5px; background:#47c9e9; color:#fff; text-shadow:1px 1px 4px #000; height:30px;' id='up_batch' type='submit' value='Update'>";
				echo "</form>";
				
			?>
    
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
			<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
			<script src="../js/plugins.js"></script>
			<script src="./js/main.js"></script>
		</div>
	    </div>
	 </div>
	</body>
</html>