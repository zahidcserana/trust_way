<?php
    	require_once("/../class/database.class.php");
    	require_once dirname(__FILE__).'/../class/admin.class.php';
?>
<?php
	$adminInfoObj = new AdminInfo();

	if(isset($_POST['submit']))
	{
		$userName = trim($_POST['userName']);
		$password = trim($_POST['password']);
		$password = md5($password);

		$adminInfo = $adminInfoObj->GetAdminInfo($userName,$password);
		$adminId = $adminInfo['user_id'];
		$status = $adminInfo['status'];
		
		if ($adminInfo && $status=='verified') {
			session_start();
			$_SESSION['user_id']=$adminId;
			header("Location: admin.php");
            	exit;
		}
		else
		{
			header("Location: index.php");
            	exit;
		}

	}
	
?>
<!DOCTYPE>
<html >
<head>
    <meta  charset="utf-8" />
    <title>Login</title>
    
</head>
<body>
	<div class="login_form" align="center">
	    	<form action="" method="post" >
		    	<table>   
			      <tr>
			          <td><label for="userName">User Name:</label></td>
			          <td><input name="userName" type="text" id="userName" size="30"/></td>
			      </tr>
			      <tr>
			          <td><label for="password">Password:</label></td>
			          <td><input name="password" type="password" id="password" size="30"/></td>
			      </tr>
		      </table>
		
		      <p>
		          <input name="submit" type="submit" value="Submit"/>
		      </p>
		</form>
	</div>
</body>
</html>