<?php
    class UserInfo
    {
        private $db=null;
        function __construct()
        {
            $this->db = Database::GetDatabaseConnection();
        }
        function Insert($userName, $firstName, $lastName, $email, $password, $phone)
        {
            $query = "INSERT INTO user_info(user_name,first_name,last_name,email,password,phone)
            VALUES (?, ?, ?, ?, ?, ?)";
            $parameters = array($userName, $firstName, $lastName, $email, $password, $phone);
            $types = array("s","s","s","s","s","s");
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
         function UserActivation($status,$Id)
        {
            $query = "UPDATE user_info SET  status=? WHERE user_id=? ";
            $parameter = array($status,$Id);
            $type = array("s","s");
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
            return $this->db->GetRow($query, $parameter, $type);
        }
        function GetUserInfo($id)
        {
            $query = "SELECT * FROM user_info WHERE user_id=?";
            $parameter = array($id);
            $type = array("s");
            return $this->db->GetRow($query, $parameter, $type);
        }
        
        function UploadImage($userId,$fileName)
        {
            $query = "UPDATE user_info set image=? WHERE user_id=?";
            $parameters = array($fileName,$userId);
            return $this->db->Update($query,$parameters);
        }

        function RegisterCheck($email,$password)
        {
            //echo "Email: ".$email." ".$password;
            $query = "SELECT * FROM user_info WHERE email=? And password=?";
            $parameters = array($email,$password);
            $types = array("s","s");
            return $this->db->GetRow($query, $parameters, $types);
        }
    
        function GetBookedDays($year, $month)
        {
            $query = "select dates from booked where YEAR(dates)=? and MONTH(dates)=?";
            $parameters = array($year, $month);
            return $this->db->GetRowList($query,$parameters);
        }

        function GetUserId($email)
        {
            $query = "SELECT * FROM user_info WHERE email=? LIMIT 1";
            $parameters = array($email);
            $types = array("s");
            return $this->db->GetRow($query,$parameters,$types);
        }
        function ResetPass($password,$id)
        {
            $query = "UPDATE user_info SET password=? WHERE user_id=? ";
            $parameter = array($password,$id);
            $type = array("s","s");
            return $this->db->Update($query, $parameter, $type);
        }
        function is_logged_in()
        {
            if(isset($_SESSION['user_name']))
            {
                return true;
            }
        }
    


        function send_mail($email,$message,$subject)
        {                       
            require_once('mailer/class.phpmailer.php');
            $mail = new PHPMailer();
            $mail->IsSMTP(); 
            $mail->SMTPDebug  = 0;                     
            $mail->SMTPAuth   = true;                  
            $mail->SMTPSecure = "ssl";                 
            $mail->Host       = "smtp.gmail.com";      
            $mail->Port       = 465;             
            $mail->AddAddress($email);
            $mail->Username="your_gmail_id_here@gmail.com";  
            $mail->Password="your_gmail_password_here";            
            $mail->SetFrom('your_gmail_id_here@gmail.com','Coding Cage');
            $mail->AddReplyTo("your_gmail_id_here@gmail.com","Coding Cage");
            $mail->Subject    = $subject;
            $mail->MsgHTML($message);
            $mail->Send();
        }
    }
?>




