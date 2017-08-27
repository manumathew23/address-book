<?php
include_once "DataBase.php";
class AddressBook 
{   
    public function __construct() 
    {      
        $argv = func_get_args();
        switch (func_num_args()) {
         case 0:
            self::__construct1();
            break;
        case 1:
            self::__construct2($argv[0]);
           break;
         }
    }

    public function __construct1()
    {         
        $this->db = new DataBase();                   
    }

    public function __construct2($postData)
    {
        $this->db = new DataBase();
        $this->fname = trim(@$postData['fname']);
        $this->mname = trim(@$postData['mname']);
        $this->lname = trim(@$postData['lname']);
        $this->date = @$postData['date'];
        $this->month = @$postData['month'];
        $this->year = @$postData['year'];
        $this->age = date("Y") - @$postData['year'];
        $this->address = @$postData['address'];
        $this->country = @$postData['country'];
        $this->city = @$postData['city'];
        $this->phone = @$postData['phone'];
        $this->pin = @$postData['pin'];
        $this->name = $this->fname . " " . $this->mname . " " . $this->lname;  
    }

           
    public function validate()
    {
        $error = 1;
        $errorMsg = "";
        if (empty($this->name)) {
            $errorMsg =  "Please enter a name.";
           $error= 0; 
        } elseif (($this->date == "date") OR ($this->month == "month") OR ($this->year == "year")) {
            $errorMsg =  "Please select a date";
            $error = 0;  
        } elseif (empty($this->address)) {
            $errorMsg =  "Please enter an address";
            $error = 0;
        } elseif ($this->country == "country") {
            $errorMsg =  "Please select a country";
            $error = 0;
        } elseif (empty($this->city)) {
        $errorMsg =  "Please enter a name.";
            $error = 0;
        } elseif (empty($this->phone)) {
            $errorMsg =  "Please enter a Phone number";
            $error = 0;
        } elseif ((strlen(trim($this->name)) < 3) OR (strlen(trim($this->name)) > 30)) { 
            //trim name to avoid counting white spaces
            $errorMsg = "Please enter a name with 3-30 characters in length";
            $error = 0;
        } elseif (!(preg_match("/^[a-zA-Z ]+$/i", $this->name))) {
           $errorMsg = "Please enter a valid name";
           $error = 0;
        } elseif (!(checkdate($this->month, $this->date, $this->year))) {
            $errorMsg = "Please enter a valid date";
            $error = 0;
        } else if ((strlen($this->city) < 3) OR (strlen($this->city) > 30)) {
          $errorMsg = "Please enter a valid city";
           $error = 0;      
        } elseif ((!(strlen($this->phone) == 10)) OR (!(is_numeric($this->phone)))) {
            $errorMsg  = "Please enter a valid phone number" ;
            $error = 0;
        } elseif (!empty($this->pin)) {
            if(!(strlen($this->pin) == 6)) {
              $errorMsg  = "Please Enter all 6 digits of Zip Code" ;
              $error = 0;
            } elseif (!(is_numeric($this->pin))) {
              $errorMsg = "Please Enter a valid Zip Code";
              $error = 0;
            } 
        }    
        return array('error' => $error, 'errorMsg' => $errorMsg);      
} 


public function addAddress($table) 
{
    $this->db->insert(
        $table, 
        array(
            'name' => $this->name, 
            'age' => $this->age, 
            'address' => $this->address, 
            'city' => $this->city, 
            'phone_no' => $this->phone, 
            'country_id' => $this->country, 
            'pin' => $this->pin
        ));
    
}
public function updateAddress($table, $where) 
{
    $this->db->update(
        $table, 
        array(
            'name' => $this->name, 
            'age' => $this->age, 
            'address' => $this->address, 
            'city' => $this->city, 
            'phone_no' => $this->phone, 
            'country_id' => $this->country, 
            'pin' => $this->pin
        ), 
        $where
        );
}
public function deleteAddress($table, $id) 
{

    $this->db->delete($table, $id);

}
public function listAddress($table, $fields, $where)
{

    $result = $this->db->select($table, $fields, $where);
    return $result;
}
}
?>
