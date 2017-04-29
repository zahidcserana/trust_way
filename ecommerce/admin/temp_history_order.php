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
    	$orderDetailHistoryObj = new OrderDetail();
    	$todayOrderObj = new OrderDetail();
	$orderHistory = $orderHistoryObj->GetOrderHistory();
      $orderIds= array();
      echo "order History:</br>";
      echo "ORDER_ID--CUSTOMER_ID-------DATE</BR>";
      
      foreach ($orderHistory as $key => $value) 
      {
          $orderIds[] = $orderHistory[$key]['order_id'];
          echo $orderHistory[$key]['order_id']."-----------------".
          $orderHistory[$key]['customer_id']."---------".$orderHistory[$key]['created_at']."</br>";
      }

      echo "</br>";
      $total = 0;
      $id = array();
      $Oid = array();
      $pId = array();
      $pQuan = array();
      for ($i=0; $i <count($orderIds) ; $i++) { 
		$orderId=$orderIds[$i];
	      $todaySell = $todayOrderObj->GetTodayProductSell($orderId);
	      for ($j=0; $j <count($todaySell) ; $j++) { 
	            $id[] = $todaySell[$j]['id'];
	            $Oid[] = $todaySell[$j]['order_id'];
	            $pId[] = $todaySell[$j]['product_id'];
	            $pQuan[] = $todaySell[$j]['quantity'];
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
	
<script>
	var id = <?php echo json_encode($id) ?>;
	var numOfItem = id.length;
	var orderId = <?php echo json_encode($Oid) ?>;
	var productId = <?php echo json_encode($pId) ?>;
	var pQuantity = <?php echo json_encode($pQuan) ?>;
	numOfItem--;
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
		
		var listOfOrder='';
		for (var i = start; i >=end; i--) {
			
			listOfOrder +='<table>';

			listOfOrder += '<tr>';

			listOfOrder += '<td> ' + '<b>';
			listOfOrder +=id[i]+'----';
			listOfOrder +=   '</td> '+ '<b>';
		
			listOfOrder += '<td> ' + '<b>';
			listOfOrder +=orderId[i]+'----------';
			listOfOrder +=   '</td> '+ '<b>';

			listOfOrder += '<td> ' + '<b>';
			listOfOrder +=productId[i]+'----------';
			listOfOrder +=   '</td> '+ '<b>';

			listOfOrder += '<td> ' + '<b>';
			listOfOrder +=pQuantity[i];
			listOfOrder +=   '</td> '+ '<b>';
				
			listOfOrder +='</tr>';
			listOfOrder += '</table>';
			
		}
		$("#order_list").html(listOfOrder);

		$(document).ready(function()
        	{
          		$("#order_list").html(listOfOrder);         				
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
