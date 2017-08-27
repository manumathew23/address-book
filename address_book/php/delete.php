<?php
include "class/AddressBook.php";
if (isset($_POST['delete'])) {
	$letter = $_GET['letter'];
	$id = $_POST['contact_chk'];
	$delobj = new AddressBook();
	$result = $delobj->deleteAddress(
		'contact_address',
		 $id
		);
	header("location:homepage.php?letter=<?php echo $letter; ?>");
}
?>
