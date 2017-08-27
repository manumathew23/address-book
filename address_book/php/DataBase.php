<?php
include('logger.php'); 
include('config.php');

class DataBase 
{
	private $connection;
	private $logobj;
	public function __construct()
	{   
		$path = PATH. date('m.d.y').".txt";
		$this->logobj = new LoggerClass($path, 'a+');		
    	$this->connection = new mysqli(SERVERNAME, USERNAME, PASSWORD);    	
    	if ($this->connection->connect_errno){
    		$this->logobj->log("Connection Fail ");     
		}
		$this->connection->select_db(DBNAME);
	}

	function insert($table, $data)
	{    
    	$keys = implode(', ', array_keys($data));
    	$i = 0; 
    	foreach ($data as $key => $value) {
            $datavalue[$i] = "'".$value."'";
        	$i++;
    	}
		$datavalues = implode(",", $datavalue);
		$query = 'INSERT INTO '.$table.'('.$keys.') VALUES ('.$datavalues.')';
		if (mysqli_query($this->connection,$query) === TRUE) {
    	    echo "<p style='color: green;'>New contact added</p>";
		} else {
		    $this->logobj->log("\n Record not inserted ");
		} 
	}

	function update($table, $data, $where)
	{
		$keys = implode(', ', array_keys($data));
		$value = implode(', ', array_values($data));
		$i = 0;
		foreach ($data as $key=>$value) {
    		$datavalue[$i] = $key."="."'".$value."'";
    		$i++;
		} 
		$datavalues = implode(",", $datavalue);
		$query = 'UPDATE '.$table.' SET '.$datavalues.' WHERE '.$where;
		mysqli_query($this->connection, $query);
		if (mysqli_query($this->connection,$query) === TRUE) {
    		return true;
		} else {
			$this->logobj->log("\n Record not updated");
		} 
	}
   
	function delete($table, $id)
	{
		$i=0; 
		foreach ($id as $key => $value) { 
			$exp[$i] = $value;
		 	$i++; 
	    	$query = "DELETE from ".$table." WHERE contact_id = ".$value;
    		mysqli_query($this->connection, $query);
    	}
 		if (mysqli_query($this->connection,$query) === FALSE) { 
 		     $this->logobj->log("\n Record not deleted");
 		}				 
	}

	function select($table, $selFields, $where)
	{   
    	$fields = implode(",", $selFields);
   		if ($where === null) {
        	$query = "SELECT ".$fields." FROM ".$table;
    	} else {
        	$query = "SELECT ".$fields." FROM ".$table." WHERE ".$where;
    	}  
        if (mysqli_query($this->connection, $query)) {
    	    $result = mysqli_query($this->connection, $query);
    	    $record =array();
    		while ($row = mysqli_fetch_assoc($result)) {
 			    $record[] = $row;
		    }
		return($record);
		} else {
			$this->logobj->log("\n Record not selected");
		}
	}
      
	public function __destruct()
	{
		if ($this->connection) {
    		$this->connection->close(); 
		}
	}
}
?>
