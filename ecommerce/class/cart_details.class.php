<?php
    class CartDetails
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
        
        function AddToCart($prodId,$quantity,$cartId)
        {
            $query = "INSERT INTO cart_details (product_id,quantity, cart_id ) VALUES (?,?,?)";
            $parameters = array($prodId,$quantity,$cartId);
            $types = array("s","s","s");
            return $this->db->Insert($query, $parameters, $types);
        }

        function Delete($user_id)
        {
            $query = "delete from booked where user_id = ?";
            $parameter = array($user_id);
            return $this->db->Delete($query, $parameter);
        }
        function RemoveProduct($pId,$cartId)
        {
            $query = "DELETE  FROM cart_details WHERE product_id =? AND cart_id=?";
            $parameter = array($pId,$cartId);
            $types = array("s","s");
            return $this->db->Delete($query,$parameter,$types);
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

        function GetRow($email)
        {
            $query = "SELECT * FROM user_info WHERE email = ?";
            $parameter = array($email);
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

        function GetProdIdQuantity($cartId)
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
            $types = array("s","s");
            return $this->db->GetRow($query,$parameters,$types);
        }

        


    }
?>




