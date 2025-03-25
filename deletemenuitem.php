<!--Programmer Name: 96 -->
<!--Allowing the user to delete an item-->
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <title>Deletion Error</title>
    </head>
<body>

<?php
include 'connecttodb.php';
$menuitemid = $_POST["menuitemid"];
$orderitems = "SELECT menuitemid FROM overallorder WHERE menuitemid='" . $menuitemid . "'";

$resultoforder = mysqli_query($connection, $orderitems);
if (!$resultoforder) {
	die("Error accessing the item");
}

if (mysqli_num_rows($resultoforder) == 0) {
	$query = "DELETE FROM menuitem WHERE menuitemid='" . $menuitemid . "'";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		die("Error with deletion query");
	}
	header('Location: mainmenu.php');
	exit;
} else {
	echo "Cannot remove this item, choose an item NOT in an order";
}
mysqli_free_result($resultoforder);
?>
<a href="https://cs3319.gaul.csd.uwo.ca/vm142/a3toad/mainmenu.php"><button class="return">Go Back</button></a>

</body>
</html>
