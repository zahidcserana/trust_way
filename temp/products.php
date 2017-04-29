<?php
	include('include/top.php');
	require_once('../class/connecti.class.php');
	require_once dirname(__FILE__).'/../class/products.class.php';

	$productObj = new ProductInfo();
	$product= $productObj->GetAllProduct();
?>
<?php
	foreach ($product as $key => $value) 
	{
		echo <<<EOM

			<div class="product_item">
				<div class="product_image"><a href="product_details.php?productId={$product[$key]["id"]}"><img src="{$product[$key]["image"]}"width="300" height="200"></a></div>
				<div>Category :{$product[$key]["category"]}</div>
				<div>Product Id: {$product[$key]["id"]}</div>
				<div>Price : \${$product[$key]["price"]}</div>
				<div><input type="text" id="number_{$product[$key]["id"]}" name="quantity" value="1" size="2" />
				<button class="addToCart" value="{$product[$key]["id"]}" >Add To Cart</button></div>			
EOM;
	}
if(isset($_SESSION['username']))
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
		
<?php
	include('include/footer.php');
?>