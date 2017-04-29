<?php
	require_once("/../class/database.class.php");
    	require_once dirname(__FILE__).'/../class/admin.class.php';
    	require_once dirname(__FILE__).'/../class/products.class.php';
?>
<?php
	session_start();
	if($_SESSION['user_id'] == '')
		{
		    header("Location: index.php");
		    exit;
		}
	require_once("include/header.php");
	$productListObj = new ProductInfo();
	$productList = $productListObj->GetProductList();
	/*echo "<pre>";
	var_dump($productList[0][1]);
	echo "<pre>";*/
	//echo " Id----  Category----- Price</br>";
	$pId = array();
	$category = array();
	$pPrice = array();
	for ($i=0; $i <count($productList) ; $i++) { 
		$pId[] = $productList[$i]['product_id'];
		$category[] = $productList[$i]['category'];
		$pPrice[] = $productList[$i]['price'];
	}
	?>
	<div align="center">
		<table width=250 cellpadding="5">
			<tr>
				<th>Select</th>
				<th>P-Id</th>
				<th>Category</th>
				<th>Price</th>
				
			</tr>
		</table>
	</div>
	<?php
	
	for ($i=0; $i <count($productList) ; $i++)
	{
		echo <<<EOM
		<div align="center">
			<table width=250 cellpadding="5">
				<tr>
					<td>
					   <form method="post" action="product_details.php?productId={$pId[$i]}">
			                   <input name="submit" type="submit" value="Edit"/> 
		                     </form>
					</td>
					<td>{$pId[$i]}</td>
					<td>{$category[$i]}</td>
					<td>{$pPrice[$i]}</td>
				</tr>
			</table>			
		</div>
EOM;
	}
	echo "</br>";
	if($_POST)
	{
		$productId = trim($_POST['productId']);
		$category = trim($_POST['category']);
		$price = trim($_POST['price']);
		$imageUpload = trim($_POST['imageUpload']);
		$imagePah = "images/{$imageUpload}";
		$newProduct = $productListObj->InsertNewProduct($productId,$category,$price,$imagePah);
		if (!$newProduct) {
			//$msg = "Success to added new product!";
			header("Location: products.php");
		}
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<category></category>
</head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
<body>
	<div class="product_form" align="center">
    		<form action="products.php" method="post" >
		    	<table>   
			      <tr>
			          <td><label for="productId">Product Id:</label></td>
			          <td><input name="productId" type="text" id="productId" size="30"/></td>
			      </tr>
			      <tr>
			          <td><label for="category">category:</label></td>
			          <td><input name="category" type="category" id="category" size="30"/></td>
			      </tr>
			      <tr>
			          <td><label for="imageUpload">Upload image:</label></td>
    				    <td><input type="file" name="imageUpload" id="fileToUpload" size="30"></td>
			      </tr>
			      <tr>
			          <td><label for="price">Price:</label></td>
			          <td><input name="price" type="price" id="price" size="30"/></td>
			      </tr>
		    	</table>
			        <p>
			            <input name="submit" type="submit" value="Add New"/>
			        </p>
	      </form>
	</div>
</body>
</html>