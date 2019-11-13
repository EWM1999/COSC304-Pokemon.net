<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>YOUR NAME Grocery Order Processing</title>
</head>
<body>

<?php
include 'include/db_credentials.php';
/** Get customer id **/
$custId = null;
if(isset($_GET['customerId'])){
	$custId = $_GET['customerId'];
}
session_start();
$productList = null;
if (isset($_SESSION['productList'])){
	$productList = $_SESSION['productList'];
}

/**
Determine if valid customer id was entered
Determine if there are products in the shopping cart
If either are not true, display an error message
**/

$valid_customer = false;
$sql = "";
$con = sqlsrv_connect($server, $connectionInfo);
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
$sql = "SELECT customerId from customer";
$result = sqlsrv_query($con, $sql, array());

if(!$result){
	echo("Try again :P");
}

while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
	if ($custId === $row['customerId']){
		$valid_customer = true;
	}
}

if(!$valid_customer){
	echo('Error. You are not a valid customer :(');
}
elseif(!isset($_SESSION['productList'])){
	echo('Error. You do not have a shopping cart :(');
}else{

/** Make connection and validate **/

/** Save order information to database**/


/**

insert ordersummary
get ordersummary id
for product in productList:
	insert into orderedProduct
**/

	/**
	// Use retrieval of auto-generated keys.
	$sql = "INSERT INTO <TABLE> OUTPUT INSERTED.orderId VALUES( ... )";
	$pstmt = sqlsrv_query( ... );
	if(!sqlsrv_fetch($pstmt)){
		//Use sqlsrv_errors();
	}
	$orderId = sqlsrv_get_field($pstmt,0);
	**/


// today's date
$orderDate = NULL;
$sql = "INSERT INTO ordersummary OUTPUT INSERTED.orderId (orderDate, total_amount, customerId) VALUES (?, 0, ?);"
$result = sqlsrv_query($con, $sql, array($orderDate, $custId));
if(!sqlsrv_fetch($result)){
	sqlsrv_errors();
}
$orderId = sqlsrv_get_field($result,0);

/** Insert each item into OrderedProduct table using OrderId from previous INSERT **/

$total_amount = 0;
foreach ($productList as $product => $productList) {

	# maybe you need a select for the product
	# is it a name or id
	# get cost
	# i have no idea how to make quantity work
	$total_amount += "whatever the new value is :P"
	$sql = "INSERT INTO orderproduct (orderId, productId) VALUES (?, ?)";
	$result = sqlsrv_query($con, $sql, array($orderId, $product));
}

/** Update total amount for order record **/
/**

$sql = "UPDATE ordersummary SET total_amount = ?"
$result = sqlsrv_query($con, $sql, array($total_amount)); 

**/


/** For each entry in the productList is an array with key values: id, name, quantity, price **/

/**
	foreach ($productList as $id => $prod) {
		\\$prod['id'], $prod['name'], $prod['quantity'], $prod['price']
		...
	}
**/

/** Print out order summary **/

/** Clear session/cart **/
}
?>
</body>
</html>

