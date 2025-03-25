<!--Programmer Name: 96-->
<!--Listing all of the  menu items in the order specificed by the user -->
<?php
include "connecttodb.php";
?>
<!DOCTYPE html>

<html>
	<head>
		<title>Menu</title>
		<link rel="stylesheet" href="style.css">
        	<link rel="preconnect" href="https://fonts.googleapis.com">
       	 	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
	</head>
<body class="displaydishes">

<?php
//Because of the isset, if they user does not specify both, then nothing will show up
if (isset($_POST["orderdishes"]) && isset($_POST["ascdes"])) {
	$order = $_POST["orderdishes"]; //Will be name or price
	$sort = $_POST["ascdes"]; //Ascending or descending
	$query = "SELECT * FROM menuitem ORDER BY " . $order . " " . $sort;
	$result = mysqli_query($connection,$query);
	if (!$result) {
		var_dump($connection);
		die("databases query failed.");
	}
	echo "<h3>Menu Items Printed Below</h3>";
	echo "<ul>";
	while ($row = mysqli_fetch_assoc($result)) { //listing the menu items in an unordered list
		echo "<br><li><strong>" . $row["dishname"] . "</strong> - $" . $row["price"];
		echo "<ul>";
		echo "<li>Calorie Count: " . $row["caloriecount"] . "</li>";
		echo "<li>Vegetarian: " . $row["veggie"] . "</li>";
		echo "<li>Menuitemid: " . $row["menuitemid"] . "</li></ul></li>";
	}
	echo "</ul>";
	mysqli_free_result($result);
}
?>
<a href="https://cs3319.gaul.csd.uwo.ca/vm142/a3toad/mainmenu.php"><button class="return">Go Back</button></a>

</body>
</html>

