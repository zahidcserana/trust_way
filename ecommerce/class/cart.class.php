<?php
    class CartId
    {
        private $db=null;
        function __construct()
        {
            $this->db = Database::GetDatabaseConnection();
        }
        function CreateCartId($userId, $sessionId)
        {
            $query = "INSERT INTO cart (user_id, session_id) VALUES (?, ?)";
            $parameters = array($userId, $sessionId);
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

        function CartUpdate($quantity,$cartId,$prodId)
        {
            $query = "UPDATE cart_details SET  quantity=? WHERE cart_id=? AND product_id=? ";
            $parameter = array($quantity,$cartId,$prodId);
            $type = array("s","s","s");
            return $this->db->Update($query, $parameter, $type);
        }
       
        function redirect($url)
        {
            header("Location: $url");
        }
        

        function GetCartIds($userId)
        {
            $query = "SELECT cart_id FROM cart WHERE user_id = ?";
            $parameter = array($userId);
            $type = array("s");
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
            return $this->db->GetRow($query, $parameters, $types);
        }
    
        function GetProductInfo($cartId, $prodId)
        {
            $query = "SELECT * FROM cart_details WHERE cart_id=? AND product_id=?";
            $parameters = array($cartId, $prodId);
            return $this->db->GetRowList($query,$parameters);
        }

       
       
       
    }
?>




