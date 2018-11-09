<PHP> <link rel="stylesheet" type="text/css" href="enjoy.css"></head> <PHP>
<a href="Restaurant.php">Restaurant page</a>
<a href="Restaurant.php">Chef page</a>
<a href="Customer.php">Customer page</a>
<a href="Restaurant.php">Delivery Driver page</a>

<?php
$db_conn = OCILogon("ora_u4b1b", "a46210167", "dbhost.ugrad.cs.ubc.ca:1522/ug");

// Connect Oracle...
if ($db_conn) {
    echo "<br> dropping table <br>";
        executePlainSQL("Drop table tab1");
}