<PHP> <link rel="stylesheet" type="text/css" href="enjoy.css"></head> <PHP>
<?php include 'Utility.php'; ?>
<h>Customer PHP table</h>
<a href="index.php">Index page</a>
<br><br>
  <!-- <form method="GET" action="Customer.php">
<p> <input type="text" name="setbid" size="10" placeholder="BranchID">
    <input type="submit" value="search" name="selectsubmit"></p>
</form> -->

<?php
// Create's drown down selection menu based on availble restaurants
$result = executePlainSQL("select * from Restaurant");
echo "<form method='GET' action='Customer.php'>";
echo "Select MenuItems by Branch ID below: <br>";
dropdownBranches($result);
echo "<p><input type='submit' value='Submit'></p>";
echo "</form>";

// selectbid defined in dropdownBranches function
if ($db_conn && array_key_exists('selectbid', $_GET)) {
  // Get MenuItems by BranchID
  $sqlquery = "select * from MenuItem where BRANCHID='" . $_GET['selectbid'] . "'";
  $result = executePlainSQL($sqlquery);
  printMenuItems($result, $_GET['selectbid']);
}

?>
<br><br>
<form method="POST" action="Customer.php">
  Insert values into ORDERHAS - <br>  Customer can add items to their order:
<p> <input type="text" name="insORDERID" size="10" placeholder="Order ID">
    <input type="text" name="insMenuItemID" size="18"placeholder="Menu Item ID">
    <input type="text" name="insBranchID" size="10"placeholder="Branch ID">
<!--define 3 variables to pass the value-->
<input type="submit" value="insert" name="insertsubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to
get the values-->
<br><br>
<form method="GET" action="Customer.php">
  Input Branch ID to see popular items at that Branch:
<p> <input type="text" name="viewBranchID" size="10"placeholder="Branch ID">
<input type="submit" value="insert" name="viewpopitem"></p>
</form>
<br><br>
<form method="GET" action="Customer.php">
<!--refresh page when submit-->
Remove Menu Item from Order ID
<p> <input type="text" name="orderID" size="18" placeholder="Order ID">
    <input type="text" name="menuItem" size="18" placeholder="Menu Item to remove">
<!--define two variables to pass the value-->
<input type="submit" value="remove menu item from order" name="updatesubmit">
</form> <br>

<?php

if ($db_conn) {
	if (array_key_exists('viewpopitem', $_GET)) {
    executePlainSQL("Drop view POP_ITEM");

    // echo "<p> Popular Delivery MenuItems from Branch: " . $_GET['viewBranchID'] . "</p>";
    $sqlquery = "create view POP_ITEM(MenuItemID, ItemName, BranchID, Count) as
    select MenuItem.MenuItemID, MenuItem.itemName, MenuItem.branchID, COUNT(MenuItem.menuItemID)
    from MenuItem
    inner join OrderHas on MenuItem.MenuItemID = OrderHas.MenuItemID and MenuItem.BranchID = OrderHas.BranchID
    inner join TakeoutOrder on TakeoutOrder.orderID = OrderHas.orderID
    where OrderHas.branchID= '" . $_GET['viewBranchID'] . "'
    GROUP BY MenuItem.menuItemID, MenuItem.itemName, MenuItem.branchID
    ORDER BY COUNT(MenuItem.menuItemID) DESC";

    $result = executePlainSQL($sqlquery);
    $result = executePlainSQL("
    SELECT * FROM POP_ITEM
    ");
    printpop($result, $_GET['viewBranchID']);

	} else
		if (array_key_exists('insertsubmit', $_POST)) {
			//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_POST['insORDERID'],
				":bind2" => $_POST['insMenuItemID'],
        ":bind3" => $_POST['insBranchID']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into ORDERHAS values (:bind1, :bind2, :bind3)", $alltuples);


		} else
			if (array_key_exists('updatesubmit', $_GET)) {
				// delete tuple using data from user
					// ":bind1" => $_POST['orderID'],
					// ":bind2" => $_POST['menuItem']
				executePlainSQL("delete from ORDERHAS where ORDERID='" . $_GET['orderID'] . "'and MENUITEMID='" . $_GET['menuItem'] . "'");
        // delete from ORDERHAS where ORDERID='O000001' and MENUITEMID='MI001';

		} else
      if (array_key_exists('getorder', $_GET)) {
        // gets menu items in an orderid
      $result = executePlainSQL("
      SELECT DISTINCT O.orderID, M.menuItemID, M.itemname
      FROM orderhas O, menuitem M
      WHERE O.menuItemID = M.menuItemID
      AND O.orderID = '" . $_GET['orderID'] . "'
      ORDER BY M.menuItemID ASC
      ");

      // SELECT O.orderID, M.menuitemID, M.itemname
      // FROM orderhas O, menuitem M
      // WHERE O.menuItemID = M.menuItemID
      // AND O.orderID = 'O000001'
      printOrder($result, $_GET['orderID']);
    } else
			if (array_key_exists('dostuff', $_POST)) {
				$list1 = array (
					":bind1" => 'O000001',
					":bind2" => 'MI001',
          ":bind3" => 'B1234'
				);
				$list2 = array (
					":bind1" => 'O000001',
					":bind2" => 'MI002',
          ":bind3" => 'B1234'
				);
				$allrows = array (
					$list1,
					$list2
				);
				executeBoundSQL("insert into OrderHas values (:bind1, :bind2, :bind3)", $allrows); //the function takes a list of lists
				// Update data...
				//executePlainSQL("update tab1 set nid=10 where nid=2");
				// Delete data...
				//executePlainSQL("delete from tab1 where nid=1");

		}

	if ($_POST && $success) {
		// POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
	// 	header("location: Customer.php");
	// } else {
  //   $result = executePlainSQL("select distinct * from MenuItem");
  //   printMenuItems($result);
	}
	//Commit to save changes...
  pg_close($db_conn);
  } else {
  echo "cannot connect";
  $e = pg_last_error();
  echo htmlentities($e);
  }

?>
