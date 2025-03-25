<!-- Programmer Name: 96 -->
<!-- The main page that will let the user access all of the options required for the assignment -->
<!DOCTYPE html>
<html>
<head>
	<title>Menu Website</title>
	<link rel="stylesheet" href="style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<body>
	<?php
		include "connecttodb.php";
	?>
	<h1>Menu Site</h1>
	<p>Read the menu, add items, and order from the menus below!</p>

	<hr>
	<hr>

	<h2>All Menu Items</h2>
	<form action="listitems.php" method="post">
		<p>How would you like to order the menu:</p>
		<input type="radio" id="dishname" name="orderdishes" value="dishname">
		<label for="dishname">Name</label><br>
		<input type="radio" id="price" name="orderdishes" value="price">
                <label for="price">Price</label>

		<br>

		<p>Order ascending or descending?</p>
		<input type="radio" id="ASC" name="ascdes" value="ASC">
                <label for="asc">Ascending</label><br>
		<input type="radio" id="des" name="ascdes" value="DESC">
		<label for="des">Descending</label>
		<br>
		<br>
		<input type="submit" value="Display Menu!">
	</form>
<!--This will be to insert a new order-->
	<br>
	<hr>
	<hr>

	<h2>Insert a new Order</h2>
	<form action="addmenuitem.php" method="post">
		<p>Insert the new order ID*</p>
		<input type="text" name="orderid" required> 
		<br>

		<p>Insert the delivery address*</p>
		<input type="text" name="deladdress" required>
		<br>

		<p>Insert the date of the order*</p>
		<input type="date" name="dateplaced" required>
		<br>

		<p>Insert the time the order was placed*</p>
		<input type="time" name="timeplaced" required>
		<br>

		<p>Insert the time the order was delivered</p>
                <input type="time" name="timedelivered">
                <br>

		<p>Was the order picked up?*</p>
                <input type="radio" name="pickup" value="Y" required>
		<label for="pickup">Yes</label>
                <br>
		<input type="radio" name="pickup" value="N">
		<label for="pickup">No</label>
		<br>

		<p>Enter a delivery rating</p>
		<input type="radio" name="deliveryrating" value="1">
		<label for="deliveryrating">1</label>
                <br>
		<input type="radio" name="deliveryrating" value="2">
                <label for="deliveryrating">2</label>
                <br>
		<input type="radio" name="deliveryrating" value="3">
                <label for="deliveryrating">3</label>
                <br>
		<input type="radio" name="deliveryrating" value="4">
                <label for="deliveryrating">4</label>
                <br><input type="radio" name="deliveryrating" value="5">
                <label for="deliveryrating">5</label>
                <br>
		<br>

		<select name="driverid">
			<option value = "0">Choose a driver</option>
		<?php
			$query = "SELECT DISTINCT driverid FROM driver";
			$result = mysqli_query($connection, $query);
			if (!$result) {
				die("database query failed to get driver");
			}
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value='" . htmlspecialchars($row["driverid"]) . "'>" . $row["driverid"] . "</option><br>";
			}
			mysqli_free_result($result);
		?>
		</select>
		<br>
		<br>

		<select name="cusid" required>
		<option value="0">Choose a Customer*</option>
		<?php
			$query = "SELECT cusid FROM customer";
			$result = mysqli_query($connection, $query);
			if (!$result) {
				die("Data base failed to get customer");
			}
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value='" . htmlspecialchars($row["cusid"]) . "'>" . $row["cusid"] . "</option><br>";
			}
			mysqli_free_result($result);
		?>
		<br>
		</select>
		<br>
		<br>

		<select name="menuitemid" required>
		<option value="0">Choose a Menu Item*</option>
		<?php
			$query = "SELECT menuitemid, dishname FROM menuitem";
			$result = mysqli_query($connection, $query);
			if (!$result) {
				die("Data base failed to get menuitem");
			}
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value='" . htmlspecialchars($row["menuitemid"]) . "'>" . $row["dishname"] . "</option><br>";
			}
			mysqli_free_result($result);
		?>
		</select>
		<br>

		<p>Enter the number of that dish you would like to order*</p>
		<input type="number" name="quantity" step="1" required>
		<br>
		<br>

		<input type="submit" value="Add Order!">
	</form>

<!--Deleting a menu item-->
	<br>
	<hr>
	<hr>
	<h2>Delete a menu item</h2>
	<form action="deletemenuitem.php" method="post" id="deleteform">
		<select name="menuitemid">
		<option value="0">Choose a Menu Item to Delete</option><br>
	<?php
		$query="SELECT dishname, menuitemid FROM menuitem";
		$result = mysqli_query($connection, $query);
		if (!$result) {
			die("Data base failed to get customer");
		}
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<option value='" . htmlspecialchars($row["menuitemid"]) . "'>" . $row["dishname"] . "</option><br>"; 
		}
		mysqli_free_result($result);
	?>
		<br>
		</select>
		<br>
		<br>
		<button class="return"  onclick="check()" type="button">Delete a menu item</button>
	</form>
	<!-- Creating a javascript form to confirm -->
	<script>
	function check() {
		if (!confirm("Are you sure you want to delete this item?")) {
			return false;
		}
		document.getElementById('deleteform').submit();
	}
	</script>

<!-- Modify an existing menuitem-->
	<br>
	<br>
	<hr>
	<hr>
	<h2>Modify an existing menu item</h2>
	<form action="updateitem.php" method="post">
		<p>Enter the menuitemid to change, can also do a drop down menu</p>
                <select name="menuitemid">
		<option value="0">Choose a Menu Item to Update</option><br>
	<?php
                $query="SELECT dishname, menuitemid FROM menuitem";
                $result = mysqli_query($connection, $query);
                if (!$result) {
                	die("Data base failed to get customer");
                }
                while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars($row["menuitemid"]) . "'>" . $row["dishname"] . "</option><br>";
                }
                mysqli_free_result($result);
	?>
		<br>
		</select>
		<p>Change the price of the item</p>
		<input type="number" step="0.01"  name="price">
		<br>
		<p>Change the calories of the item</p>
		<input type="number" name="caloriecount">
		<br>
		<br>
		<input type="submit" name="Update an item">
	</form>

<!--Display first and last name of any driver without a delivery -->
	<br>
	<hr>
	<hr>
	<h2>Displaying the drivers below using SQL query</h2>
	<?php
		include "drivernodel.php"; 
	?>

<!--Select an order and see everything about that order-->
	<br>
	<hr>
	<hr>
	<h2>Displaying the specific orders below</h2>
	<form action="displayorder.php" method="post">
	<select name="pickorder">
		<option value="0">Choose an Order</option>
	<?php
		$query = "SELECT DISTINCT orderid FROM cusorder";
		$result = mysqli_query($connection, $query);
		if (!$result) {
			die("database query failed");
		}
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<option value='" . htmlspecialchars($row["orderid"]) . "'>" . $row["orderid"] . "</option> <br>"; 
		}
		mysqli_free_result($result);
	?>
	</select>
	<br>
	<br>
	<input type="submit" value="See a specific order">
	<br>
	<br>
	<br>
	<br>
	<br>
</body>
</html>
