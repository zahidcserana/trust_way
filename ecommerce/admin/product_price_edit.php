
<?php
	require_once("/../class/database.class.php");
	require_once dirname(__FILE__).'/../class/cart_details.class.php';
	require_once dirname(__FILE__).'/../class/cart.class.php';
	require_once dirname(__FILE__).'/../class/products.class.php';
	require_once dirname(__FILE__).'/../class/order.class.php';
	require_once dirname(__FILE__).'/../class/order_details.class.php';
	require_once("include/header.php");
?>
<?php
	session_start();

	if($_SESSION['user_id'] == '')
	{
	    header("Location: index.php");
	    exit;
	}

	$productId = $_POST['productId'];
	$price= $_POST['price'];	

	$productPriceObj = new ProductInfo();		
	$productPriceObj->PriceUpdate($price,$productId);
           
	
?>



