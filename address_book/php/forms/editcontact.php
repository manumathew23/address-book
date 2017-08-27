<?php
require_once('../public/header.php');
require_once('../public/navbar.php');
require_once('../class/AddressBook.php');

if (isset($_POST['edit'])) {   
    $obj = new AddressBook($_POST);  
    $validate = $obj->validate();
    $error = $validate['errorMsg'];
    if ($validate['error'] != 0 ) {     
        $result = $obj->updateAddress(
            'contact_address', 
            'contact_id ='.$id
            );
         header("location:../homepage.php?action=view&letter=A");
   } 
 
}
if ($_GET['action'] == "edit") {  
    $id =  $_GET['id'];
    $obj = new AddressBook();
    $result = $obj->listAddress('contact_address', 
        array(
            'contact_id', 
            'name', 
            'age', 
            'address', 
            'city', 
            'phone_no', 
            'country_id', 
            'pin' ), 
        "contact_id = '$id'");

    foreach ($result as $row) { 
        $name = $row['name']; 
        $age = $row['age']; 
        $address = $row['address'];
        $city = $row['city'];
        $country_id = $row['country_id'];       
        $phone = $row['phone_no'];
        $pin = $row['pin'];
    } 
    $names = explode(" ", $name);   // to split name into fname, mname and lname
    // to get the selcted country name from Database
    $countryselect = $obj->listaddress('country', array('country'), "country_id = '$country_id'" );
    foreach ($countryselect as $row) {
        $countrySelected = $row['country'];
    }
}
        
?>        
          
<html lang = "en">
    <head>
        <meta charset = "utf-8">
        <script type = "text/javascript" src = "http://code.jquery.com/jquery.min.js"></script>
        <title>Add contact </title>
        <link rel = 'stylesheet' href = '../stylesheet/stylesheet.css' type = 'text/css' />         
        <script  type = "text/javascript" src = "../js/main.js"></script> 
    </head>
    <body>
        <div class = "formdiv">
        <h1>Edit Contact</h1>
        <?php if (isset($error)) { ?> <h5 class = "error"> <?php echo $error?> </h5> <?php }?> 
        <form name = "editcontact" method = "post" action = "editcontact.php?action=edit&id=<?php echo $id;?>" >
        <ul>
            <li>
                <label>First Name: </label>
            </li>
            <li>
                <input type = "text" size = "25" id = "fname" name = 'fname' value = '<?php echo $names[0];  ?>' 
                    title = "Alphabets only" required/><h5 class = "error">*</h5></li><br>
            <li>
                <label>Middle Name: </label>
            </li>
            <li>
                <input type = "text"  size = "25" id = "mname" name = 'mname' value = '<?php echo $names[1];  ?>' 
                    title = "Alphabets only" />
            </li><br>
            <li>
                <label>Last Name: </label>
            </li>
            <li>
                <input type = "text"  size = "25" id = "lname" name = 'lname' value = '<?php echo $names[2];  ?>'
                    title = "Alphabets only" />
            </li><br>
            <li>
                <label>Date of Birth:</label>
                <select id = "date" name = 'date' value = ""></select>
                <script>document.getElementById("date").innerHTML = displayDate();</script>
                <select id = "month" name = 'month' > </select>
                <script> document.getElementById("month").innerHTML = displayMonth();</script>
                <select id = "year" name = 'year'> </select>
                <script>document.getElementById("year").innerHTML = displayYear();</script>
            </li>
            <li>
                <label>Address: </label>
                <!-- Keep <textarea> & </textarea> in same line -->
                <textarea id = "address" name = 'address' required rows = "4" cols = "50" ><?php echo $address;  ?></textarea>
                <br><br><br><h5 class = "error">*</h5><br><br><br><br>
            </li>    
                <li>
                    <label>Country:</label>
                    <?php
                        // Retrieves country name and id from database

                        $menuobj = new AddressBook();
                        $countryNames = $menuobj->listAddress('country', 
                            array(
                                'country_id', 
                                'country'), 
                            null);
                        echo  '<select name = "country">';
                        foreach ($countryNames as $row) {
                            if ($countrySelected == $row["country"]){   
                                echo '<option value = "'.$row["country_id"].'" selected = "selected">'
                                    .$row["country"].
                                    '</option>';
                            } else {
                                echo '<option value = "'.$row["country_id"].'">'.$row["country"].'</option>';
                            } 
                        }
                        echo '</select>';
                    ?>
                </li>
                <li>
                    <label>City </label>
                </li>
                <li>
                    <input type = "text"  size = "25" id = "city" name = 'city' value = '<?php echo $city; ?>' 
                        title = "Alphabets only" required /><br><br><h5 class = "error">*</h5>
                </li>
                <li>
                    <label>Pin code </label>
                </li>
                <li>
                    <input type = "text" size = "25" id = "pin" name = 'pin' value = '<?php echo $pin; ?>' /> 
                 </li>  
                <li>
                    <label>Phone no: </label></li>
                <li>
                    <input type = "text" size = "25" id = "phone" name = 'phone' value = '<?php echo $phone; ?>' 
                        title = "" required />
                </li><br><br><br><br><h5 class = "error">*</h5><br>       
                <li><input type = "submit" name = "edit" value = "  Submit " id = "edit" /></li>
        </ul>
        </form>                
        </div>
    </body>  
</html>
