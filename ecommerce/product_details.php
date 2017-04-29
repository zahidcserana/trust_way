<?php
	session_start();
    include_once('include/top.php');
	require_once __DIR__."/class/database.class.php";
	require_once dirname(__FILE__).'/class/cart_details.class.php';
	require_once dirname(__FILE__).'/class/products.class.php';
	//require_once("include/header.php");
	
	$productId = $_GET['productId'];
	$_SESSION['product_id']=$productId;
	$productObj = new ProductInfo();
	$cartIdObj = new CartDetails();

	if(!isset($_SESSION['user_name']))
	{
	    header("Location: index.php");
	    exit;
	}
	echo "Hi ".$_SESSION['user_name']."</br>";
	echo "You Choose now : ".$productId;
	$product= $productObj->GetProductImg($productId);
	
	//echo "</br>".$product['location']."</br>";
	echo "</br>Price: ".$product['price']."</br>";
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Buy Page</title>
	<script src="lib/jquery.js"></script>
	<script src="dist/jquery.validate.js"></script>
	<h2 align="center">
	<img src="<?php echo $product["location"];?>"width="300" height="200">	
</head>
<body>
	<div><input type="text" id="number_<?php echo $productId;?>" name="quantity_<?php echo $productId;?>" value="1" size="2" />
	<button class="addToCart" value="<?php echo $productId;?>" >Add To Cart</button></div>

	<script>
		$(".addToCart").click(function()
		{	
			var productId = $(this).attr("value");
			var str1 = "#number_";
			var str2 = $(this).attr("value");
			var concateStr = str1.concat(str2);
			var quantity = $(concateStr).val();

			$.post( "cart_info.php", { productId: productId, quantity: quantity })
			   .done(function( data ) {
				alert( "Product has been added to cart!" );
			});
		});
	</script>
	

</h2>
</body>
</html>


<?php require_once("include/footer.php"); ?>