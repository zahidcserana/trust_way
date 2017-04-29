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
    echo "ORDER_ID--CUSTOMER_ID-------DATE</BR>";
    $orderHistory = $orderHistoryObj->GetOrderHistory();
    foreach ($orderHistory as $key => $value) {
        echo $orderHistory[$key]['order_id']."-----------------".$orderHistory[$key]['customer_id']."---------".
        $orderHistory[$key]['created_at']."</br>";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="lib/jquery.js"></script>
    <script src="dist/jquery.validate.js"></script>
    
    
    
</head>
<body>
<div id="demo"></div>
<p id="today_sell">Today Sell</p>
<script>
    $(document).ready(function()
    {
        $("#TodaySell").click(function()
          {
                var d = new Date();
                var n = d.getDay()
                var month = d.getMonth()
                var year = d.getFullYear();
                TodaySellHist(year,month);
               
          });
    });
</script>
<script>
    function TodaySellHist(year,month)
    {
        $.ajax({
                method: "GET",
                url: "order_info.php",
                data: { year: year, month: month}
          }).done(function( response ) 
          {       
              var jsonResponse = JSON.parse(response);
              if(jsonResponse.success==false)
              {
                alert(message);
                return;
              }
              
                var todaySellsHistory = jsonResponse.today_sell; 
                //document.getElementById("today_sell").innerHTML=todaySellsHistory;
                //var todaySellsHistory = '423';
                $("#today_sell").html(todaySellsHistory);
                //alert(todaySellsHistory);
        });
    }
    
</script>
<button id="TodaySell">Today Sell</button>
</body>
</html>