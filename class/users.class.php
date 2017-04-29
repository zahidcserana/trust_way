<?php
    class User
    {
        private $db;

		function __construct() 
		{

			$this->db = iConnection::GetConnectionObject();

		}

		public function AddUser($username,$email,$password)
		{
            $query = "INSERT INTO users (username,email,password)
                VALUES (?, ?, ?)";
            $parameters = array($username,$email,$password);

            return $this->db->InsertAndGetId($query, $parameters);

		}

		function GetUserInfo($email, $password)
        {
          	$query = "select * from users where email=? and password=?";
          	$parameters = array($email, $password);
          	return $this->db->GetInfo($query,$parameters);
        }
        
        function GetUserDetails($userId)
        {
          	$query = "select * from users where id=?";
          	$parameters = array($userId);
          	return $this->db->GetInfo($query,$parameters);
        }

        function CheckIsExist($email)
        {
        	$query = "select * from users where email=?";
          	$parameters = array($email);
          	return $this->db->GetInfo($query,$parameters);
        }

		function GetUserList()
        {
        	$query = "select * from users";
          	return $this->db->GetList($query);
        }

        function UploadImage($userId,$fileName)
        {
        	$query = "UPDATE users set image=? WHERE id=?";
        	$parameters = array($fileName,$userId);
          	return $this->db->Update($query,$parameters);
        }

		function GetTrackList($applicationId=0, $pageNo=1, $perPageItem=10)
		{
			global $applicationList;
			
			$dataQuery = "select * from login_information_tracker";
			$countQuery = "select count(*) as total_login_log from login_information_tracker";
			if($applicationId!=0)
			{
				$dataQuery .= " where application_id=$applicationId ";
				$countQuery .= " where application_id=$applicationId ";
			}
			
			
			$start = ( intval($pageNo)-1)* $perPageItem;
			$dataQuery .= " limit {$start},{$perPageItem}";
			$startItem =  $start+1;
			$lastItem =  intval($pageNo) * $perPageItem;
						
			$loginList = $this->db->GetList($dataQuery);
			foreach( $loginList as &$aLogin )
			{
				$loginApplicationId = $aLogin['application_id'];
				if(isset($applicationList[$loginApplicationId]))
					$aLogin['application_name'] = $applicationList[$loginApplicationId];
				else
					$aLogin['application_name'] = "Damaged data";
			}
			unset($aLogin);
			
			$totalLoginRow = $this->db->GetInfo($countQuery);
			$totalLogin = $totalLoginRow['total_login_log'];
			if($lastItem>$totalLogin)
				$lastItem = $totalLogin;
			return array(
							'login_list' 	=> 	$loginList,
							'total_login' 	=>	$totalLogin,
							'start_item'	=>	$startItem,
							'last_item'	=>	$lastItem,
						);
		}
    }
?>