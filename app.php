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
			<li><a class="active" href="app.php">Home</a></li>
			<li><a href="add_part.php">Add Part</a></li>
			<li class="fr"><a class="side-menu" href="editDB.php" target="_blank"><img src="images/edit_db.png">Edit DB</a></li>
			<li class="fr"><a class="side-menu" href="viewDB.php" target="_blank"><img src="images/database.png">View DB</a></li>
			<li class="fr"><a class="side-menu" href="checkConnection.php"><img src="images/connection.png">Check Connection</a></li>

		</ul>
		
		<div class="content">
			<h2 class="headings">Last Scanned Part</h2>
			<?php
			
				if(get_default_value('last_scanned_part_validation') == "1")
				{
					$last_scanned_part_validation_css = "green";
				}
				else
				{
					$last_scanned_part_validation_css = "red";
				}
				
				echo "<div style='float: left; margin: 0 30px 30px;'><h2>" . get_default_value('last_scanned_part') . "</h2> <br/> <br/>";
				echo "<a class='button-large $last_scanned_part_validation_css'><img src='images/time.png' alt=''>" . get_default_value('last_scanned_part_validation') . "</a></div>";
				
			?>
			<div style="clear: both;"> </div>
			<br/>
		</div>
		
		<div class="content">
			<h2 class="headings">Results in Table</h2>
			<div style="clear: both;"> </div>
			<table>
				<tr>
					<th>Barcode</th>
					<th>Partcode</th>
					<th>Description</th>
					<th>UOM</th>
					<th>Quantity</th>
					<th>Edit</th>
					<th>Clear</th>
				</tr>
				<?php
					function table_function_with_primary_key_part_code($key)
					{
						echo "<td>$key</td>"; 
						echo "<td>" . get_ini_value("part_code", "$key") . "</td>"; 
						echo "<td>" . get_ini_value("part_description", "$key") . "</td>";
						echo "<td>" . get_ini_value("part_uom", "$key") . "</td>";
						echo "<td>" . get_ini_value("quantity", "$key") . "</td>";
						echo "<td><a href='editEntry.php?tag_id=$key'><img src='images/edit.png'></a></td>";
						echo "<td><a href='deleteVariables.php?return_back=1&return_url=app.php&RECORD=$key'><img src='images/remove.png'></a></td></tr>";
					}
					foreach_ini_value("table_function_with_primary_key_part_code", "part_code");
				?>
			</table>
			<div style="clear: both;"> </div>
			<br/>
		</div>
		
	<script src='js/jquery.min.js'></script>
	<script src="js/canvasjs.min.js"></script>

</body>
</html>