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
    $orderHistoryObj = new Order();
    $orderDetailHistoryObj = new OrderDetail();
    $todayOrderObj = new OrderDetail();
    $orderHistory = $orderHistoryObj->GetOrderHistory();
    if ($orderHistory) 
    {
        $orderIds= array();
        echo "order History:</br>";
        echo "ORDER_ID--CUSTOMER_ID-------DATE</BR>";
        
        foreach ($orderHistory as $key => $value) {
            $orderIds[] = $orderHistory[$key]['order_id'];
            echo $orderHistory[$key]['order_id']."-----------------".$orderHistory[$key]['customer_id']."---------".
            $orderHistory[$key]['created_at']."</br>";
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
        echo "Total order:</br>";
        echo "SERIAL--ORDER_ID--PRODUCT_ID-----QUANTITY</BR>";
        for ($i=0; $i <count($id) ; $i++) { 
            echo $id[$i]."----------".$Oid[$i]."-----------".$pId[$i]."--------------".$pQuan[$i]."</br>";
            $total+=$pQuan[$i];
        }
        echo "Total Order item : ".$total;
    }
    else
    {
        echo "Nothing in History!";
    }
?>
