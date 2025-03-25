<?php
include 'connecttodb.php';
$price = $_POST["price"];
$caloriecount = $_POST["caloriecount"];
$menuitemid = $_POST["menuitemid"];

$price = floatval($price);
$caloriecount = intval($caloriecount);

$query = "UPDATE menuitem SET price=" . $price . ", caloriecount=" . $caloriecount . " WHERE menuitemid='" . $menuitemid . "'";
$result = mysqli_query($connection, $query);
if (!$result) {
	die("Could not update to the database");
}
header('Location: mainmenu.php');
exit;
?>
