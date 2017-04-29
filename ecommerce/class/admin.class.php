<?php
    class AdminInfo
    {
        private $db=null;
        function __construct()
        {
            $this->db = Database::GetDatabaseConnection();
        }
        function Insert($userName,$password)
        {
            $query = "INSERT INTO admin(user_name,password)
            VALUES (?, ?)";
            $parameters = array($userName,$password);
            $types = array("s","s");
            return $this->db->Insert($query, $parameters, $types);
        }

        function Delete($user_id)
        {
            $query = "delete from booked where user_id = ?";
            $parameter = array($user_id);
            return $this->db->Delete($query, $parameter);
        }

        function Update($token)
        {
            $query = "UPDATE user_info SET  status='Y' WHERE token=? ";
            $parameter = array($token);
            $type = array("s");
            return $this->db->Update($query, $parameter, $type);
        }
       
       
        function redirect($url)
        {
            header("Location: $url");
        }
        

        function GetAdminInfo($userName,$password)
        {
            $query = "SELECT * FROM admin WHERE user_name = ? AND password=?";
            $parameter = array($userName,$password);
            $type = array("s","s");
            return $this->db->GetRow($query, $parameter, $type);
        }
        function AdminCheck($userName)
        {
            $query = "SELECT * FROM admin WHERE user_name=?";
            $parameter = array($userName);
            $type = array("s");
            return $this->db->GetRow($query, $parameter, $type);
        }
        function RegisterCheck($email,$password)
        {
            //echo "Email: ".$email." ".$password;
            $query = "SELECT * FROM user_info WHERE email=? And password=?";
            $parameters = array($email,$password);
            $types = array("s","s");
            return $this->db->GetRow($query, $parameters, $types);
        }
    

        function GetUserId($email)
        {
            $query = "SELECT * FROM user_info WHERE email=? LIMIT 1";
            $parameters = array($email);
            $types = array("s");
            return $this->db->GetRow($query,$parameters,$types);
        }
       
        function is_logged_in()
        {
            if(isset($_SESSION['user_name']))
            {
                return true;
            }
        }
    


    }
?>




