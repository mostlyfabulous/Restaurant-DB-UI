<PHP> <link rel="stylesheet" type="text/css" href="enjoy.css"></head> <PHP>
<?php include 'Utility.php'; ?>
<h>Customer PHP table</h>
<a href="index.php">Index page</a>

<p>Select MenuItems by Branch ID below:</p>
  <!-- <form method="GET" action="Chef.php">
<p> <input type="text" name="setbid" size="10" placeholder="BranchID">
    <input type="submit" value="search" name="selectsubmit"></p>
</form> -->

<?php
// Create's drown down selection menu based on availble restaurants
$result = executePlainSQL("select * from Restaurant");
echo "<form method='GET' action='Chef.php'>";
dropdownBranches($result);
echo "<p><input type='submit' value='Submit'></p>";
echo "</form>";

// selectbid defined in dropdownBranches function
if ($db_conn && array_key_exists('selectbid', $_GET)) {
  // Get MenuItems by BranchID
  echo "<p> Fetching Menu Items from Branch: " . $_GET['selectbid'] . "</p>";
  $sqlquery = "select * from MenuItem where BRANCHID='" . $_GET['selectbid'] . "'";
  $result = executePlainSQL($sqlquery);
  printMenuItems($result);
}
?>

<p>Input BranchID and MenuItemID to see ingredients list and quantity (in grams)::</p>
<form method="GET" action="Chef.php">
<!--refresh page when submit-->
<p> <input type="text" name="insMenuItemID" size="18"placeholder="Menu Item ID">
    <input type="text" name="insBranchID" size="10"placeholder="Branch ID">
<!--define 3 variables to pass the value-->
<input type="submit" value="insert" name="listsubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to
get the values-->

<p> TODO: Update the order by using a query </p>
<form method="POST" action="Chef.php">
<!--refresh page when submit-->

<p> <input type="text" name="orderID" size="18" placeholder="Order ID">
    <input type="text" name="menuItem" size="18" placeholder="Menu Item to remove">
<!--define two variables to pass the value-->
<input type="submit" value="remove menu item from order" name="updatesubmit">
</form> <br>

<?php

// Connect Oracle...
if ($db_conn) {
	// if (array_key_exists('reset', $_POST)) {
	// 	// Drop old table...
	// 	echo "<br> dropping table <br>";
	// 	executePlainSQL("Drop table ORDERHAS");
  //
	// 	// Create new table...
	// 	echo "<br> creating new table <br>";
	// 	executePlainSQL("create table ORDERHAS (ORDERID CHAR(30), MENUITEMID CHAR(30), primary key (ORDERID, MENUITEMID))");
	// 	OCICommit($db_conn);
  //
	// } else
		if (array_key_exists('listsubmit', $_GET)) {
			//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_GET['insMenuItemID'],
        ":bind2" => $_GET['insBranchID']
			);
			$alltuples = array (
				$tuple
			);
      $result = executePlainSQL("select * from Contains
        inner join MenuItem on Contains.MenuItemID = MenuItem.MenuItemID and Contains.branchID = MenuItem.branchID
        where Contains.MenuItemID='" . $_GET['insMenuItemID'] . "'and Contains.branchID='" . $_GET['insBranchID'] . "'");
      // $result = executePlainSQL("select * from Contains
      //     inner join MenuItem on Contains.MenuItemID = MenuItem.MenuItemID and Contains.branchID = MenuItem.branchID
      //     where Contains.MenuItemID='MI006' and Contains.branchID='B1235'");

        printIList($result);
		} else
			if (array_key_exists('updatesubmit', $_POST)) {
				// delete tuple using data from user
				$tuple = array (
					":bind1" => $_POST['orderID'],
					":bind2" => $_POST['menuItem']
				);
				$alltuples = array (
					$tuple
				);
				executeBoundSQL("delete from ORDERHAS where ORDERID='" . $_POST['orderID'] . "'and MENUITEMID='" . $_POST['menuItem'] . "'", $alltuples);
        // delete from ORDERHAS where ORDERID='O000001' and MENUITEMID='MI001';
				OCICommit($db_conn);
			}
      // else
			// 	if (array_key_exists('dostuff', $_POST)) {
			// 		// Insert data into table...
			// 		// executePlainSQL("insert into Orders values (10, 'Frank')");
			// 		// Inserting data into table using bound variables
			// 		$list1 = array (
			// 			":bind1" => 'O000001',
			// 			":bind2" => 'MI001',
      //       ":bind3" => 'B1234'
			// 		);
			// 		$list2 = array (
			// 			":bind1" => 'O000001',
			// 			":bind2" => 'MI002',
      //       ":bind3" => 'B1234'
			// 		);
			// 		$allrows = array (
			// 			$list1,
			// 			$list2
			// 		);
			// 		executeBoundSQL("insert into OrderHas values (:bind1, :bind2, :bind3)", $allrows); //the function takes a list of lists
			// 		// Update data...
			// 		//executePlainSQL("update tab1 set nid=10 where nid=2");
			// 		// Delete data...
			// 		//executePlainSQL("delete from tab1 where nid=1");
			// 		OCICommit($db_conn);
			// 	}

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: Chef.php");
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
