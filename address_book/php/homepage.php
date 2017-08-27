<html>
<head>
    <link rel = "stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src = "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel = "stylesheet" type = "text/css" href = "../stylesheet/stylesheet.css" />
    <script language = "JavaScript" type = "text/javascript">
        function checkDelete(){
            return confirm('Are you sure?');
        }
    </script>

</head>
<body>
	<div id = "header">
    	<?php
        include('public/header.php');
    	?>
	</div>
	<div>  
    	<?php
        include('public/navbar.php');
    	?>
	</div>
	<div align = "center" id = "namelistbar">
    	<?php
        include('../html/namelistbar.html');
    	?>
	</div>
	<p>
		<div>
			<?php
			require_once "class/AddressBook.php";
			if (isset($_GET['action'])) {
				if ($_GET['action'] == 'view') {
					$obj = new AddressBook($_POST);
					$letter = $_GET['letter'];
					$result = $obj->listAddress(
						'contact_address',
						array(
							'contact_id', 
							'name',
							'address', 
							'city',
							'country_id', 
							'pin',  
							'phone_no'
						), 
						"name REGEXP '^$letter'" );		
			?>
			<form action = "delete.php?letter=<?php echo $letter; ?>" method  = "post" >
			<table border = "0px" width = "100%"  >
				<div style = "left-margin:5px">

				</div>
    			<tr style = "margin-left:10px">
                    <th width = "10%">
                        <input type = "submit" class = "btn btn-danger" name = "delete" 
                            value = "Delete" id = "delete"
                            onclick = "return checkDelete(<?php $row['contact_id']?>)" />
                    </th>
        		    <th width = "20%">NAME</th>
        		    <th width = "40%">ADDRESS</th>
        		    <th width = "20%">PHONE NUMBER</th>
        		    <th width = "10%"></th>
    			</tr>    
    			<?php
                /**
                 * Retrieves the name of coutry selected from database using the country_id
                 *Displays name, address and phone number
                 *Address displayed to user includes address, city, pin code and country
                 */
    			foreach ($result as $row) {
    				$country_id = $row['country_id'];
    				$countryselect = $obj->listaddress(
    					'country', 
    					array(
    						'country'
    					), 
    					"country_id = '$country_id'" );
    				foreach ($countryselect as $countryrow) {
        				$countrySelected = $countryrow['country'];
    				}
        			echo "<tr>
        				  <td>
        				    <input type = 'checkbox' style = 'margin-left:15px;' name = 'contact_chk[]' 
        					value = '{$row['contact_id']}'>
        				  </td>";
        			echo "<td>".$row['name']."</td>";
        			echo "<td><br>".$row['address']."<br>".$row['city']."<br>".$row['pin']."<br>".$countrySelected."</td>";
        			echo "<td>".$row['phone_no']."</td>";
        			echo "<td><a class='btn btn-primary' 
                        href='forms/editcontact.php?action=edit&id=".$row['contact_id']."' role='button'>Edit</a></td>"; 
        			echo "</tr>";
    			} 
			}  
			} else {
				header("location:homepage.php?action=view&letter=A");
			}
			?>
			</div>
		</table>
	</p>
</body>
</html>
