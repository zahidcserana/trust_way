<?php
	session_start();
    include_once('include/top.php');
	require_once __DIR__."/class/database.class.php";
	require_once dirname(__FILE__).'/class/cart_details.class.php';
	require_once dirname(__FILE__).'/class/products.class.php';
	//require_once("include/header.php");

	$productObj = new ProductInfo();
	$cartIdObj = new CartDetails();	
	$product= $productObj->GetAllProduct();
	
	echo "</br>";
?>
<h2 align="center">Choice your product</h2>
<script src="lib/jquery.js"></script>
<script src="dist/jquery.validate.js"></script>
		
<?php
	foreach ($product as $key => $value) 
	{
		echo <<<EOM
		<div class="container-fluid">
		  	<div class="row">
				<div class="product_image col-sm-5"><a href="product_details.php?productId={$product[$key]["product_id"]}"><img src="{$product[$key]["location"]}"width="300" height="200"></a></div>
				<div class="product_image col-sm-5">
					<div>Category :{$product[$key]["category"]}</div>
					<div>Product Id: {$product[$key]["product_id"]}</div>
					<div>Price : \${$product[$key]["price"]}</div>
					<div><input type="text" id="number_{$product[$key]["product_id"]}" name="quantity" value="1" size="2" />
					<button class="addToCart" value="{$product[$key]["product_id"]}" >Add To Cart</button></div>
				</div>		
		 	</div>
		</div>
EOM;
	}
	

	if(isset($_SESSION['user_name']))
	{
?>
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
<?php
	}
	else
	{	
?>
		<script>
			$(".addToCart").click(function()
			{	
				alert('Please log in!');
			});
		</script>
<?php
	}
?>

<?php require_once("include/footer.php"); ?>