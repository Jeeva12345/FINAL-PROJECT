<?php
	include('session.php');
	
	$connection_status = get_ini_value("keywords", "connection_status");
	if($connection_status != 1)
	{		
		echo '<!DOCTYPE html>';
		echo '<html>';
		echo '<script language="javascript">';
		echo 'alert("Connection to Device - Failed")';
		echo '</script>';
		echo '</html>';
	}
?>
<!DOCTYPE html>
<html >

<head>
	<meta charset="UTF-8">
	<title>Barcode Part Management</title>	
	
	<link rel="stylesheet" href="css/reset.min.css">
	<link rel="stylesheet" href="css/style.php?theme=purple">
	<link rel="stylesheet" href="css/modular.css">
	
	<!-------------------------------------
	//Auto Reload Page using AJAX 
	-------------------------------------->
	<script src="js/jquery.min.js"></script>
	<script src="js/ajax-functions.js"></script>
	
	<script type="text/javascript"> 
	function delay(ms){
	   var start = new Date().getTime();
	   var end = start;
	   while(end < start + ms) {
		 end = new Date().getTime();
	  }
	}
	$(document).ready(function() 
	{
		function functionToLoadFile() 
		{
			jQuery.get('getVariables.php?keywords>refresh=1', function(data) 
			{
				if (data == "1") 
				{
					document.getElementById('buzzer').play();
					delay(1000);
					$(location).attr('href', 'app.php');
					jQuery.get('setVariables.php?keywords>refresh=0');
				}
				setTimeout(functionToLoadFile, 5000);
			});
		}

		setTimeout(functionToLoadFile, 10);
	});

	</script>
	
	<!-------------------------------------
	//Auto Reload Page using AJAX - END
	-------------------------------------->
	
</head>

<body>
	<div class="cta" style="float: right; padding-top: 7px;">
		<span class="button-small">Welcome <?= ucfirst($_SESSION['normal_user']). " "; ?><em><a href="logout.php">Logout</a></em></span>
	</div>
	<div class="pen-title">
		<h1>Barcode Part Management</h1>
	</div>
	<audio id="buzzer"><source src="beep.ogg" type="audio/ogg"></audio>
	<div class="form-module form-module-large">
		<ul class="top-menu">
			<li><a href="app.php">Home</a></li>
			<li><a class="active" href="add_part.php">Add Part</a></li>
			<li class="fr"><a class="side-menu" href="editDB.php" target="_blank"><img src="images/edit_db.png">Edit DB</a></li>
			<li class="fr"><a class="side-menu" href="viewDB.php" target="_blank"><img src="images/database.png">View DB</a></li>
			<li class="fr"><a class="side-menu" href="checkConnection.php"><img src="images/connection.png">Check Connection</a></li>

		</ul>
		<div class="content">
			<?php
				if(isset($_POST['form_submit']))
				{
					set_ini_value("part_code", $_POST['tag_id'], $_POST['part_code']);
					set_ini_value("part_description", $_POST['tag_id'], $_POST['part_description']);
					set_ini_value("part_uom", $_POST['tag_id'], $_POST['part_uom']);
					set_ini_value("quantity", $_POST['tag_id'], $_POST['quantity']);
				}
			?>
			<h2 class="headings">Form Functionality</h2>
			<form action="" method="POST">
				<label style="width: 160px; display: inline-block;">Barcode</label><input class="small-width" type="text" name="tag_id" required=""><br><br>
				<label style="width: 160px; display: inline-block;">Part Code</label><input class="small-width" type="text" name="part_code" required=""><br><br>
				<label style="width: 160px; display: inline-block;">Description</label><input class="small-width" type="text" name="part_description" required=""><br><br>
				<label style="width: 160px; display: inline-block;">UOM</label><input class="small-width" type="text" name="part_uom" required=""><br><br>
				<label style="width: 160px; display: inline-block;">Quantity</label><input class="small-width" type="text" name="quantity" required=""><br><br>
				<input class="small-width" type="submit" name="form_submit" value="Add Part">
			</form>
			<div style="clear: both;"> </div>
			<br/>
		</div>
		
	<script src='js/jquery.min.js'></script>
	<script src="js/canvas-data.php?hour_1=hour_blood_pulse&hour_2=hour_body_temperature&day_1=day_blood_pulse&day_2=day_body_temperature"></script>
	<script src="js/canvasjs.min.js"></script>

</body>
</html>