<?php
    class Order
    {
        private $db=null;
        function __construct()
        {
            $this->db = Database::GetDatabaseConnection();
        }
        function CreateOrderId($CustomerId,$todayDate)
        {
            $query = "INSERT INTO orders (customer_id,created_at) VALUES (?,?)";
            $parameters = array($CustomerId,$todayDate);
            $types = array("s","s");
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

        function GetTodayOrder($todayDate)
        {
            $sql = "SELECT * FROM orders WHERE created_at = ?";
            $parameter = array($todayDate);
            $types = array("s");
            return $this->db->GetRowList($sql, $parameter, $types);
        }
        
        function GetOrderHistory()
        {
            $query = "SELECT * FROM orders ";
            $parameter = array();
            $type = array();
            return $this->db->GetManyRow($query);
        }

        function GetOrderId($customerId)
        {
            $query = "SELECT order_id FROM orders WHERE customer_id = ? ORDER BY order_id DESC LIMIT 1";
            $parameter = array($customerId);
            $type = array("s");
            return $this->db->GetRow($query, $parameter, $type);
        }
        function getUserInfo($id,$code)
        {
            $query = "SELECT * FROM user_info WHERE user_id=? AND token=?";
            $parameter = array($id,$code);
            $type = array("s","s");
            return $this->db->GetRowList($query, $parameter, $type);
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




