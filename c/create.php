<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>New Campaign</title>
</head>
<body>
	<form action="createAPI.php" method='post'>
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
					echo "<select name='lid'>
							<option value='" . $list['id'] . "'>" . $list['name'] . "</option>
						</select>";
		
				}
			}
			?><br>
			<input type="textbox" name='subject' value='Newsletter Subject'><br>
			<input type="textbox" name='from_email' value='from e-mail'><br>
			<input type="textbox" name='from_name' value='from name'><br>
			<input type="textbox" name='analytics' value='Google analytics key'><br>
			<hr>
			<input type="textbox" name='title' value='Newslatter Title'><br>
			<textarea name="html" id="html" cols="30" rows="10">Some pretty html content *|UNSUB|* message
			</textarea>
			<textarea name="text" id="text" cols="30" rows="10">Text text text *|UNSUB|*
			</textarea>
		</select>
		<br>
		<input type="submit" value='Create a New Campaing!'><input type="button" value='Cancel'>
	</form>
</body>
</html>

