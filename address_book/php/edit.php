<?php
    require_once('class/AddressBook.php');

$error = null;
$id = $_GET['id'];
if (isset($_POST['edit'])) {   
    $obj = new AddressBook($_POST);  
    $validate = $obj->validate();
    $error = $validate['errorMsg'];
    if ($validate['error'] != 0 ) {     
        $result = $obj->updateAddress(
        	'contact_address', 
        	'contact_id ='.$id
        	);
 		 header("location:homepage.php?action=view&letter=A");
   } else {
   			$action = "edit";
   			include("forms/editcontact.php");   		
   }
 
}
 

?>
