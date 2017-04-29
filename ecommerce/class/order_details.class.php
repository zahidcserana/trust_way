<?php
    class OrderDetail
    {
        private $db=null;
        function __construct()
        {
            $this->db = Database::GetDatabaseConnection();
        }
        function InsertToOrderDetails($orderId, $productId, $quantity, $productPrice)
        {
            $query = "INSERT INTO order_details (order_id, product_id, quantity, price_each) VALUES (?,?,?,?)";
            $parameters = array($orderId, $productId, $quantity, $productPrice);
            $types = array("s","s","s","s");
            return $this->db->Insert($query, $parameters, $types);
        }
        
        function AddToCart($quantity,$cartId,$prodId)
        {
            $query = "INSERT INTO cart_details (quantity, cart_id, product_id) VALUES (?,?,?)";
            $parameters = array($quantity,$cartId,$prodId);
            $types = array("s","s","s");
            return $this->db->Insert($query, $parameters, $types);
        }

        function Delete($user_id)
        {
            $query = "delete from booked where user_id = ?";
            $parameter = array($user_id);
            return $this->db->Delete($query, $parameter);
        }

        function CartUpdate($quantity,$cartId,$prodId)
        {
            $query = "UPDATE cart_details SET  quantity=? WHERE cart_id=? AND product_id=? ";
            $parameter = array($quantity,$cartId,$prodId);
            $type = array("s","s","s");
            return $this->db->Update($query, $parameter, $type);
        }
        function UserPasswordReset($token,$email)
        {
            $query = "UPDATE user_info SET token=? WHERE email=? ";
            $parameter = array($token,$email);
            $type = array("s","s");
            return $this->db->Update($query, $parameter, $type);
        }
        function redirect($url)
        {
            header("Location: $url");
        }
        function lasdID()
        {
            $stmt = $this->db->insert_id;
            return $stmt;
        }

        function GetCartIds($userId)
        {
            $query = "SELECT cart_id FROM cart WHERE user_id = ?";
            $parameter = array($userId);
            $type = array("s");
            return $this->db->GetRowList($query, $parameter, $type);
        }
        function getUserInfo($id,$code)
        {
            $query = "SELECT * FROM user_info WHERE user_id=? AND token=?";
            $parameter = array($id,$code);
            $type = array("s","s");
            return $this->db->GetRowList($query, $parameter, $type);
        }
        
        function GetTotalProductSell($start,$end)
        {
            //echo "Email: ".$email." ".$password;
            $query = "SELECT * FROM order_details WHERE id BETWEEN $start AND $end";
            $parameters = array($orderId);
            $types = array("i");
            return $this->db->GetManyRow($query);
        }
        function GetTotalOrder($orderId)
        {
            //echo "Email: ".$email." ".$password;
            $query = "SELECT * FROM order_details WHERE  order_id=?";
            $parameters = array($orderId);
            $types = array("i");
            return $this->db->GetRowList($query, $parameters, $types);
        }
        function GetTodayProductSell($orderId)
        {
            //echo "Email: ".$email." ".$password;
            $query = "SELECT * FROM order_details WHERE  order_id=?";
            $parameters = array($orderId);
            $types = array("i");
            return $this->db->GetRowList($query, $parameters, $types);
        }
        function GetOrderDetail($start,$end)
        {
            //echo "Email: ".$email." ".$password;
            $query = "SELECT * FROM order_details WHERE id BETWEEN $end AND $start ";
            $parameters = array();
            $types = array();
            return $this->db->GetManyRow($query);
        }

        function CartInfo($cartId)
        {
            //echo "Email: ".$email." ".$password;
            $query = "SELECT * FROM cart_details WHERE  cart_id=?";
            $parameters = array($cartId);
            $types = array("s");
            return $this->db->GetRowList($query, $parameters, $types);
        }
        function GetCartId($sessionId ,$userId)
        {
            //echo "Email: ".$email." ".$password;
            $query = "SELECT cart_id FROM cart WHERE  session_id=? AND user_id=?";
            $parameters = array($sessionId ,$userId);
            $types = array("s","s");
            return $this->db->GetRowList($query, $parameters, $types);
        }
    
        function GetProductInfo($cartId, $prodId)
        {
            $query = "SELECT * FROM cart_details WHERE cart_id=? AND product_id=?";
            $parameters = array($cartId, $prodId);
            return $this->db->GetRowList($query,$parameters);
        }

        function GetUserId($email)
        {
            $query = "SELECT user_id FROM user_info WHERE email=? LIMIT 1";
            $parameters = array($email);
            $types = array("s");
            return $this->db->GetRowList($query,$parameters,$types);
        }
           
    }
?>




