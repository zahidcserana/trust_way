
<?php
class Database {
	private $connection;
	private static $databaseConnection; 
	
	private $host = "localhost";
	private $username = "root";
	private $password = "";
	private $database = "ecommerce";
	
	/*
	private $host = "localhost";
	private $username = "id590622_ecommerce";
	private $password = "ecommerce";
	private $database = "id590622_ecommerce";
	*/

	public static function GetDatabaseConnection() 
	{
		if(!self::$databaseConnection) { 
			self::$databaseConnection = new self();
		}
		return self::$databaseConnection;
	}

	
	private function __construct() 
	{
		$db = $this->connection = new mysqli($this->host, $this->username, 
			$this->password, $this->database);
	
		
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
				 E_USER_ERROR);
		}
	}

	public function InsertAndGetId($insert)
	{
		$stmt = $db->prepare($insert);
    		$params = array();
		call_user_func_array(array($stmt, 'bind_param'), $params);
		$stmt->execute();
		if($stmt==false)
			return 0;
		$insertId = $db->$_REQUEST["UserID"];
		return $insertId;
	}


      public function Insert($query,$params, $types = null)
      {
      	if ($types === null)
      	{
      		$types = array();
		      foreach ($params as $param)
		      	$types[] = substr(gettype($param), 0, 1);
		}
		$typeString = implode('', $types);   
		$bindParams = array();
		$bindParams[] = $typeString;
		for($index=0; $index<count($params); $index++)
			$bindParams[] = &$params[$index];
		    
		$stmt = $this->connection->prepare($query);
		call_user_func_array(
			array($stmt, 'bind_param'),
			$bindParams
			);
		$stExecute = $stmt->execute();
		//$result = $stmt->get_result();
		$stmt->close();
		
		if($stExecute==false)
			return false;
		return true;
	}

	public function GetRowList($query, array $params, array $types = null )
	{
		if ($types === null)
		{
			$types = array();
			foreach ($params as $param)
				$types[] = substr(gettype($param), 0, 1);
		}
		$typeString = implode('', $types);
		$bindParams = array();
		$bindParams[] = $typeString;
		for($index=0; $index<count($params); $index++)
			$bindParams[] = &$params[$index];
		    
		$stmt = $this->connection->prepare($query);
		call_user_func_array(
			array($stmt, 'bind_param'),
		      $bindParams
		      );
		$stmt->execute();
		$result = $stmt->get_result();
		
            $stmt->close();
            if($result->num_rows>0)
            	return $result->fetch_all(MYSQLI_ASSOC);
            return false;
      }


	public function GetRow($query, array $params , array $types = null)
	{
		if ($types === null)
		{
			$types = array();
			foreach ($params as $param)
				$types[] = substr(gettype($param), 0, 1);
		}
		$typeString = implode('', $types);
		$bindParams = array();
		$bindParams[] = $typeString;
		for($index=0; $index<count($params); $index++)
			$bindParams[] = &$params[$index];
		    
		$stmt = $this->connection->prepare($query);
		call_user_func_array(
			array($stmt, 'bind_param'),
		      $bindParams
		      );
		$stmt->execute();
		$result = $stmt->get_result();
		
            $stmt->close();
            if($result->num_rows>0)
            	return $result->fetch_array(MYSQLI_ASSOC);
            return false;
        }

	public function GetManyRow($query)
	{
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
            
            
            if($result->num_rows>0)
                return $result->fetch_all(MYSQLI_ASSOC);
         	$stmt->close();
	}

	public function Update($query, array $params, array $types = null)
	{
		if ($types === null)
		{
			$types = array();
			foreach ($params as $param)
				$types[] = substr(gettype($param), 0, 1);
		}
		$typeString = implode('', $types);
		$bindParams = array();
		$bindParams[] = $typeString;
		for($index=0; $index<count($params); $index++)
			$bindParams[] = &$params[$index];
		    
		$stmt = $this->connection->prepare($query);
		call_user_func_array(
			array($stmt, 'bind_param'),
			$bindParams
			);
		$stmt->execute();
		$result = $stmt->get_result();
    	$stmt->close();
    	if($result==false)
    		return false;
    	return true;
 	}
 	public function Delete($query, array $params, array $types = null)
	{
		if ($types === null)
		{
			$types = array();
			foreach ($params as $param)
				$types[] = substr(gettype($param), 0, 1);
		}
		$typeString = implode('', $types);
		$bindParams = array();
		$bindParams[] = $typeString;
		for($index=0; $index<count($params); $index++)
			$bindParams[] = &$params[$index];
		    
		$stmt = $this->connection->prepare($query);
		call_user_func_array(
			array($stmt, 'bind_param'),
			$bindParams
			);
		$stmt->execute();
		$result = $stmt->get_result();
            $stmt->close();
            if($result==false)
            	return false;
            return true;
 	}
 	public function DeleteRow($query)
	{
		
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
            $stmt->close();
            	if($result==false)
            		return false;
            	return true;
 	}



	private function __clone() { }

	
	public function getConnection() {
		return $this->connection;
	}

    
}

    $db = Database::GetDatabaseConnection();


?>