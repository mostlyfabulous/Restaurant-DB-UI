<PHP> <link rel="stylesheet" type="text/css" href="enjoy.css"></head> <PHP>
<?php include 'Utility.php'; ?>
<h>Customer PHP table</h>
<p>If you wish to reset the table, press the reset button. If this is the first time you're running this page, you MUST use reset</p>
<p><a href="index.php">Index page</a></p>
<form method="POST" action="Customer.php">

<p><input type="submit" value="Reset" name="reset"></p>
</form>
<?php

if ($_POST && $success) {
  header("location: Customer.php");
} else {
  // Select data...
  $result = executePlainSQL("select * from MenuItem");
  printMenuItems($result);
}
?>
<p>Insert values into ORDERHAS below:</p>
<form method="POST" action="Customer.php">
<!--refresh page when submit-->
<p> <input type="text" name="insORDERID" size="10" placeholder="Order ID">
    <input type="text" name="insMenuItemID" size="18"placeholder="Menu Item">
<!--define two variables to pass the value-->

<input type="submit" value="insert" name="insertsubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to
get the values-->

<p> TODO: Update the name by inserting the old and new values below </p>
<form method="POST" action="Customer.php">
<!--refresh page when submit-->

<p><input type="text" name="oldName" size="18" placeholder="Old Name"><input type="text" name="newName"
size="18" placeholder="New Name">
<!--define two variables to pass the value-->

<input type="submit" value="update" name="updatesubmit">
<input type="submit" value="run hardcoded queries" name="dostuff"></p>
</form> <br>

<?php

// $success = True; //keep track of errors so it redirects the page only if there are no errors
// $db_conn = OCILogon("ora_u4b1b", "a46210167", "dbhost.ugrad.cs.ubc.ca:1522/ug");

// Connect Oracle...
if ($db_conn) {

	if (array_key_exists('reset', $_POST)) {
		// Drop old table...
		echo "<br> dropping table <br>";
		executePlainSQL("Drop table ORDERHAS");

		// Create new table...
		echo "<br> creating new table <br>";
		executePlainSQL("create table ORDERHAS (ORDERID CHAR(30), MENUITEMID CHAR(30), primary key (ORDERID, MENUITEMID))");
		OCICommit($db_conn);

	} else
		if (array_key_exists('insertsubmit', $_POST)) {
			//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_POST['insORDERID'],
				":bind2" => $_POST['insMenuItemID']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into ORDERHAS values (:bind1, :bind2)", $alltuples);
			OCICommit($db_conn);

		} else
			if (array_key_exists('updatesubmit', $_POST)) {
				// Update tuple using data from user
				$tuple = array (
					":bind1" => $_POST['oldName'],
					":bind2" => $_POST['newName']
				);
				$alltuples = array (
					$tuple
				);
				executeBoundSQL("update tab1 set name=:bind2 where name=:bind1", $alltuples);
				OCICommit($db_conn);

			} else
				if (array_key_exists('dostuff', $_POST)) {
					// Insert data into table...
					// executePlainSQL("insert into Orders values (10, 'Frank')");
					// Inserting data into table using bound variables
					$list1 = array (
						":bind1" => 'O0001',
						":bind2" => 'Grass'
					);
					$list2 = array (
						":bind1" => 'O0002',
						":bind2" => 'Water'
					);
					$allrows = array (
						$list1,
						$list2
					);
					executeBoundSQL("insert into OrderHas values (:bind1, :bind2)", $allrows); //the function takes a list of lists
					// Update data...
					//executePlainSQL("update tab1 set nid=10 where nid=2");
					// Delete data...
					//executePlainSQL("delete from tab1 where nid=1");
					OCICommit($db_conn);
				}

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: Customer.php");
	} else {
		// Select data...
		$result = executePlainSQL("select * from ORDERHAS");
		printResult($result);
    $result = executePlainSQL("select * from MenuItem");
    printMenuItems($result);
	}

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

?>
