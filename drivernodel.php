<!-- Programmer Name: 96 -->
<!-- Using the query we found in assignment 2 to list all of the drivers who have not delivered anything -->
<?php
$query="SELECT firstname, lastname, driverid FROM driver WHERE driverid NOT IN (SELECT driverid FROM cusorder WHERE pickuporder='N')";
$result = mysqli_query($connection,$query);
 if (!$result) {
 die("databases query failed.");
 }
 while ($row = mysqli_fetch_assoc($result)) {
 	echo "Firstname: " . $row["firstname"] . ", Lastname: " . $row["lastname"] . ", DriverID: " . $row["driverid"] . "<br>";
 }
 mysqli_free_result($result);

?>
