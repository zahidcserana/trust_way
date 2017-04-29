<?php
	session_start();
    

    if(!isset($_SESSION['user_name']))
	{
	    header("Location: login.php");
	    exit;
	}
	include_once('include/top.php');
	echo "Hi ".$_SESSION['user_name'];
?>


<?php
  include('include/footer.php');
?>