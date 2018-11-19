<!--Test Oracle file for UBC CPSC 304
  Created by Jiemin Zhang, 2011
  Modified by Simona Radu and others
  This file shows the very basics of how to execute PHP commands
  on Oracle.
  specifically, it will drop a table, create a table, insert values
  update values, and then query for values

  IF YOU HAVE A TABLE CALLED "tab1" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the
  OCILogon below to be your ORACLE username and password -->
<PHP><link rel="stylesheet" type="text/css" href="enjoy.css"></head><PHP>
<?php include 'Utility.php'; ?>
<h>Delivery PHP table</h><a href="index.php">Index page</a>

<p>Input your driverID to orders to deliver:</p>
<p><font size="2"> driverID</font></p>
<form method="GET" action="Delivery.php">
<!--refresh page when submit-->
   <p><input type="text" name="driverID" size="7"placeholder="DriverID">
<!--define two variables to pass the value-->

<input type="submit" value="submit" name="vieworderssubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to
get the values-->


<p> Update the order when delivered: </p>
<p><font size="2"> driverID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
orderID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
deliveryTime (format: YYYY-MM-DD)
</font></p>
<form method="GET" action="Delivery.php">
<!--refresh page when submit-->
   <p><input type="text" name="driverID" size="7" placeholder="DriverID">
     <input type="text" name="orderID" size="7" placeholder="OrderID">
     <input type="text" name="deliveryTime" size="12" placeholder="Delivery Time">
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
        OCICommit($db_conn);
        printDelivery($result);

			}
      // else
			// 	if (array_key_exists('dostuff', $_POST)) {
			// 		// Insert data into table...
			// 		executePlainSQL("insert into tab1 values (10, 'Frank')");
			// 		// Inserting data into table using bound variables
			// 		$list1 = array (
			// 			":bind1" => 6,
			// 			":bind2" => "All"
			// 		);
			// 		$list2 = array (
			// 			":bind1" => 7,
			// 			":bind2" => "John"
			// 		);
			// 		$allrows = array (
			// 			$list1,
			// 			$list2
			// 		);
			// 		executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $allrows); //the function takes a list of lists
			// 		// Update data...
			// 		//executePlainSQL("update tab1 set nid=10 where nid=2");
			// 		// Delete data...
			// 		//executePlainSQL("delete from tab1 where nid=1");
			// 		OCICommit($db_conn);
			// 	}

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: Delivery.php");
	} else {
		// Select data...
		// $result = executePlainSQL("select * from TakeoutOrder");

    $result = executePlainSQL("select * from TakeoutOrder");
		printDelivery($result);
	}

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database.
     You will need to replace "username" and "password" for this to
     to work.
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment
     statement */
/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode.
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode. */
/* OCI_Fetch_Array() Returns the next row from the result data as an
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an
     optinal second parameter which can be any combination of the
     following constants:

     OCI_BOTH - return an array with both associative and numeric
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default
     behavior.
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc()
     works).
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).
     OCI_RETURN_NULLS - create empty elements for the NULL fields.
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.
     Default mode is OCI_BOTH.  */
?>
