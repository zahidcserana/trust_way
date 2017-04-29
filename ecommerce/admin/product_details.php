<?php
	require_once("/../class/database.class.php");
	require_once dirname(__FILE__).'/../class/cart_details.class.php';
	require_once dirname(__FILE__).'/../class/products.class.php';
	require_once("include/header.php");
?>
<?php
	session_start();
	if($_SESSION['user_id'] == '')
	{
	    header("Location: index.php");
	    exit;
	}

	$productId = $_GET['productId'];
	$_SESSION['product_id']=$productId;

	$productObj = new ProductInfo();
	$cartIdObj = new CartDetails();

	//echo "Hi ".$_SESSION['user_name']."</br>";
	echo "You Choose now :</br> ";
	$product= $productObj->GetProductImg($productId);
	
	//echo "</br>".$product['location']."</br>";
	echo "Product Id :: ".$product['product_id']."</br>";
	echo "Price : ".$product['price']."</br>";
	echo "Category : ".$product['category']."</br>";
?>	


<!DOCTYPE html>
<html>
<head>
	<title>Buy Page</title>
	<script src="lib/jquery.js"></script>
	<script src="dist/jquery.validate.js"></script>
	<h2 align="center">
		
</head>
<body>
<?php
	echo <<<EOM

	<img src="../{$product["location"]}"width="300" height="200">	
	<div>
	<button class="priceEdit" value="{$productId}" >Price Edit</button>
	<input type="text" id="number_{$productId}" name="quantity_{$productId}" value="" size="2" />	
	</br>
	<button class="categoryEdit" value="{$productId}" >Category Edit</button>
	<input type="text" id="category_{$productId}" name="quantity_{$productId}" value="" size="2" />
	</br>
	<button class="fileEdit" value="{$productId}" >Image Edit</button>
	<input type="file" id="fileToUpload_{$productId}" name="quantity_{$productId}" value="file" size="5" />
	
    	
	</div>
EOM;
?>

	<script>
		$(".priceEdit").click(function()
		{	
			var productId = $(this).attr("value");
			var str1 = "#number_";
			var str2 = $(this).attr("value");
			var concateStr = str1.concat(str2);
			var price = $(concateStr).val();
			if (price=='') {
				alert("You have to put a value!!");
			}
			else
			{
				$.post( "product_price_edit.php", { productId: productId, price: price })
					.done(function( data ) {
					    alert( "Price has been updated!" );
				});
			}
		});
	</script>
	<script>
		$(".categoryEdit").click(function()
		{	
			var productId = $(this).attr("value");
			var str1 = "#category_";
			var str2 = $(this).attr("value");
			var concateStr = str1.concat(str2);
			var category = $(concateStr).val();
			if (category=='') {
				alert("You have to put a value!!");
			}
			else
			{
				$.post( "product_cat_edit.php", { productId: productId, category: category })
					.done(function( data ) {
					    alert( "Category has been updated!" );
				});
			}
		});

	</script>
	<script>
		$(".fileEdit").click(function()
		{	
			var productId = $(this).attr("value");
			var str1 = "#fileToUpload_";
			var str2 = $(this).attr("value");
			var concateStr = str1.concat(str2);
			var img = $(concateStr).val();
			var img = img.replace("C:\\fakepath\\", "");
			if (img=='') {
				alert("You have to choose an image!!");
			}
			else
			{
				var imgUrl = "images/".concat(img);
				$.post( "product_image_edit.php", { productId: productId, imgUrl: imgUrl })
				.done(function( data ) {
				    alert( "Image has been changed!" );
				});
			}
			
		});
	</script>

</h2>
</body>
</html>
