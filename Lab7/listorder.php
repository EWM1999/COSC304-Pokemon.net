<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pokemon.net - Order List</title>
</head>
<body>

<h1>Order List</h1>

<?php

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
	include 'include/db_credentials.php';
	$con = sqlsrv_connect($server, $connectionInfo);
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
	$orderId = 0;
	$sql = "SELECT orderId, orderDate, C.customerId, firstName+' '+lastName as cname, totalAmount FROM ordersummary O, customer C WHERE O.customerId = C.customerId";
	$results = sqlsrv_query($con, $sql, array());
	echo("<table><tr><th>Order Id</th><th>Order Date</th><th> Customer Id</th><th>Customer Name</th><th>Total Amount</th></tr>");
	$sql2 = "SELECT productId, quantity, price from orderproduct where orderId = ?";
	$result2 = sqlsrv_prepare($con, $sql2, array(&$orderId));
	if(!$results){
		echo("False Statement Bitch");
	}
	while ($row = sqlsrv_fetch_array( $results, SQLSRV_FETCH_ASSOC)) {
		/*echo($row)*/
		$orderId = $row['orderId'];
		$orderDate = $row['orderDate'];
		echo("<tr><td>" . $orderId . "</td><td>" . $orderDate->format('Y-m-d H:i:s') . "</td><td>" . $row['customerId'] . "</td><td>" . $row['cname'] . "</td><td>$".number_format($row['totalAmount'],2). "</td></tr>");
		sqlsrv_execute($result2);
		echo("<tr align = \"right\"><td = colspan = \"5\">");
		echo("<th>Product Id</th><th>Quantity</th><th>Price</th></tr>");
		while($row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)){
			echo("<tr><td>".$row2['productId']."</td>");
			echo("<td>".$row2['quantity']."<//td>");
			echo("<td>$".number_format($row2['price'],2)."</td></tr>");
		}
		echo("</table></td></tr>");
	//idk if this is right or not.
	}
	echo("</table>");

?>
</body>
</html>

