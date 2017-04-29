<?php
    class Token
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
        
        function InsertToToken($UserId,$tokenType, $token,$addedOn,$validity)
        {
            $query = "INSERT INTO token (user_id,token_type ,token,added_on,valid_time) VALUES (?,?,?,?,?)";
            $parameters = array($UserId,$tokenType, $token,$addedOn,$validity);
            $types = array("s","s","s","s","s");
            return $this->db->Insert($query, $parameters, $types);
        }
        function AccountActivity($userId)
        {
            //echo "Email: ".$email." ".$password;
            $query = "SELECT * FROM token WHERE user_id=?";
            $parameters = array($userId);
            $types = array("s");
            return $this->db->GetRow($query, $parameters, $types);
        }

        function Delete($user_id)
        {
            $query = "delete from booked where user_id = ?";
            $parameter = array($user_id);
            return $this->db->Delete($query, $parameter);
        }

         function TokenStatusUpdate($status,$token)
        {
            $query = "UPDATE token SET  status=? WHERE token=? ";
            $parameter = array($status,$token);
            $type = array("s","s");
            return $this->db->Update($query, $parameter, $type);
        }
        function ExpiredToken($token)
        {
            $query = "SELECT valid_time FROM token  WHERE token=? ";
            $parameter = array($token);
            $type = array("s");
            return $this->db->Update($query, $parameter, $type);
        }

        function CheckToken($token)
        {
            $query = "SELECT * FROM token  WHERE token=? ";
            $parameter = array($token);
            $type = array("s");
            return $this->db->GetRow($query, $parameter, $type);
        }
        
         function ForgetToken($id,$token_type,$token)
        {
            $query = "INSERT INTO  token(user_id,token_type,token) VALUES(?,?,?) ";
            $parameter = array($id,$token_type,$token);
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
        function GetUserId($code)
        {
            $query = "SELECT * FROM token WHERE  token=?";
            $parameter = array($code);
            $type = array("s");
            return $this->db->GetRow($query, $parameter, $type);
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

        /*function GetUserId($email)
        {
            $query = "SELECT user_id FROM user_info WHERE email=? LIMIT 1";
            $parameters = array($email);
            $types = array("s");
            return $this->db->GetRowList($query,$parameters,$types);
        }*/
        function ResetPass($password,$id)
        {
            $query = "UPDATE user_info SET password=? WHERE user_id=? ";
            $parameter = array($password,$id);
            $type = array("s","s");
            return $this->db->Update($query, $parameter, $type);
        }
        
    


    }
?>




