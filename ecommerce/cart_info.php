<?php
	session_start();
    include_once('include/top.php');
	require_once __DIR__."/class/database.class.php";
	require_once dirname(__FILE__).'/class/cart_details.class.php';
	require_once dirname(__FILE__).'/class/cart.class.php';
	require_once dirname(__FILE__).'/class/products.class.php';
	require_once dirname(__FILE__).'/class/order.class.php';
	require_once dirname(__FILE__).'/class/order_details.class.php';
	//require_once("include/header.php");
	
	$productId = $_POST['productId'];
	$quantity= $_POST['quantity'];
	
	$_SESSION['productId']=$productId;
	$_SESSION['quantity']=$quantity;
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
	echo "Hi ".$_SESSION['user_name']."</br>";
	$sessionId = $_SESSION['session_id'];
	$cartIds =$cartIdObj->GetCartId($sessionId ,$customerId);	
	
	if ($cartIds) 
	{
		$cartId=$cartIds['cart_id'];
		echo "Your current Cart Id : ".$cartId;
	}
	else
	{
		$result= $cartIdObj->CreateCartId($customerId, $sessionId);
		$cartIds =$cartIdObj->GetCartId($sessionId ,$customerId);
		$cartId=$cartIds['cart_id'];
		echo "Your new Cart Id : ".$cartId;
	}
	
	
	$_SESSION['cartId']=$cartId;
	$prodId = $productId;

	$quantityValue= $addToCartObj->GetProductInfo($cartId, $prodId);
	//var_dump($quantityValue);
	if ($quantityValue) 
	{
		$quantity += $quantityValue['quantity'] ;
		$addToCartObj->CartUpdate($quantity,$cartId,$prodId);
	}
	else
	{
		//echo $cartId;
		$addToCartObj->AddToCart($prodId,$quantity,$cartId);

	}
	//header("Location: cart_details.php");
           
	
?>



