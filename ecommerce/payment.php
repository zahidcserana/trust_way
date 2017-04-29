<?php
	session_start();
    include_once('include/top.php');
	//require_once("include/customer.php");
	//require_once("class/database.class.php");
	//require_once dirname(__FILE__).'/class/cart_details.class.php';
	//require_once dirname(__FILE__).'/class/cart.class.php';
	//require_once dirname(__FILE__).'/class/products.class.php';
	//require_once dirname(__FILE__).'/class/order.class.php';
	//require_once dirname(__FILE__).'/class/order_details.class.php';

	$customerId= $_SESSION['user_id'];

	if(!isset($_SESSION['user_name']))
	{
	    header("Location: index.php");
	    exit;
	}

	if(isset($_POST['submit']))
	{
		?><script>
		alert("Your order is submitted!");
		</script>
		<?php
		//header("Location: product_choose.php");
	    	//exit;
		//$sellsOrderObj->CreateSellsId($customerId);
		//$sellsOrderObj->GetSellsId($customerId);
		//var_dump($sellsOrderObj);

	}
?>

<div align="center">
	<h3>Payment here</h3>
	<h3>Enter your correct information</h3>

	<form action="" method="post">
		<table>
			<tr>
				<td>Name:</td>
				<td><input type="text" name="name" required></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input type="text" name="email" required></td>
			</tr>
			<tr>
				<td>Card Id:</td>
				<td><input type="text" name="card_id" required></td>
			</tr>
		</table>
		 	<p>
            	<input class="submit" type="submit" value="Pay Now" name="submit">
        		</p>
	</form>
</div>



<?php require_once("include/footer.php"); ?>