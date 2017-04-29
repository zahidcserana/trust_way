<?php
    include_once('include/top.php');
	require_once __DIR__."/class/database.class.php";
	require_once dirname(__FILE__).'/class/user_info.class.php';
	require_once dirname(__FILE__).'/class/token.class.php';

	$userActivationObj = new UserInfo();
	$checkTokenObj = new Token();
	
	//$token ='55abaf20575509ebf16889977990df19';
	$token = $_GET['token'];
	$id = $_GET['Id'];
	$checkToken = $checkTokenObj->CheckToken($token);

	$validiteTime = $checkToken['valid_time'];
	$status = $checkToken['status'];

	$currentTime = date("Y-m-d H:i:s", time());; 
	$validityTime = $validiteTime;
	$validity = strtotime($validityTime);
	$current = strtotime($currentTime);
	$checkValidityTime = round($validity - $current);
	//echo $checkValidityTime;
	if (!$checkToken) {
		echo "Invalid Token";
	}
	elseif (!$checkValidityTime) {
		echo "Time expired!";
	}
	elseif ($status=='Active') {
		echo "Already used!";
	}
	else
	{

		$status = 'Active';
		$updateStatus = $checkTokenObj->TokenStatusUpdate($status,$token);
		$userActivationObj->UserActivation($status,$id);
		if(!$updateStatus)
		{
		    echo '<div>Your account is now active. You may now <a href="login.php">Log in</a></div>';
		}
		else
		{
		    echo "Some error occur.";
		}

	}
	
	
?>