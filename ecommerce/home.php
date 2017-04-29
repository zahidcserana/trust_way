<?php
	session_start();
	

	if(!isset($_SESSION['user_name']))
	{
	    header("Location: index.php");
	    exit;
	}

	include_once('include/top.php');
	echo "Hi ".$_SESSION['user_name'];
	echo "<br/>Your User_id: ".$_SESSION['user_id'];
	require_once("include/footer.php");
?>

