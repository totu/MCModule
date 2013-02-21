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

      <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="css/main.css">
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
          require_once 'inc/MCAPI.class.php';
          require_once 'inc/config.inc.php'; //contains apikey

          $api = new MCAPI($apikey);
          $lval = $api->lists();
          if ($api->errorCode){
            echo "Unable to load lists()!";
            echo "<br>Code=".$api->errorCode;
            echo "<br>Msg=".$api->errorMessage."<br>";
          } else {
            $lid = array();
            $lname = array();
            foreach ($lval['data'] as $list){
              array_push($lid,$list['id']);
              array_push($lname,$list['name']);				
            }
          }
          $retval = $api->campaigns();

          if ($api->errorCode){
            echo "Unable to Pull list of Campaign!";
            echo "\n\tCode=".$api->errorCode;
            echo "\n\tMsg=".$api->errorMessage."\n";
          } else {
            echo "<table><tr>
            <td>Name</td>
            <td>ID</td>
            <td>List in use</td>
            <td>Status</td>
            <td>Type</td>
            <td>Last time send</td>
            <td>Optiot</td>
            </tr>";
            $counter = 0;
            foreach($retval['data'] as $c){
              $counter++;
              
              if ($c['send_time'] != null) {
                $t = explode(" ",$c['send_time']);
                $t = explode("-",$t[0]);
                $num = (int)$t[1];
                switch ($num) {
                  case 1:
                    $m = 'Jan';
                  case 2:
                    $m = 'Feb';
                  case 3:
                    $m = 'Mar';
                  case 4:
                    $m = 'Apr';
                  case 5:
                    $m = 'May';
                  case 6:
                    $m = 'Jun';
                  case 7:
                    $m = 'Jul';
                  case 8:
                    $m = 'Aug';
                  case 9:
                    $m = 'Sep';
                  case 10:
                    $m = 'Oct';
                  case 11:
                    $m = 'Nov';
                  case 12:
                    $m = 'Dec';
                }
                $date = $t[2] . " " . $m . " " . $t[0];
              } else {
                $date = "";
              }
              
              echo "<tr><td>" . ucfirst($c['title']) . "</td><td>" . $c['id'] . "</td>";
              echo "<td>" . ucfirst($lname[array_search($c['list_id'], $lid)]) . "</td>";
              echo "<td>" . ucfirst($c['status']) . "</td><td>" . ucfirst($c['type']) . "</td>";
              echo "<td>" . $date . "</td>";
              echo "<td> 
              <input id='id" . $counter . "' type='hidden' name='id' value='" . $c['id'] . "'>
              <img title='Delete' class='mo' id='d" . $counter . "' src='img/delete.png' alt='Delete'/>
              <img title='Modify' class='mo' id='m" . $counter . "' src='img/modify.png' alt='Modify'/>
              <img title='Statistics' class='mo' id='s" . $counter . "' src='img/statistics.png' alt='Statistics'/>
              </td></tr>";
            }
            echo "</table><br>
            Found " . sizeof($retval['data']) . " Campaign(s).
            <input style='float:right;' id='new_c' type='button' value='Add a New Campaign'>";
          }

        ?>
        </div>
      </div>
    </div>

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
