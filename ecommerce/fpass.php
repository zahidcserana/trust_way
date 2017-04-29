<?php
	session_start();
    include_once('include/top.php');
	require_once __DIR__."/class/database.class.php";
	require_once dirname(__FILE__).'/class/user_info.class.php';
	require_once dirname(__FILE__).'/class/token.class.php';

	$userPassObj = new UserInfo();
	$tokenStatusObj = new Token();

	if($userPassObj->is_logged_in()!="")
	{
		$userPassObj->redirect('home.php');
	}

	if(isset($_POST['btnSubmit']))
	{
		$email = $_POST['txtemail'];
		$result=$userPassObj->GetUserId($email);
		
		if($result)
		{
			
			$id = $result['user_id'];
			//$tokenCode = $result[12];			
			$token = md5(uniqid(rand()));
			$token_type = 'forget_password';
			$tokenStatusObj->ForgetToken($id,$token_type,$token);
			//$userPassObj->UserPasswordReset($token,$email);
			
			$message= "Hello , $email
				     <br /><br />
				     We got requested to reset your password, if you do this then just click 
				     the following link to reset your password, if not just ignore this email,  
				     <br /><br />
				     Click Following Link To Reset Your Password 
				     <br /><br />
				     <a href='http://localhost/zahid/Current/secondEcommerce/
				     resetpass.php?token=$token'>click here 
				     to reset your password</a>
				     <br /><br />
				     thank you :)
				     ";
			$subject = "Password Reset";
			$userPassObj->send_mail($email,$message,$subject);

			$file = 'link.txt';
                	$current = "http://localhost/zahid/Current/secondEcommerce/resetpass.php?token=$token";
                	file_put_contents($file, $current);
			
			$msg = "<div class='alert alert-success'>
				  	<button class='close' data-dismiss='alert'>&times;</button>
				  	We've sent an email to $email. Please click on the password reset link in 
				  	the email to generate new password. 
				  </div>";
		}
		else
		{
			$msg = "<div class='alert alert-danger'>
					<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry!</strong>  this email not found. 
				  </div>";
		}
	}
?>

<?php
	if(isset($msg))
	{
		echo $msg;
		exit;
	}
	else
	{
		?>
		<div class='alert alert-info'>
			Please enter your email address. You will receive a link to create a new password 
			via email.!
		</div>  
		<?php
	}
?>

<!DOCTYPE html>
<html>
  <head>
    	<title>Forgot Password</title>
    	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    	<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    	<link href="assets/styles.css" rel="stylesheet" media="screen">
  </head>
  <body id="login">
    <div class="container">
      <form class="form-signin" method="post">
      	<h2 class="form-signin-heading">Forgot Password</h2><hr />
        
        	<input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
     	  	<hr />
        	<button class="btn btn-danger btn-primary" type="submit" name="btnSubmit">Generate new Password</button>
      </form>
    </div> 
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>