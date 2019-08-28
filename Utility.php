<!--Project for CPSC 304, Group 12 - W1 2018 session, migrated from Oracle to
PostgreSQL by Andrew Wong-->

<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = pg_connect(getenv("DATABASE_URL"));
// $db_conn = pg_connect("host=localhost port=5432 dbname=Andrew user=Andrew" ) or die("Could not connect");
$stat = pg_connection_status($db_conn);
  if ($stat === PGSQL_CONNECTION_OK) {
      echo '<h>Connection status ok</h><br><br>';
  } else {
      echo '<h>Connection status bad</h><br><br>';
  }

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	// $statement = OCIParse($db_conn, $cmdstr);
	// pg_prepare($statement, $cmdstr);
	// if (!$statement) {
	// 	echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
	// 	// $e = OCI_Error($db_conn); // For OCIParse errors pass the
	// 	$success = False;
	// }
	$r = pg_query($db_conn, $cmdstr);
	// $r = OCIExecute($statement, OCI_DEFAULT); //returns true or false
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		// $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		$e = pg_last_error($db_conn);
		echo htmlentities($e);
		// echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $r;

}

function executeBoundSQL($cmdstr, $list) {
	/* Sometimes the same statement will be executed for several times ... only
	 the value of variables need to be changed.
	 In this case, you don't need to create the statement several times;
	 using bind variables can make the statement be shared and just parsed once.
	 This is also very useful in protecting against SQL injection.
      See the sample code below for how this functions is used */

	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

	foreach ($list as $tuple) { //for each tuple in the list of tuples
		foreach ($tuple as $bind => $val) { //for each bound variable in a tuple
			// echo $val."<br>";
			// echo gettype($val)."<br>";
			// echo strlen($val)."<br>";
			// echo "<br>".$bind."<br>";
			OCIBindByName($statement, $bind, $val ,$maxlength = 30 , $type = SQLT_CHR );
			unset ($val); //make sure you do not remove this. Otherwise $val will
      // remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statement handle
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
	}
	return $statement;
}

function printResult($result) {
	echo "<table style='float: left'>";
  echo "<caption>Got data from table OrderHas:</caption>";
	echo "<tr><th>OrderID</th><th>MenuItemID</th></tr>";

	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row["orderid"] . "</td><td>" . $row["menuitemid"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";

}

function printOrder($result, $orderid) {
	echo "<table>";
  echo "<caption>Retrieved Order Details
				for OrderID: " . $orderid . "</caption>";
	echo "<tr><th>MenuItemID</th><th>ItemName</th></tr>";

	while ($row = pg_fetch_array($result)) {
		// <td>" . $row["ORDERID"] . "</td>
		echo "<tr>
							<td>" . $row["menuitemid"] . "</td>
							<td>" . $row["itemname"] . "</td>
							</tr>";
	}
	echo "</table>";

}

function printMenuItems($result, $bid) {
	echo "<table>";
  echo "<caption> Menu Items from Branch: ". $bid ."</caption>";
	echo "<tr><th>MenuItemID</th><th>Name</th></tr>";

	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row["menuitemid"] . "</td><td>" . $row["itemname"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";

}

function printBranches($result) {
	echo "<table>";
  echo "<caption>All Branches:</caption>";
	echo "<tr><th>Branch ID</th><th>Address</th><th>City</th></tr>";
	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row["branchid"] . "</td><td>" . $row["address"] . "</td><td>" . $row["city"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function dropdownBranches($result) { //adds results from a select statement
	echo "<br><select name='selectbid'>";
	echo "<option value='0'>Please Select a Branch</option>";
	while ($row = pg_fetch_array($result)) {
		echo "<option value =" . $row['branchid'] . ">" . $row['branchid'] . "</option>";
	}
	echo "</select><br>";
}

function dropdownIngredients($result) { //adds results from a select statement
	echo "<br><select name='selIngredient'>";
	echo "<option value='0'>Choose an ingredient</option>";
	while ($row = pg_fetch_array($result)) {
		echo "<option value =" . $row['ingredientname'] . ">" . $row['ingredientname'] . "</option>";
	}
	echo "</select><br>";
}

function printIngredientsByBranch($result, $bid) {
	echo "<table>";
	echo "<caption>Ingredients at Branch: " . $bid . "</caption>";
	echo "<tr><th>Ingredient Name</th><th>Quantity Left</th><th>Expiry Date</th></tr>";
	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row["ingredientname"] . "</td><td>" . $row["quantityleft"] . "</td><td>" . $row["expirydate"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printIngredientsExpiring($result, $bid) {
	echo "<table>";
	echo "<caption>Ingredients at Expiring on: " . $bid . "</caption>";
	echo "<tr><th>Ingredient Name</th><th>Quantity Left</th><th>Expiry Date</th></tr>";
	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row["ingredientname"] . "</td><td>" . $row["quantityleft"] . "</td><td>" . $row["expirydate"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printCountEmployeesByBID($result) {
	echo "<table>";
  echo "<caption>Total Employees at a Branch:</caption>";
	echo "<tr><th>Branch ID</th><th>Number of Employees</th></tr>";

	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row["branchid"] . "</td><td>" . $row["count"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printDivisionByBID($result, $bid) {
	echo "<table>";
  echo "<caption>Order IDs with all Menu Items
	 at a given Branch: " . $bid . "</caption>";
	echo "<tr><th>Order ID</th></tr>";

	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row["orderid"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printCountIngsByExpDate($result) {
	echo "<table>";
  echo "<caption>Number of Ingredients Expirying by Date:</caption>";
	echo "<tr><th>Expiry Date</th><th>Number of Ingredients</th></tr>";

	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row["expirydate"] . "</td><td>" . $row["count"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printIList($result) {
	echo "<table style='float: left'>";
  echo "<caption>MenuItem You're Responsible For:</caption>";
	echo "<tr>
	<th>MenuItem ID</th>
	<th>Item Name</th>
	<th>Chef ID</th></tr>";
	while ($row = pg_fetch_array($result)) {
		echo  "<tr><td>"
		 . $row["menuitemid"] . "</td><td>"
		 . $row["itemname"] . "</td><td>"
		  . $row["chefid"] . "</td></tr>"; //or just use "echo $row[0]";
	}
	echo "</table>";
}


function printUpdateIList($result) {
	echo "<table style='float: left'>";
  echo "<caption>Updated Ingredient</caption>";
	echo "<tr>
		<th>BranchID</th>
		<th>Ingredient Name</th>
		<th>Lot Number</th>
		<th>Quantity Left</th>
		</tr>";
	while ($row = pg_fetch_array($result)) {
		echo  "<tr><td>" . $row["branchid"] . "</td><td>" . $row["ingredientname"] . "</td>
		<td>" . $row["lotnumber"] . "</td><td>" . $row["quantityleft"] . "</td>
		</tr>";
	}
	echo "</table>";
}


function printDelivery($result) {
	echo "<table>";
	echo "<caption>Got data from table TakeoutOrder:</caption>";
	echo "<tr>
      <th>OrderID</th>  <th>Delivery Time</th>
      <th>Driver ID</th>   <th>BranchID</th>
      </tr>";
			while ($row = pg_fetch_array($result)) {
		echo "<tr><td>"
        . $row["orderid"] . "</td><td>"
        . $row["deliverytime"] . "</td><td>"
        . $row["driverid"] . "</td><td>"
       	. $row["branchid"]
    . "</td></tr>";
	}
echo "</table>";
}


function printToDeliver($result) {
	echo "<table>";
	echo "<caption>Orders to Deliver:</caption>";
	echo "<tr>
	<th>DriverID</th> <th>OrderID</th><th>Address</th> <th>City</th>
	<th>Postal Code</th><th>Phone Number</th>
	</tr>";
	while ($row = pg_fetch_array($result)) {
	echo "<tr><td>" . $row["driverid"] . "</td><td>" . $row["orderid"] . "</td>
		<td>" . $row["address"] . "</td><td>" . $row["city"] . "</td>
		<td>" . $row["postalcode"] . "</td><td>" . $row["phonenumber"] . "</td>
		</tr>";
	// echo "<tr><td>" . $row[6] . "</td><td>" . $row[0] . "</td>
	// 	<td>" . $row[2] . "</td><td>" . $row[3] . "</td>
	// 	<td>" . $row[4] . "</td><td>" . $row[5] . "</td>
	// 	</tr>";
	}
echo "</table>";
}

function printpop($result, $bid) {
	echo "<table>";
	echo "<caption>Popular Delivery MenuItems from Branch: ". $bid ." </caption>";
	echo "<tr>
    <th>MenuItemID</th> <th>ItemName</th><th>BranchID</th> <th>Count</th>
		</tr>";
		while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row["menuitemid"] . "</td><td>" . $row["itemname"] . "</td>
			// <td>" . $row["branchid"] . "</td><td>" . $row["count"] . "</td>
			</tr>";
		// echo "<tr><td>" . $row["BRANCHID"] . "</td><td>" . $row["COUNT(*)"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printIngredientOrders($result) {
	echo "<table>";
  echo "<caption>Ingredient Orders:</caption>";
	echo "<tr><th>Restock ID</th><th>Manager ID</th><th>Supplier ID</th>
	<th>Ingredient Name</th><th>Quantity</th></tr>";

	while ($row = pg_fetch_array($result)) {
		echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td>
		<td>" . $row[2] . "</td><td>" . $row[3] . "</td>
		<td>" . $row[4] . "</td></tr>";
	}
	echo "</table>";
}

// function dropdownBranches($result) { //adds results from a select statement
// 	echo "<br><select name='selectbid'>";
// 	echo "<option value='0'>Please Select a Branch</option>";
// 	while ($row = pg_fetch_array($result)) {
// 		echo "<option value =" . $row['BRANCHID'] . ">" . $row['BRANCHID'] . "</option>";
// 		echo "</select><br>";
// 	}
// }

?>
