<PHP> <link rel="stylesheet" type="text/css" href="enjoy.css"></head> <PHP>
<?php include 'Utility.php'; ?>
<h>Manager PHP table</h><a href="index.php">Index page</a>
<!-- <p>If you wish to reset the table, press the reset button.</p>
<form method="POST" action="Manager.php">
<p><input type="submit" value="Reset" name="reset"></p>
</form> -->

<p> TODO: DELETE Ingredient when Manager transfers Ingredient to Place </p>
<form method="GET" action="Manager.php">
  Retrieve Ingredients in Stock at a Branch ID:
<p> <input type="text" name="selBID" size="10"placeholder="Branch ID">
    <input type="submit" value="select" name="selectbybid"></p>
</form>
<form method="GET" action="Manager.php">
  Get Ingredients Expirying on a Given Date:
<p> <input type="text" name="selDate" size="24"placeholder="Expiry Date: YYYY-MM-DD">
    <input type="submit" value="select" name="selectexpdate"></p>
</form>
<br>
<?php
  //
  if ($db_conn) {
    // empties cache
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    }
    echo "<br>";
    if ($db_conn && array_key_exists('selectbybid', $_GET)) {
      //Getting the ingredientsinstock at a branch
      $statement1 = "
      SELECT * FROM ingredientsinstock
      WHERE branchid='" . $_GET['selBID'] . "'";
      $result1 = executePlainSQL($statement1);
      printIngredientsByBranch($result1, $_GET['selBID']);

      echo "<br>";
    }
?>
<?php
  if ($db_conn && array_key_exists('selectexpdate', $_GET)) {
    // Find ingredients that expire on a given date
    $statement2 = "
    SELECT * FROM ingredientsinstock
    WHERE expirydate like'" . $_GET['selDate'] . "'";
    $result2 = executePlainSQL($statement2);
    printIngredientsExpiring($result2, $_GET['selDate']);

    echo "<br>";
  }
?>
<form method="GET" action="Manager.php">
  Get Number of Employees at a Branch: <br><br>
<p> <input type="text" name="byBID" size="10"placeholder="Branch ID">
    <input type="submit" value="select" name="countbybid"></p>
</form>
<form method="GET" action="Manager.php">
  Get OrderIDs where the Order has all <br>
  the Menu Items available at a Branch:
<p> <input type="text" name="divBID" size="10"placeholder="Branch ID">
    <input type="submit" value="select" name="divisionbybid"></p>
</form>
<br>
<?php
    echo "<br>";
    if ($db_conn && array_key_exists('countbybid', $_GET)) {
      $result = executePlainSQL("
        SELECT E.BRANCHID, COUNT(*)
        FROM Employee E, Restaurant R
        WHERE E.branchid=R.branchid AND E.branchid='" . $_GET['byBID'] . "'
        GROUP BY E.branchid");
      printCountEmployeesByBID($result);
    }
    if ($db_conn && array_key_exists('divisionbybid', $_GET)) {
      $result = executePlainSQL("
        SELECT orderID
        FROM Orders O
        WHERE NOT EXISTS
          (
            SELECT M.menuItemID
            FROM MenuItem M
            WHERE M.branchID='" . $_GET['divBID'] . "'
            MINUS (
              SELECT  H.menuItemID
              FROM    OrderHas H
              WHERE   O.orderID = H.orderID and H.branchID='" . $_GET['divBID'] . "')
    			  )
        ");
      printDivisionByBID($result, $_GET['divBID']);
    }
    $result = executePlainSQL("
      SELECT expirydate, COUNT(*) FROM ingredientsinstock
      GROUP BY expirydate
      ORDER BY expirydate DESC
      ");

    printCountIngsByExpDate($result);
  }
?>

<!-- <input type="submit" value="run hardcoded queries" name="dostuff"></p> -->
</form>

<?php

// Connect Oracle...
if ($db_conn) {
  //
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

	}
  // else
	// 	if (array_key_exists('dostuff', $_POST)) {
	// 		// Insert data into table...
	// 		// executePlainSQL("insert into Orders values (10, 'Frank')");
	// 		// Inserting data into table using bound variables
	// 		$list1 = array (
	// 			":bind1" => 'O0001',
	// 			":bind2" => 'Grass'
	// 		);
	// 		$list2 = array (
	// 			":bind1" => 'O0002',
	// 			":bind2" => 'Water'
	// 		);
	// 		$allrows = array (
	// 			$list1,
	// 			$list2
	// 		);
	// 		executeBoundSQL("insert into OrderHas values (:bind1, :bind2)", $allrows); //the function takes a list of lists
	// 		// Update data...
	// 		//executePlainSQL("update tab1 set nid=10 where nid=2");
	// 		// Delete data...
	// 		//executePlainSQL("delete from tab1 where nid=1");
	// 		OCICommit($db_conn);
	// 	}

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: Manager.php");
	} else {
		// Select data...
		// $result = executePlainSQL("select * from ORDERHAS");
		// printResult($result);
	}
	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

?>
<!--
$result = executePlainSQL("select * from Restaurant");
"echo <form method="GET" action='Manager.php'>"
dropdownBranches($result);
echo "<p><input type='submit' value='Submit'></p>";
echo "</form>";
if ($db_conn && array_key_exists('selectbid', $_GET)) {
Get MenuItems by BranchID
echo "<p> Fetching Menu Items from Branch: " . $_GET['selectbid'] . "</p>";
$sqlquery = "select * from MenuItem where BRANCHID='" . $_GET['selectbid'] . "'";
$result = executePlainSQL($sqlquery);
printMenuItems($result);
} -->
