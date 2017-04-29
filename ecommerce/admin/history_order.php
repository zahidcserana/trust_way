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
	<p id="order_list"></p>
</head>
<body>
<div>	
<script>
	var id = <?php echo json_encode($id) ?>;
	var numOfItem = id.length;
	
	var start = numOfItem;
	var end = numOfItem-10;
	GetOrderList(start,end);
	function DrawNextOrder(start,end)
	{
		start =end; 
		end-=10;
		if (end<=0) {

			end=0;			
		}
	      GetOrderList(start,end);
	}
	function DrawPrevOrder(start,end)
	{		
		end =start;
		start=start+10;
		if (start<=numOfItem) {
			GetOrderList(start,end);
		}
	      
	}
	function GetOrderList(start,end)
	{
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
		     
			var listOfOrder='';
		      var allOrder = jsonResponse.order; 
		      for (var i = 0; i < allOrder.length; i++) 
		      {
		      	listOfOrder +='<table>';
		        	listOfOrder += '<tr>';

				listOfOrder += '<td> ' + '<b>';
				listOfOrder +=allOrder[i].id+'----';
				listOfOrder +=   '</td> '+ '<b>';
			
				listOfOrder += '<td> ' + '<b>';
				listOfOrder +=allOrder[i].order_id+'----------';
				listOfOrder +=   '</td> '+ '<b>';

				listOfOrder += '<td> ' + '<b>';
				listOfOrder +=allOrder[i].product_id+'----------';
				listOfOrder +=   '</td> '+ '<b>';


				listOfOrder += '<td> ' + '<b>';
				listOfOrder +=allOrder[i].quantity;
				listOfOrder +=   '</td> '+ '<b>';

				listOfOrder +='</tr>';
				listOfOrder += '</table>';
		      }		

		      $("#order_list").html(listOfOrder);     
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
