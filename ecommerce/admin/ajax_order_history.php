<?php
	require_once("/../class/database.class.php");
    require_once dirname(__FILE__).'/../class/products.class.php';
    require_once dirname(__FILE__).'/../class/order.class.php';
    require_once dirname(__FILE__).'/../class/order_details.class.php';
?>
<?php
    $orderHistoryObj = new OrderDetail();
    $start = $_GET['start'];
     $end = $_GET['end'];
    
    $parameters = array( 'success'=>false, 'message' => 'parameter is not passed properly' );

    
    $orderHistory = $orderHistoryObj->GetOrderDetail($start,$end);
    $parameters = array( 'success'=>true, 'order' => $orderHistory );
    echo json_encode($parameters);
?>