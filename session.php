<?php
    date_default_timezone_set('Asia/Kolkata');
	
	include('file_functions.php');
	
	session_start();
	
	if(!isset($_SESSION['normal_user']))
	{
		header("location:index.php");
	}
?>