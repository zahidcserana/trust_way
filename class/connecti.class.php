<?php
    class iConnection
    {
        var $DATABASE_HOST;
        var $DATABASE_USERNAME;
        var $DATABASE_PASSWORD;
        var $DATABASE_NAME;
		
        private $CONNECTION;
        private static $SINGLETONE_CONNECTION_OBJECT;
        
        var $ERROR_MESSAGE;
        var $DATA_ERROR_OCCURED;
        var $SQL_ERROR_OCCURED;
        var $TOTAL_AFFECTED_ROWS;
        private function __construct()
        {
             /*
            $this->DATABASE_HOST = 'localhost';
            $this->DATABASE_USERNAME = 'id590622_db_first';
            $this->DATABASE_PASSWORD = 'db_first';
			$this->DATABASE_NAME = 'id590622_db_first';
           */
            $this->DATABASE_HOST = 'localhost';
            $this->DATABASE_USERNAME = 'root';
            $this->DATABASE_PASSWORD = '';
            $this->DATABASE_NAME = 'db_first';
            
        }
        
        public static function GetConnectionObject()
        {
            if(!isset(self::$SINGLETONE_CONNECTION_OBJECT))
            {
                self::$SINGLETONE_CONNECTION_OBJECT = new iConnection();
                self::$SINGLETONE_CONNECTION_OBJECT->Connect();
            }
            return self::$SINGLETONE_CONNECTION_OBJECT;
        }
        
        private function Connect()
        {
            $this->CONNECTION = new mysqli($this->DATABASE_HOST, $this->DATABASE_USERNAME, $this->DATABASE_PASSWORD);
            if ($this->CONNECTION->connect_error)
            {
                return false;
            }
			$this->CONNECTION->select_db($this->DATABASE_NAME);
            return true;
        }
        
        private function BuildAndExecuteStatement($query,$parameterDetailsArray=array())
        {
            $this->ERROR_MESSAGE  =  "";
            $this->DATA_ERROR_OCCURED = false;
            $this->SQL_ERROR_OCCURED = false;
            $this->TOTAL_AFFECTED_ROWS = 0;
            
            $stmt = $this->CONNECTION->prepare($query);
            if($stmt === false) 
            {

                $this->ERROR_MESSAGE  = 'Wrong SQL: ' . $query . ' Error: ' . $this->CONNECTION->errno . ' ' . $this->CONNECTION->error;
                
                $this->SQL_ERROR_OCCURED = true;
                return false;
            }

            $total = count($parameterDetailsArray);
            if($total>0)
            {
                $paramArray = array();
                $paramArray[] = "";
                $paramerterType = "";
                
                for($index=0;$index<$total;$index++)
                {
                    if(is_array($parameterDetailsArray[$index]))
                    {
                        $paramArray[] = & $parameterDetailsArray[$index]['value'];
                        $paramerterType .= $parameterDetailsArray[$index]['type'];
                    }
                    else
                    {
                        $paramArray[] = & $parameterDetailsArray[$index];
                        $paramerterType .= "s";
                    }
                }
                
                $paramArray[0] = &$paramerterType;
                 
                $bindResult = call_user_func_array(array($stmt, 'bind_param'), $paramArray);    
                
                if($bindResult==false)
                {
                    $this->ERROR_MESSAGE  = 'Binding Error: ' . $query . ' Error: ' . $stmt->errno . ' ' . $stmt->error;
                    $this->SQL_ERROR_OCCURED = true;
                    
                    $stmt->close();
                    return false;
                }
            }
            
            $executeResult = $stmt->execute();
            if($executeResult==false)
            {
                $this->ERROR_MESSAGE  = 'Execute Error: ' . $query . ' Error: ' . $stmt->errno . ' ' . $stmt->error;
                $this->SQL_ERROR_OCCURED = true;
                
                $stmt->close();
                return false;
            }
            
            return $stmt;
        }
        
        
        public function InsertAndGetId($query,$parameterDetailsArray=array())
        {

            $stmt = $this->BuildAndExecuteStatement($query, $parameterDetailsArray);
            if($stmt === false)
               return false;
           
            $insertedId = $stmt->insert_id;
            $stmt->close();
            if($insertedId==0)
            {
                $this->ERROR_MESSAGE  = 'Insertion was not possible due to some error';
                $this->DATA_ERROR_OCCURED  = true;
                return false;
            }
            
            return $insertedId;
        }
        
        public function Insert($query,$parameterDetailsArray=array())
        {
            $stmt = $this->BuildAndExecuteStatement($query, $parameterDetailsArray);
            if($stmt === false)
               return false;
            $stmt->close();
            return true;
        }
        
        
		public function InsertByArray($dataArrContainer,$tableName,$database = "")
		{
			
			if(empty($dataArrContainer)) return false;
			
			if( !isset($dataArrContainer[0]) )
				$dataArrContainer = array($dataArrContainer);
			
			foreach($dataArrContainer as $dataArr)
			{
				if($database=="")
					$sqlQuery = "insert into {$tableName}";
				else
					$sqlQuery = "insert into {$database}.{$tableName}";
				
				$columnNameArr = array();
				$questionArr = array();
				$parametersArr = array();
				foreach($dataArr as $key=>$value)
				{
					$columnNameArr []= $key;
					$questionArr[] = '?';
					$parametersArr[] = $value;
				}
				$sqlQuery = $sqlQuery . "(" .  implode( ' , ', $columnNameArr ) . ") values ( " . implode( ' , ', $questionArr ) .  " )";
				$insertId = $this->InsertAndGetId($sqlQuery, $parametersArr);
			}
			return $insertId;
		}
		
        public function GetInfo($query,$parameterDetailsArray=array())
        {
            $stmt = $this->BuildAndExecuteStatement($query, $parameterDetailsArray);
            if($stmt === false)
               return false;
               
            $result = $stmt->get_result();
            $stmt->close();
            
            if($result->num_rows>0)
                return $result->fetch_array(MYSQLI_BOTH);
            else
            {
                $this->ERROR_MESSAGE  = 'No row matches with your requirement';
                $this->DATA_ERROR_OCCURED  = true;
                return false;
            }
        }
        
        public function GetList($query,$parameterDetailsArray=array())
        {
            $stmt = $this->BuildAndExecuteStatement($query, $parameterDetailsArray);
            if($stmt === false)
               return false;
            
            $result = $stmt->get_result();
            $stmt->close();
            
            if($result->num_rows>0)
                return $result->fetch_all(MYSQLI_BOTH);
            else
            {
                $this->ERROR_MESSAGE  = 'No row matches with your requirement';
                $this->DATA_ERROR_OCCURED  = true;
                return array();
            }
        }
        
        public function Update($query,$parameterDetailsArray=array())
        {
            $stmt = $this->BuildAndExecuteStatement($query, $parameterDetailsArray);
            if($stmt === false)
               return false;
            
            $this->TOTAL_AFFECTED_ROWS = $stmt->affected_rows;
            
            if($stmt->affected_rows<=0)
            {
                $this->ERROR_MESSAGE  = 'No data has been Update';
                $this->DATA_ERROR_OCCURED  = true;
                $deleted = false;
            } 
            $stmt->close();
            return true;
        }
        
		public function UpdateByArray($dataArrContainer,$tableName,$columnName,$columnValue,$database = "")
		{
			if(empty($dataArrContainer)) return false;
			
			foreach($dataArrContainer as $dataArr)
			{
				if($database=="")
					$sqlQuery = "update {$tableName} set ";
				else
					$sqlQuery = "update {$database}.{$tableName} set ";
				
				$columnNameArr = array();
				$parametersArr = array();
				foreach($dataArr as $key=>$value)
				{
					$columnNameArr []= "{$key}=?";
					$parametersArr[] = $value;
				}
				$sqlQuery = $sqlQuery . impode( ' , ' , $columnNameArr ) . " where {$columnName} = ?";
				$parametersArr[] = $columnValue;
				$this->Update($sqlQuery, $parametersArr );
			}
			return 1;
		}
		
        public function Delete($query,$parameterDetailsArray=array())
        {
            $stmt = $this->BuildAndExecuteStatement($query, $parameterDetailsArray);
            if($stmt === false)
               return false;
            
            $deleted = true;
            if($stmt->affected_rows<=0)
            {
                $this->ERROR_MESSAGE  = 'No data has been deleted';
                $this->DATA_ERROR_OCCURED  = true;
                $deleted = false;
            }
            
            $stmt->close();
            return $deleted;
        }
        
		public function GetColumnNameList($query, $parameterDetailsArray)
		{
			$stmt = $this->BuildAndExecuteStatement($query, $parameterDetailsArray);
            if($stmt === false)
               return false;
            
            $result = $stmt->get_result();
			if($result)
			{
				return $result->fetch_fields();
			}
			return false;
		}
		
		public function GetMysqliResultSet($query, $parameterDetailsArray)
		{
			$stmt = $this->BuildAndExecuteStatement($query, $parameterDetailsArray);
            if($stmt === false)
               return false;
            
            return $stmt->get_result();
		}
        
        public function GetLastQueryInfo()
		{
            return $this->CONNECTION->info;
		}
		
        function __destruct() 
        {
            $this->CONNECTION->close();
        }
    }
    
    $databaseConnectionObj = iConnection::GetConnectionObject();
?>