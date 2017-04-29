<?php
	
	require_once('../class/connecti.class.php');
	require_once dirname(__FILE__).'/../class/products.class.php';
	//require_once dirname(__FILE__).'/class/cart_details.class.php';
	$productId = $_GET['productId'];
	$_SESSION['product_id']=$productId;
	$productObj = new ProductInfo();
	session_start();
	if(empty($_SESSION['username']))
	{
	    header("Location: index.php");
	    exit;
	}
	echo "Hi ".$_SESSION['username']."</br>";
	echo "You Choose now : ".$productId;
	$product= $productObj->GetProductImg($productId);
	
	//echo "</br>".$product['location']."</br>";
	//echo "</br>Price: ".$product['price']."</br>";
	include('include/top.php');

	echo <<<EOM

	<div class="table-responsive">
    	<table class="table table-bordered table-hover">
		 	<thead>
	 			<th>ID</th>
		 		<th>CATEGORY</th>
		 		<th>PRICE</th>
		 		<th>PICTURE</th>
		 	</thead>
		 	<tbody>
		 		<tr>
		 			<td>{$product['id']}</td>
		 			<td>{$product['category']}</td>
		 			<td>{$product['price']}</td>
		 			<td><img src="{$product["image"]}"width="500" height="300"></td>
		 		</tr>
		 	</tbody>
	 	</table>

	</div>


EOM;

?>
 