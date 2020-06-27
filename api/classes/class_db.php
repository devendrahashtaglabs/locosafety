<?php

/**
 * Description of class_db
 *
 * @Sri Technocrat
 */
include_once 'class_settings.php';
class class_db {

    //put your code here
    public $sproc_name;
    public $param_array = array();
    private $numrows;
    private $genrate_id;

    public function ExecuteSP_old() {
        $OBJCONNECT = new class_settings();
        $connect = $OBJCONNECT->MyConnectDB();
        $success = "";
        //echo "CALL " . $this->sproc_name . "('" . implode("', '", $this->param_array) . "');";
        $success = mysqli_query($connect, "CALL " . $this->sproc_name . "('" . implode("', '", $this->param_array) . "');") or die(mysqli_errno($connect));
        $success_str = mysqli_fetch_array($success);
        $OBJCONNECT->MyDisConnectDB();        
        return $success_str[0];
    }
	
	
	public function ExecuteSP() {
        $OBJCONNECT = new class_settings();
        $connect = $OBJCONNECT->MyConnectDB();
        $success = "";
		
		$countArr = count($this->param_array);
		$param = '(';
		$i = 1;
		foreach($this->param_array as $row){
			
			if($row != ''){
				$param .= '"'.$row.'"';
			}else{
				$param .= 'NULL';
			}
			
			if($i == $countArr){
				$param .='';
			}else{
				$param .=',';	
			}
			$i++;
		}
		$param .= ')';
		
      // echo "CALL " . $this->sproc_name . "('" . implode("', '", $this->param_array) . "');";
		
        $success = mysqli_query($connect, "CALL " . $this->sproc_name.$param.";") or die(mysqli_errno($connect));
		
		
		
        $success_str = mysqli_fetch_array($success);
        $OBJCONNECT->MyDisConnectDB();        
        return $success_str[0];
    }

	
    public function SelectSPSingle() {
        $OBJCONNECT = new class_settings();
        $connect = $OBJCONNECT->MyConnectDB();
        $result = mysqli_query($connect, "CALL " . $this->sproc_name . "();") or die(mysqli_error($connect));                
        $OBJCONNECT->MyDisConnectDB();
        return $result;
    }
    
    public function SelectMultiSP() {
        $OBJCONNECT = new class_settings();
        $connect = $OBJCONNECT->MyConnectDB();
        //echo "CALL " . $this->sproc_name . "('" . implode("', '", $this->param_array) . "');";
        echo $result = mysqli_multi_query($connect, "CALL " . $this->sproc_name . "('" . implode("', '", $this->param_array) . "');") or die(mysqli_error($connect));        
        $OBJCONNECT->MyDisConnectDB();
        return $result;
    }

    public function SelectSP() {
        $OBJCONNECT = new class_settings();
        $connect = $OBJCONNECT->MyConnectDB();
       //echo "CALL " . $this->sproc_name . "('" . implode("', '", $this->param_array) . "');";
        $result = mysqli_query($connect, "CALL " . $this->sproc_name . "('" . implode("', '", $this->param_array) . "');") or die(mysqli_error($connect));
        if (!empty($result) && $result != null && !is_bool($result)) {
            $this->numrows = mysqli_num_rows($result);
        }
        else {
            $this->numrows = 0;
        }
        $OBJCONNECT->MyDisConnectDB();
        return $result;
    }
    
    public function SelectQuery() {
        $OBJCONNECT = new class_settings();
        $connect = $OBJCONNECT->MyConnectDB();
        $result = mysqli_query($connect, $this->sproc_name) or die(mysqli_error($connect)); 
        if (!empty($result) && $result != null) {
            $this->numrows = mysqli_num_rows($result);
        }
        else {
            $this->numrows = 0;
        }
        $OBJCONNECT->MyDisConnectDB();
        return $result;
    }
    
    public function EscapeString($input){
        $OBJCONNECT = new class_settings();
        $connect = $OBJCONNECT->MyConnectDB();
        $input = mysqli_real_escape_string($connect,$input);
        return $input;
    }


    public function ExecuteQuery() {
        $OBJCONNECT = new class_settings();
        $connect = $OBJCONNECT->MyConnectDB();
        $result = mysqli_query($connect, $this->sproc_name) or die(mysqli_error($connect)." - ".$this->sproc_name);
        $this->genrate_id = mysqli_insert_id($connect);
        $this->numrows = mysqli_affected_rows($connect);
        $OBJCONNECT->MyDisConnectDB();
        return $this->numrows;
    }

    public function getGeneratedId(){
        return $this->genrate_id;
    }
    
    public function getNumRows() {
        return $this->numrows;
    }
    
    public function getGenratedId(){
         return $this->genrate_id;
    }
	
}

?>
