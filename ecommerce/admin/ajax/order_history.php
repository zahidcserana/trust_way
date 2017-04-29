<?php
	require_once("/../../class/database.class.php");
	require_once dirname(__FILE__).'/../../class/order.class.php';
	require_once dirname(__FILE__).'/../../class/order_details.class.php';
	require_once("include/header.php");
?>
<?php
	   
    $number = $_GET['number'];
    
    $parameters = array( 'success'=>false, 'message' => 'parameter is not passed properly' );

    $orderHistoryObj = new Order();
    $orderHistory = $orderHistoryObj->GetOrderDetail($number);
    $parameters = array( 'success'=>true, 'order' => $orderHistory );
    echo json_encode($parameters);
?>