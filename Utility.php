<!--Test Oracle file for UBC CPSC 304, modified by Andrew Wong for Group 12 - W1 2018 session
  Created by Jiemin Zhang, 2011, Modified by Simona Radu and others -->

<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = pg_connect(getenv("DATABASE_URL"));
// $db_conn = pg_connect("host=localhost port=5432 dbname=Andrew user=Andrew" ) or die("Could not connect");
// $db_conn = OCILogon("ora_p0w0b", "a59612168", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$stat = pg_connection_status($db_conn);
  if ($stat === PGSQL_CONNECTION_OK) {
      echo '<h>Connection status ok</h><br><br>';
  } else {
      echo '<h>Connection status bad</h><br><br>';
  }

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	// $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work
	// pg_prepare($statement, $cmdstr);
	// if (!$statement) {
	// 	echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
	// 	// $e = OCI_Error($db_conn); // For OCIParse errors pass the
	// 	$e = pg_last_error($db_conn);
	// 	// connection handle
	// 	echo htmlentities($e);
	// 	// echo htmlentities($e['message']);
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
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

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

function printResult($result) { //prints results from a select statement
	echo "<table style='float: left'>";
  echo "<caption>Got data from table OrderHas:</caption>";
	echo "<tr><th>OrderID</th><th>MenuItemID</th></tr>";

	while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row["ORDERID"] . "</td><td>" . $row["MENUITEMID"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";

}

function printOrder($result, $orderid) { //prints results from a select statement
	echo "<table>";
  echo "<caption>Retrieved Order Details
				for OrderID: " . $orderid . "</caption>";
	echo "<tr><th>MenuItemID</th><th>ItemName</th></tr>";

	while ($row = pg_fetch_row($result)) {
		// <td>" . $row["ORDERID"] . "</td>
		echo "<tr>
							<td>" . $row["MENUITEMID"] . "</td>
							<td>" . $row["ITEMNAME"] . "</td>
							</tr>";
	}
	echo "</table>";

}

function printMenuItems($result) { //prints results from a select statement
	echo "<table>";
  echo "<caption>Got data from table MenuItem:</caption>";
	echo "<tr><th>MenuItemID</th><th>Name</th></tr>";

	while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row["MENUITEMID"] . "</td><td>" . $row["ITEMNAME"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";

}

function printBranches($result) { //prints results from a select statement
	echo "<table>";
  echo "<caption>All Branches:</caption>";
	echo "<tr><th>Branch ID</th><th>Address</th><th>City</th></tr>";
	while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row["BRANCHID"] . "</td><td>" . $row["ADDRESS"] . "</td><td>" . $row["CITY"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function dropdownBranches($result) { //adds results from a select statement
	echo "<br><select name='selectbid'>";
	echo "<option value='0'>Please Select a Branch</option>";
	while ($row = pg_fetch_row($result)) {
		echo "<option value =" . $row['BRANCHID'] . ">" . $row['BRANCHID'] . "</option>";
	}
	echo "</select><br>";
}

function printIngredientsByBranch($result, $bid) { //prints results from a select statement
	echo "<table>";
	echo "<caption>Ingredients at Branch: " . $bid . "</caption>";
	echo "<tr><th>Ingredient Name</th><th>Quantity Left</th><th>Expiry Date</th></tr>";
	while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row["INGREDIENTNAME"] . "</td><td>" . $row["QUANTITYLEFT"] . "</td><td>" . $row["EXPIRYDATE"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printIngredientsExpiring($result, $bid) { //prints results from a select statement
	echo "<table>";
	echo "<caption>Ingredients at Expiring on: " . $bid . "</caption>";
	echo "<tr><th>Ingredient Name</th><th>Quantity Left</th><th>Expiry Date</th></tr>";
	while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row["INGREDIENTNAME"] . "</td><td>" . $row["QUANTITYLEFT"] . "</td><td>" . $row["EXPIRYDATE"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printCountEmployeesByBID($result) { //prints results from a select statement
	echo "<table>";
  echo "<caption>Total Employees at a Branch:</caption>";
	echo "<tr><th>Branch ID</th><th>Number of Employees</th></tr>";

	while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row["BRANCHID"] . "</td><td>" . $row["COUNT(*)"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printDivisionByBID($result, $bid) { //prints results from a select statement
	echo "<table>";
  echo "<caption>Order IDs with all Menu Items
	 at a given Branch: " . $bid . "</caption>";
	echo "<tr><th>Order ID</th></tr>";

	while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row["ORDERID"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printCountIngsByExpDate($result) { //prints results from a select statement
	echo "<table>";
  echo "<caption>Number of Ingredients Expirying by Date:</caption>";
	echo "<tr><th>Expiry Date</th><th>Number of Ingredients</th></tr>";

	while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row["EXPIRYDATE"] . "</td><td>" . $row["COUNT(*)"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printIList($result) { //prints results from a select statement
	echo "<table style='float: left'>";
  echo "<caption>MenuItem You're Responsible For:</caption>";
	echo "<tr>
	<th>MenuItem ID</th>
	<th>Item Name</th>
	<th>Chef ID</th></tr>";
	while ($row = pg_fetch_row($result)) {
		echo  "<tr><td>"
		 . $row["MENUITEMID"] . "</td><td>"
		 . $row["ITEMNAME"] . "</td><td>"
		  . $row["CHEFID"] . "</td></tr>"; //or just use "echo $row[0]";
	}
	echo "</table>";
}


function printUpdateIList($result) { //prints results from a select statement
	echo "<table style='float: left'>";
  echo "<caption>Updated Ingredient</caption>";
	echo "<tr>
		<th>BranchID</th>
		<th>Ingredient Name</th>
		<th>Lot Number</th>
		<th>Quantity Left</th>
		</tr>";
	while ($row = pg_fetch_row($result)) {
		echo  "<tr><td>" . $row["BRANCHID"] . "</td><td>" . $row["INGREDIENTNAME"] . "</td>
		<td>" . $row["LOTNUMBER"] . "</td><td>" . $row["QUANTITYLEFT"] . "</td>
		</tr>"; //or just use "echo $row[0]";
	}
	echo "</table>";
}


function printDelivery($result) { //prints results from a select statement
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


function printToDeliver($result) { //prints results from a select statement
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

function printpop($result, $bid) { //prints results from a select statement
	echo "<table>";
	echo "<caption>Popular Delivery MenuItems from Branch: ". $bid ." </caption>";
	echo "<tr>
    <th>MenuItemID</th> <th>ItemName</th><th>BranchID</th> <th>Count</th>
		</tr>";
		while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row["MENUITEMID"] . "</td><td>" . $row["ITEMNAME"] . "</td>
			<td>" . $row["BRANCHID"] . "</td><td>" . $row["COUNT"] . "</td>
			</tr>"; //or just use "echo $row[0]"
		// echo "<tr><td>" . $row["BRANCHID"] . "</td><td>" . $row["COUNT(*)"] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

function printIngredientOrders($result) { //prints results from a select statement
	echo "<table>";
  echo "<caption>Ingredient Orders:</caption>";
	echo "<tr><th>Restock ID</th><th>Manager ID</th><th>Supplier ID</th>
	<th>Ingredient Name</th><th>Quantity</th></tr>";

	while ($row = pg_fetch_row($result)) {
		echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td>
		<td>" . $row[2] . "</td><td>" . $row[3] . "</td>
		<td>" . $row[4] . "</td></tr>"; //or just use "echo $row[0]"
	}
	echo "</table>";
}

// function dropdownBranches($result) { //adds results from a select statement
// 	echo "<br><select name='selectbid'>";
// 	echo "<option value='0'>Please Select a Branch</option>";
// 	while ($row = pg_fetch_row($result)) {
// 		echo "<option value =" . $row['BRANCHID'] . ">" . $row['BRANCHID'] . "</option>";
// 		echo "</select><br>";
// 	}
// }

// DATABASE_URL: postgres://nirqdlupyjxoxr:f07eaf07be5c5af0ce1cdf0cf8029443e7019c0a9e0e2673d0a3b6b1e51c37f6@ec2-23-21-201-12.compute-1.amazonaws.com:5432/dki11jv212dl5

?>
