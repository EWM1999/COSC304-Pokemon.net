<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pokemon.net - Order List</title>
</head>
<body>

<h1>Order List</h1>

<?php
include 'include/db_credentials.php';

/** Create connection, and validate that it connected successfully **/

/**
Useful code for formatting currency:
	number_format(yourCurrencyVariableHere,2)
**/

/** Write query to retrieve all order headers **/

/** For each order in the results
		Print out the order header information
		Write a query to retrieve the products in the order
			- Use sqlsrv_prepare($connection, $sql, array( &$variable ) 
				and sqlsrv_execute($preparedStatement) 
				so you can reuse the query multiple times (just change the value of $variable)
		For each product in the order
			Write out product information 
**/


/** Close connection **/
/**	$username = "fill-in";
	$password = "fill-in";
	$database = "WorksOn";
	$server = "sql04.ok.ubc.ca";
	$connectionInfo = array( "Database"=>$database, "UID"=>$username, "PWD"=>$password, "CharacterSet" => "UTF-8");**/

	$con = sqlsrv_connect($server, $connectionInfo);
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}

	$sql = "SELECT orderId,orderDate, customerId, firstName, lastName, totalAmount FROM ordersummary, customer where ordersummary.customerId = customer.customerId;";
	$results = sqlsrv_query($con, $sql, array());
	echo("<table><tr><th>Order Id</th><th>Order Data</th><th> Customer Id</th><th>Total Amount</th></tr>");
	while ($row = sqlsrv_fetch_array( $results, SQLSRV_FETCH_ASSOC)) {
		echo("<tr><td>" . $row['orderId'] . "</td><td>" . $row['orderDate'] . "</td><td>" . $row['Customer Id'] . "</td><td>" . $row['firstName'] . $row['lastName']. "</td><td>" . $row['Total Amount'] . "</td></tr>");
	}
	//idk if this is right or not.
	echo("</table>");
?>
</body>
</html>

