<?php
require_once('../public/header.php');
require_once('../public/navbar.php');
require_once('../class/AddressBook.php');
    
$error = null;

//To add new submitted data to database
if (isset($_POST['submit'])) {   
    $obj = new AddressBook($_POST);   
    $validate = $obj->validate();
    $error = $validate['errorMsg'];
    if ($validate['error'] != 0 ) {        
        $obj->addAddress('contact_address');
   }   
} 
?>
<!DOCTYPE html>
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
            <h1>New Contact</h1>
            <?php if (isset($error)) { ?> <h5 class = "error"> <?php echo $error?> </h5> <?php }?> 
            <form name = "addcontact" method = "post" action = "<?php echo $_SERVER['PHP_SELF']; ?>" >
                <ul>
                    <li>
                        <label>First Name: </label>
                    </li>
                    <li>
                        <input type = "text" size = "25" id = "fname" name = 'fname'
                    		title = "Alphabets only" required /><h5 class = "error">*</h5>
                    </li>        
                    <br>                 
                    <li>
                        <label>Middle Name: </label>
                    </li>
                    <li>
                        <input type = "text"  size = "25" id = "mname" name = 'mname'  
                             title = "Alphabets only"/>
                    </li>
                    <br>               
                    <li>
                        <label>Last Name: </label>
                    </li>
                    <li>
                        <input type = "text"  size = "25" id = "lname" name = 'lname' 
                            title = "Alphabets only" />
                    </li>
                    <br>  
                    <li>
                        <label>Date Of Birth: </label>
                        <select id = "date" name = 'date' ></select>
                        <script>
                        document.getElementById("date").innerHTML = displayDate(); //returns dropdown with dates 1 - 31
                        </script>
                        <select id = "month" name = 'month' > </select>
                        <script>
                        document.getElementById("month").innerHTML = displayMonth(); //returns dropdown with month 1 - 12
                        </script>        
                        <select id = 'year' name = 'year' > </select>
                        <script>
                        /* Returns dropdown with years cureent year - (current year-120) */
                        document.getElementById("year").innerHTML = displayYear(); 
                        </script>
                    </li>
                    <br><br>                
                    <li>
                        <label>Address: </label>
                        <textarea id = "address" name = 'address'  rows="3" cols="50" 
                             value = "" required></textarea><li>
                        <br><h5 class = "error">*</h5><br><br><br><br><br><br>
                    <li>
                        <label>Country:</label>
                        <?php
                        //To retrieve name and id of country from database 
                	       $menuobj = new AddressBook();
                	       $result = $menuobj->listAddress(
                                    'country', 
                                    array(
                                        'country_id', 
                                        'country'
                                    ), 
                                    null);
                	       echo '<select name = "country" value = "" >';
                	       echo "<option>country</option>";
                	       foreach ($result as $row) {
                	           echo '<option value = "'.$row["country_id"].'" >'.$row["country"].'</option>';
                	       }
                	       echo '</select>';
                        ?>
                        <h5 class = "error">*</h5>
                    </li>
                    <li>
                            <label>City </label>
                    </li>
                    <li>
                        <input type = "text" size = "25" id = "city" name = "city" 
                            title = "Alphabets only" required/>
                        <h5 class = "error">*</h5>
                    </li>  
                    <li>
                        <label>Pin code </label>
                    </li>
                    <li>
                         <input type = "textfield" size = "25" id = "pin" name = "pin" 
                                title = "Numbers only"/>
                    </li><br>
                    <li>
                        <label>Phone no: </label>
                    </li>
                    <li>
                        <input type = "textfield" size = "25" id = "fname" name = "phone" 
                                title = "Only Numbers allowed" required />
                        <br> <h5 class = "error">*</h5>
                    </li>        
                    <br>
                    <input style = "float:left" type = "submit" name = "submit" value = "submit" id = "submit" />                
                </ul> 
            </form> 
        </div>
    </body>
</html>
