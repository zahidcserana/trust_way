
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
	$productId = $_POST['productId'];
	$category= $_POST['category'];	
?>
<?php
	$productPriceObj = new ProductInfo();
	
	if($_SESSION['user_name'] == '')
	{
	    header("Location: index.php");
	    exit;
	}
		
	$productPriceObj->CategoryUpdate($category,$productId);
           
	
?>



