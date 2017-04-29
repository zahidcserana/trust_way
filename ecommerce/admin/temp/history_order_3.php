<?php
	require_once("include/header.php");
	require_once("/../class/database.class.php");
	require_once dirname(__FILE__).'/../class/products.class.php';
	require_once dirname(__FILE__).'/../class/order.class.php';
	require_once dirname(__FILE__).'/../class/order_details.class.php';
?>
<?php
	session_start();
	if($_SESSION['user_id'] == '')
	{
	    header("Location: index.php");
	    exit;
	}

 	$orderHistoryObj = new Order();
    	$totalOrderObj = new OrderDetail();
	$orderHistory = $orderHistoryObj->GetOrderHistory();
      $orderIds= array();
      echo "order History:</br>";
      foreach ($orderHistory as $key => $value) 
      {
          $orderIds[] = $orderHistory[$key]['order_id'];
      }
      $id = array();
      for ($i=0; $i <count($orderIds) ; $i++) { 
		$orderId=$orderIds[$i];
	      $todaySell = $totalOrderObj->GetTotalOrder($orderId);
	      for ($j=0; $j <count($todaySell) ; $j++) { 
	            $id[] = $todaySell[$j]['id'];
	      }
      }
       echo "ID--ORDER_ID--PRODUCT_ID---QUANTITY</BR>";
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="lib/jquery.js"></script>
	<script src="dist/jquery.validate.js"></script>
	<p id="id_list"></p>
	<p id="order_id_list"></p>
	<p id="product_id_list"></p>

</head>
<body>
	
<script>
	var id = <?php echo json_encode($id) ?>;
	var numOfItem = id.length;
	var start = 0;
	var end = 10;
	GetOrderList(start,end);
	
	
	function DrawNextOrder(start,end)
	{
		
		if (end!=numOfItem) {
			start =end; 
			end+=10;
			if (end>numOfItem) {

				end=numOfItem;			
			}
		      GetOrderList(start,end);
		}
	}
	function DrawPrevOrder(start,end)
	{		
		end =start;
		start=start-10;
		
		if (end>=10) {
			GetOrderList(start,end);
		}
	      
	}
	function GetOrderList(start,end)
	{
		$("#id_list").html("")
	  	$("#order_id_list").html("")
	  	$("#product_id_list").html("")

		$( "#id_list" ).append( 'Id: ----------' )	
		$( "#order_id_list" ).append( 'OrderId: ----' )
		$( "#product_id_list" ).append( 'ProductId: ')
		
		$.ajax({
	        method: "GET",
	        url: "ajax_order_history.php",
	        data: { start: start, end: end}
	  	}).done(function( response ) 
	      {       
		        var jsonResponse = JSON.parse(response);
		        if(jsonResponse.success==false)
		        {
		          alert(message);
		          return;
		        }

		        var allOrder = jsonResponse.order; 
		        for (var i = 0; i < allOrder.length; i++) {
		        	var allId = allOrder[i].id;
		        	var allOrderId = allOrder[i].order_id;
		        	var allProductId = allOrder[i].product_id;
		        	
		        	$( "#id_list" ).append( allId )
		        	$( "#id_list" ).append( '------' )
		        	$( "#order_id_list" ).append( allOrderId )
		        	$( "#order_id_list" ).append( '------' )
		        	$( "#product_id_list" ).append( allProductId )
		        	$( "#product_id_list" ).append( '---' )
		        }		     
		});
		 	
		$(document).ready(function()
        	{       						
			$("#NextOrderButton").click(function(){
            		DrawNextOrder(start,end);
      		});
      		$("#PrevOrderButton").click(function(){
            		DrawPrevOrder(start,end);          
      		});
      	});
	}
</script>
<button id="PrevOrderButton"><<</button>
<button id="NextOrderButton">>></button>
</body>
</html>
