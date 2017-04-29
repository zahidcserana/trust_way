<?php 
    require_once('../class/connecti.class.php');
    require_once('../class/users.class.php');
    include_once('include/top.php');
    
    $msg = '';
 	$userObj = new User();
 	$userList = $userObj->GetUserList();
?>

<?php echo $msg; ?>
   	
    </div>
	<div class="table-responsive">
	    	<table class="table table-bordered table-hover">
				<thead>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Action</th>
				</thead>
				<tbody>
				<?php
				foreach ($userList as $user) 
				{
					echo <<<EOM
					<tr>
						<td>{$user['id']}</td>
						<td>{$user['username']}</td>
						<td>{$user['email']}</td>
						<td> <a href="user_details.php?id={$user['id']}">Details</a> </td>
					</tr>                                

EOM;
				}
				?>
					
				</tbody>
			</table>
		
	</div>

<?php
  include('include/footer.php');
?>