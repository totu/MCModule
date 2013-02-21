<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Lists</title>
    <meta name="description" content>
    <meta name="viewport" content="width=device-width">
    
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css"
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
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
    
    // This file is for manually adding customers to db.

      // API key : 2c1ba739504ba2364a7111a8d2231fe0-us6
      
      // API CALL FORMAT: https://us6.api.mailchimp.com/1.3/?output=OUTPUT_FORMAT&method=SOME-METHOD&[other parameters]
    
        // add to list: listBatchSubscribe(string apikey, string id, array batch,
        // boolean double_optin, boolean update_existing, boolean replace_interests)
      
      
      function showLists() {
      
        require_once 'inc/MCAPI.class.php'; // MailChimpAPI
        require_once 'inc/config.inc.php'; // contains apikey
      
        $api = new MCAPI($apikey);

        $retval = $api->lists(); // get lists() from MCAPI.class
        
        // ERRORS
        if ($api->errorCode){
        echo "Unable to load lists()!";
        echo "\n\tCode=".$api->errorCode;
        echo "\n\tMsg=".$api->errorMessage."\n";
      } else {
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
          <img title='Delete' class='mo' id='d" . $counter . "' src='img/delete.png' alt='Delete'/>
          <img title='Modify' class='mo' id='m" . $counter . "' src='img/modify.png' alt='Modify'/>
          <img title='Statistics' class='mo' id='s" . $counter . "' src='img/statistics.png' alt='Statistics'/>
          </td></tr>";
        }
        echo "</table><br>";
        echo "Lists that matched:".$retval['total']."<br>";
        echo "Lists returned:".sizeof($retval['data'])."<br>";
      }}
      
      showLists();
      /*
      function readCustomers() {
        $con = mysql_connect("localhost","testi","");
      if (!$con)
      {
      die('Could not connect: ' . mysql_error());
      }
      
      // Select database php_testi which contains customer data.
      mysql_select_db("php_testi", $con);
      
      // Get customers data and echo it
      $customers = mysql_query("SELECT * FROM Customers");
      
      // echo customers Name+Email
      while( $row = mysql_fetch_array($customers) )
      {
      echo $row['Name'] . " " . $row['Email'];
      echo "<br>";
      }

      mysql_close($con);
      }
      
      echo "Customers: <br>";
      */
    
    ?>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
      var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
      (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
      s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
	</body>
</html>