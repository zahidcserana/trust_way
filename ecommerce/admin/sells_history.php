<?php
	require_once("include/header.php");
	require_once("/../class/database.class.php");
	require_once dirname(__FILE__).'/../class/cart_details.class.php';
	require_once dirname(__FILE__).'/../class/cart.class.php';
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
	if ($orderHistory) 
	{
		echo "Sells History:</br>";
		echo "ORDER_ID--CUSTOMER_ID-------DATE</BR>";
		
		foreach ($orderHistory as $key => $value) {
			echo $orderHistory[$key]['order_id']."-----------------".$orderHistory[$key]['customer_id']."---------".
			$orderHistory[$key]['created_at']."</br>";
		}
		$orderIds= array();
		echo "<br>";		
		$todayDate = date("Y-m-d");		
		$orderToday = $orderHistoryObj->GetTodayOrder($todayDate);
		if ($orderToday) 
		{	
			echo "Today Sells:</br>";
			echo "ORDER_ID--CUSTOMER_ID-------DATE</BR>";		
			for ($i=0; $i <count($orderToday) ; $i++) { 
				echo $orderToday[$i]['order_id']."-----------------".$orderToday[$i]['customer_id']."---------".$orderToday[$i]['created_at']."</br>";
				$orderIds[]=$orderToday[$i]['order_id'];
			}
			echo "</br>";
			$total = 0;
			$totalP = 0;
			$id = array();
			$pId = array();
			$pQuan = array();
			$pPrice = array();
			for ($i=0; $i <count($orderIds) ; $i++) { 
				$orderId=$orderIds[$i];
				$todaySell = $todayOrderObj->GetTodayProductSell($orderId);
				for ($j=0; $j <count($todaySell) ; $j++) { 
					$id[] = $todaySell[$j]['order_id'];
					$pId[] = $todaySell[$j]['product_id'];
					$pQuan[] = $todaySell[$j]['quantity'];
					$pPrice[] = $todaySell[$j]['price_each'];
					
				}
			}
			echo "Today total sell:</br>";
			echo "ORDER_ID--PRODUCT_ID-----QUANTITY-----PRICE</BR>";
			for ($i=0; $i <count($id) ; $i++) { 
				echo $id[$i]."------------".$pId[$i]."--------------".$pQuan[$i]."-----".$pPrice[$i]."</br>";
				$total+=$pQuan[$i];
				$totalP += $pPrice[$i]*$pQuan[$i];
			}
			echo "Total Sells item :".$total;	
			echo " <br />Total Price : $".$totalP;
				
		}	
	}
	else
	{
		echo "Nothing In History!!";
	}
		

?>
