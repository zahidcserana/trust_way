<?php
	session_start();
    
	require_once __DIR__."/class/database.class.php";
	require_once dirname(__FILE__).'/class/cart_details.class.php';
	require_once dirname(__FILE__).'/class/cart.class.php';
	require_once dirname(__FILE__).'/class/products.class.php';
	require_once dirname(__FILE__).'/class/order.class.php';
	require_once dirname(__FILE__).'/class/order_details.class.php';
	//require_once("include/header.php");

	$customerId= $_SESSION['user_id'];

	$cartIdObj = new CartId();
	$addToCartObj = new CartDetails();
	$cartDetailsObj = new CartDetails();
	$productPriceObj = new ProductInfo();
	$orderIdObj = new Order();
	$orderDetailsObj = new OrderDetail();

	if($_SESSION['user_name'] == '')
	{
	    header("Location: index.php");
	    exit;
	}
	if(!isset($_SESSION['cartId']))
	{
	    header("Location: product_choose.php");
	    exit;
	}
	include_once('include/top.php');
	//require_once("include/header.php");


	$cartId=$_SESSION['cartId'];
	echo "Hi ".$_SESSION['user_name']."</br>";
	
	if (isset($_GET['productRemove'])) {
		$pId =  $_GET['productRemove'];
		$cartDetailsObj->RemoveProduct($pId,$cartId);
		
	}
	
	$productInfo = $cartDetailsObj->GetProdIdQuantity($cartId);

	$pId = array();
	$pQuantity =  array();
	$pPrice =  array();
	for ($i=0; $i <count($productInfo) ; $i++) { 
		$pId[] = $productId = $productInfo[$i]['product_id'];
		$pQuantity[] = $ProdQuantity = $productInfo[$i]['quantity'];		
		$productPrice= $productPriceObj->GetProdPrice($productInfo[$i]['product_id']);
		$pPrice[] = $productPrice = $productPrice[0]['price'];		
	}
	echo "<br>You have bought now.<br></br>";
	$total = 0;
	
	for ($i=0; $i <count($pId) ; $i++) { 
		//echo $pId[$i]."----------".$pQuantity[$i]."------".$pPrice[$i]."</br>";
		$pTotal = $pQuantity[$i]*$pPrice[$i];
		 echo <<<EOM
		<div>
			<table class='table'>
				<thead>
					<th>Product_id</th>
					<th>Quantity</th>
					<th>Price</th>
					<th>Total</th>
					<th>Action</th>
				</thead>
				<tbody>
					<tr>
					<td>{$pId[$i]}</td>
					<td>{$pQuantity[$i]}</td>
					<td>{$pPrice[$i]}</td>
					<td>{$pTotal}</td>
					<td>
						<form method="post" action="cart_details.php?productRemove={$pId[$i]}">
						<input name="submit" type="submit" value="Delete"/> 
						</form>
					</td>
					</tr>
				</tbody>
			</table>
		</div>

EOM;
		?>
		
		<?php
		$total +=$pTotal;
	}
	echo "</br>You should pay : ".$total." $<br>";	
	
	if (isset($_POST['buy']))
	{
		$todayDate = date("Y-m-d");
		$orderIdObj->CreateOrderId($customerId,$todayDate);
		$orderIds =$orderIdObj->GetOrderId($customerId);
		$orderId = $orderIds['order_id'];
		for ($i=0; $i <count($pId) ; $i++) { 
			$orderDetailsObj->InsertToOrderDetails($orderId, $pId[$i], $pQuantity[$i], 
				$pPrice[$i]);
		}	
		//header("Location: payment.php");
		include_once('payment.php');
        //exit;	
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post" action="">
	<p>
          <input class="submit" type="submit" value="Buy Now" name="buy">
	</p>

</form>
</body>
</html>


<?php require_once("include/footer.php");?>




