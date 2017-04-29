<?php
	require_once('../class/connecti.class.php');
	require_once('../class/users.class.php');
  	
  	session_start();
  	if (!empty($_SESSION['user_id'])) 
    {
        header("LOCATION:user_details.php");
    }
?>
<?php
	$msg = '';
	
	if (isset($_POST['submit'])) 
	{
		if (!$_POST['username'] ||!$_POST['email'] ||!$_POST['password'] ) 
		{
			$msg = '<div class="alert alert-warning">
					  <strong>Warning!</strong> Missing parameter .
					</div>';
		}
		else
		{
			$username = $_POST['username'];
			$email = $_POST['email'];
			$firstPassword = $_POST['password'];
			$confirmPassword = $_POST['password_confirm'];
			$password = md5($firstPassword);

			$userObj = new User();
			$registerChecking = $userObj->CheckIsExist($email);
			if ($registerChecking) 
			{
				$msg = '<div class="alert alert-warning">
						  <strong>Warning!</strong> Already exist.
						</div>';
			}
			else
			{
				if ($firstPassword!=$confirmPassword) 
				{
					$msg = '<div class="alert alert-warning">
							  <strong>Warning!</strong> Password does not match!.
							</div>';
				}
				else
				{
					$register = $userObj->AddUser($username,$email,$password);
					if ($register) 
					{
						$msg = '<div class="alert alert-success">
								  <strong>Success!</strong>Registration Successful.
								</div>';

					}
					else
					{
						$msg = '<div class="alert alert-warning">
							  <strong>Warning!</strong> Something wrong .
							</div>';
					}
				}
			}
			
		}
	}
?>
<?php 
	echo $msg; 
	include('include/top.php');
?>
<div class="f_section">
	<form action="" method="POST" role="form" class="form-horizontal" id="pd_forms" enctype="multipart/form-data">
		<div class="form-group">
			<label class="col-md-3 col-sm-4 col-xs-4 f_label">User Name</label>
			<div class="col-md-5 col-sm-6 col-xs-8">
				<input type="text" name="username" class="form-control" required/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 col-sm-4 col-xs-4 f_label">Email Address</label>
			<div class="col-md-5 col-sm-8 col-xs-8">
				<input type="email" name="email" class="form-control"  required/>
			</div>
		</div>
		<div class="form-group">
	      <label class="col-md-3 col-sm-4 col-xs-4 f_label" for="password">Password</label>
	      <div class="col-md-5 col-sm-8 col-xs-8">
	        <input type="password" id="password" name="password" placeholder="" class="form-control">
	      </div>
		</div>
		<div class="form-group">
	      <label class="col-md-3 col-sm-4 col-xs-4 f_label"  for="password_confirm">Password (Confirm)</label>
	      <div class="col-md-5 col-sm-8 col-xs-8">
	        <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="form-control">
	      </div>
	    </div>
		
		<div class="form-group">
			<div class="col-sm-4">
				<button type="submit" name="submit" class="btn btn-save-continue" id="save_pd_btn"><i class="fa fa-pencil"></i> Register</button>
			</div>
		</div>
	</form>
</div>

<?php
  include('include/footer.php');
?>
