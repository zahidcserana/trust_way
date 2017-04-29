<?php
    include_once('include/top.php');
    require_once __DIR__."/class/database.class.php";
	require_once dirname(__FILE__).'/class/user_info.class.php';
	require_once dirname(__FILE__).'/class/token.class.php';

	$userIdObj = new Token();
	$userPassObj = new UserInfo();
	//$tokenActiveObj  = new Token();

	if(empty($_GET['token']))
	{
		$userIdObj->redirect('index.php');
	}

	if(isset($_GET['token']))
	{
		$code = $_GET['token'];
		$result= $userIdObj->GetUserId($code);
		//var_dump($result);
		$id = $result['user_id'];

		if($result)
		{
			if(isset($_POST['btn-reset-pass']))
			{
				$pass = $_POST['pass'];
				$cpass = $_POST['confirm-pass'];
				
				if($cpass!==$pass)
				{
					$msg = "<div class='alert alert-block'>
						  <button class='close' data-dismiss='alert'>&times;</button>
						  <strong>Sorry!</strong>  Password Doesn't match. 
						  </div>";
				}
				else
				{
					$status = 'Active';
					$password = md5($cpass);
					$userPassObj ->ResetPass($password,$id);
					$userIdObj->TokenStatusUpdate($status,$code);
					//$tokenActiveObj ->TokenStatusUpdate($code);
					$msg = "<div class='alert alert-success'>
						  <button class='close' data-dismiss='alert'>&times;</button>
						  Password Changed.
							</div>";
					header("refresh:5;index.php");
				}
			}	
		}
		else
		{
			$msg = "<div class='alert alert-success'>
					<button class='close' data-dismiss='alert'>&times;</button>
					No Account Found, Try again
					</div>";
					
		}
		
		
	}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Password Reset</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">   
  </head>
  <body id="login">
      <div class="container">
      	<div class='alert alert-success'>
			<strong>Hello !</strong>   you are here to reset your forgetton password.
		</div>
       	<form class="form-signin" method="post">
        		<h3 class="form-signin-heading">Password Reset.</h3><hr />
        		<?php
        			if(isset($msg))
        			{
        				echo $msg;
        				exit;
        			}
        		?>
        		<input type="password" class="input-block-level" placeholder="New Password" name="pass" required />
        		<input type="password" class="input-block-level" placeholder="Confirm New Password" name="confirm-pass" required />
     			<hr />
        		<button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Reset Your 	Password</button>
        
      	</form>

    	</div> 
    	<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>