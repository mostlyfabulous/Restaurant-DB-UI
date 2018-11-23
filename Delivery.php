<PHP><link rel="stylesheet" type="text/css" href="enjoy.css"></head><PHP>
<?php include 'Utility.php'; ?>
<h>Delivery PHP table</h><a href="index.php">Index page</a>
<br><br>
<!-- <p>Input your driverID to orders to deliver:</p> -->
<form method="GET" action="Delivery.php">
Input your driverID to orders to deliver:
   <p><input type="text" name="driverID" size="7"placeholder="DriverID">
<!--define two variables to pass the value-->

<input type="submit" value="submit" name="vieworderssubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to
get the values-->

<br><br>
<!-- <p> Update the order when delivered: </p> -->
<form method="GET" action="Delivery.php">
Update the order when delivered:
   <p><input type="text" name="driverID" size="7" placeholder="DriverID">
     <input type="text" name="orderID" size="7" placeholder="OrderID">
     <input type="text" name="deliveryTime" size="20" placeholder="Delivery Time (format: YYYY-MM-DD)">
     <input type="submit" value="submit" name="updatesubmit"></p>
<!--define two variables to pass the value-->

</form>
<br><br>
<?php

//this tells the system that it's no longer just parsing
//html; it's now parsing PHP

$success = True; //keep track of errors so it redirects the page only if there are no errors


// Connect Oracle...
if ($db_conn) {
	if (array_key_exists('vieworderssubmit', $_GET)) {
      $result = executePlainSQL("select * from TakeoutOrder where driverID='" .$_GET['driverID'] . "' and deliveryTime is null");
      printToDeliver($result);
    } else
			if (array_key_exists('updatesubmit', $_GET)) {
        $result = executePlainSQL("update TakeoutOrder set deliveryTime= '" .$_GET['deliveryTime'] . "' where driverID='" .$_GET['driverID'] . "' and  orderID='" .$_GET['orderID'] . "'");
        printDelivery($result);

			}

	if ($_POST && $success) {
		header("location: Delivery.php");
	} else {
    $result = executePlainSQL("select * from TakeoutOrder");
		printDelivery($result);
	}
	pg_close($db_conn);
} else {
	echo "cannot connect";
	$e = pg_last_error();
	echo htmlentities($e);
}

?>
