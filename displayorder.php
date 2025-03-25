<!--//Programmer Name: 96 -->
<!--//Getting all of the orders placed, the driver if there is one, customer, and price of all items -->
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
	<title>View Order</title>
</head>

<body>
<?php
	include "connecttodb.php";
	$orderid = $_POST["pickorder"];
	//Splitting up the queries because it would be too long otherwise
	$qdriver = "SELECT driver.firstname AS dfname, driver.lastname AS dlname FROM driver JOIN cusorder ON driver.driverid=cusorder.driverid WHERE cusorder.orderid='" . $orderid . "'";
        $qcust = "SELECT customer.firstname AS cfname, customer.lastname AS clname FROM customer JOIN cusorder ON customer.cusid=cusorder.cusid WHERE cusorder.orderid='" . $orderid . "'";
        $qcusorder = "SELECT * FROM cusorder WHERE cusorder.orderid='" . $orderid . "'";
        $qorderdetails = "SELECT quantity, price, dishname FROM overallorder, menuitem WHERE menuitem.menuitemid=overallorder.menuitemid AND overallorder.orderid='" . $orderid . "'";
	$result1 = mysqli_query($connection, $qdriver);
        $result2 = mysqli_query($connection, $qcust);
        $result3 = mysqli_query($connection, $qcusorder);
	$result4 = mysqli_query($connection, $qorderdetails);
        if (!$result1) {
                var_dump($connection);
                die("database request on result 1. ");
        }
        if (!$result2) {
                var_dump($connection);
                die("QCust failed");
        }
        if (!$result3) {
                var_dump($connection);
                die("Qcusorder failed");
        }
	if (!$result4) {
		var_dump($connection);
		die("Order details failed");
	}
	$row2 = mysqli_fetch_assoc($result2);
	$row1 = mysqli_fetch_assoc($result1);
	$row3 = mysqli_fetch_assoc($result3);
	echo "<h1>Information about the Order</h1>";
	//CHecking if there is any driver information
	if (isset($row1["dfname"]) && isset($row1["dlname"])) {
		echo "<ul><li>Driver: " . $row1["dfname"] .  " " . $row1["dlname"] . "</li>";
		echo "<li>Driver Rating: " . $row3["deliveryrating"] . "</li>";
	} else {
		echo "<ul><li>Order was picked up, no driver information</li>";
	}
	echo "<li>Customer: " . $row2["cfname"] . " " . $row2["clname"] . "</li>";
	echo "<li>Date: " . $row3["dateplaced"] . "</li>";
	echo "<li>Time Placed: " . $row3["timeplaced"] . "</li>";
	echo "<li>Time Delivered: " . $row3["timedelivered"] . "</li>";
	$pricesum = 0;
	$tempprice;
	//Looping through the items in overallorder
	while ($rowdetails = mysqli_fetch_assoc($result4)) {
		$tempprice = (float)$rowdetails["price"] * (float)$rowdetails["quantity"];
		echo "<li>" . $rowdetails["dishname"] . " - $" . $rowdetails["price"];
		echo "<ul><li>Quantity: " . $rowdetails["quantity"] . "</ul></li>";
		$pricesum = $pricesum + $tempprice;
	}
	echo "<li>Total Price of Order: $" . $pricesum . "</li>";
	echo "</ul>";
	mysqli_free_result($result1);
	mysqli_free_result($result2);
	mysqli_free_result($result3);
	mysqli_free_result($result4);
?>
<a href="javascript:history.go(-1)">Go Back to Main Page</a>
</body>
</html>
