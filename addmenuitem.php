<!-- Programmer Name: 96 -->
<!-- The point of this program is to create the customer order that will go into cusorder and then validate it, after that the user will be allowed to add menu items to their order -->
<!DOCTYPE html>

<html>

<head>
	<link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
	<title>New Order</title>
</head>
<body>
<?php
include 'connecttodb.php';
function printValues($connection, $oid, $menuitem, $quantity) {
	$query = "SELECT price, dishname FROM menuitem WHERE menuitemid='$menuitem'";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		die("Error in method printing out the values");
	}

	$values = mysqli_fetch_assoc($result);
	echo "<h2>Printing out the new Order</h2>";
	echo "<strong>New Order<strong>";
	echo "<ul><li>Order ID: " . $oid . "</li>";
	echo "<li>Menu Item: " . $values["dishname"] . "</li>";
	echo "<li>Price per Item: " . $values["price"] . "</li>";
	echo "<li>Quantity: " . $quantity . "</li>";
	echo "<li>Total Price: " . ($values["price"] * $quantity) . "</li></ul>";
}

//Getting the variables from the form
$oid = $_POST["orderid"];
$add = $_POST["deladdress"];
$date = $_POST["dateplaced"];
$placed = $_POST["timeplaced"];
$del = $_POST["timedelivered"] ?? null;
$pickup = $_POST["pickup"];
$rating = $_POST["deliveryrating"] ?? null;
$did = $_POST["driverid"] ?? null;
$quant = $_POST["quantity"];
$menuitem = $_POST["menuitemid"];
$cid = $_POST["cusid"];

//Creating the query to check if the orderid has already been placed 
$seenoid ="SELECT orderid FROM cusorder WHERE orderid='" . $oid . "'";
$oid_present = mysqli_query($connection, $seenoid);
if (!$oid_present) {
	die("Error with result 2 in adding item");
}

//Checking if all of the values are set if pickup is NULL
if (mysqli_num_rows($oid_present) > 0) {
	echo "Order id is not unique";
}
elseif ($quant < 0) {
	echo "Quantity is less than 0";
}
elseif (isset($del) && isset($rating) && isset($did) && isset($pickup) && $pickup=='N') {
	$datetimeplaced = new DateTime($placed);
	$datetimedelivered = new DateTime($del);

	if ($datetimeplaced > $datetimedelivered) {
		echo "Time placed came after time delivered";
	} else {
		//Creating the order with all values
		$query = "INSERT INTO cusorder VALUES ('$oid', '$add', '$date', '$placed', '$del', '$pickup', '$rating', '$did', '$cid')";
	        $resultcusorder = mysqli_query($connection, $query);
		if (!$resultcusorder) {
			die("Error while adding new item when driver not null");
		}

		//Creating the order id
		$queryoverall = "INSERT INTO overallorder VALUES ('$oid', '$menuitem', '$quant')";
		$resultoverall = mysqli_query($connection, $queryoverall);
		if (!$resultoverall) {
			die("Error while adding new overall order driver not null");
		}
		printValues($connection, $oid, $menuitem, $quant);
	}

} elseif (isset($pickup) && $pickup=='Y') { //If pickup is set to N then all driver information should be NULL even if the user set it
	$query = "INSERT INTO cusorder VALUES ('$oid', '$add', '$date', '$placed',NULL , '$pickup', NULL, NULL, '$cid')";
	$resultcusorder = mysqli_query($connection, $query);
	if (!$resultcusorder) {
                die("Error while trying to add new item driver null" . mysqli_error($connection));
        }

	$queryoverall = "INSERT INTO overallorder VALUES ('$oid', '$menuitem', '$quant')";
	$resultoverall = mysqli_query($connection, $queryoverall);
	if (!$resultoverall) {
		die("Error while adding new overall order driver null");
	}
	printValues($connection, $oid, $menuitem, $quant);

} else { //Any other situation will cause an error
	echo "Error, make sure all required fields filled";
}


mysqli_free_result($oid_present)
?>

<!-- Button to return -->
<br>
<a href="https://cs3319.gaul.csd.uwo.ca/vm142/a3toad/mainmenu.php"><button class="return">Go Back</button></a>

</body>
</html>
