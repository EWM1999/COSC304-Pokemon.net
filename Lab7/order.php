<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pokémon.net Order Processing</title>
</head>
<body>

<?php
include 'include/db_credentials.php';
/** Get customer id **/
$custId = null;
if(isset($_GET['customerId'])){
	$custId = $_GET['customerId'];
}else{
	die('Error. You are not a valid customer :(');
}
session_start();
$productList = null;
if (isset($_SESSION['productList'])){
	$productList = $_SESSION['productList'];
}else{
	die('Error. You do not have a shopping cart :(');
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
	$custId = intval($custId);
	$sql = "SELECT customerId, firstName + ' ' + lastName as cname from customer where customerId = ?";
	$r = sqlsrv_query($con, $sql, array($custId));
	if($re = sqlsrv_fetch_array($r, SQLSRV_FETCH_ASSOC)){



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


//he takes the custId (intval) and grabs custId, firstName and lastName as cname from customer where = custId
//set orderdate to date('Y-m-d H:i:s')
	//insert <table> (values) OUTPUT INSERTED.orderId values(?,?,?);
	//run query ($con, $sql, array(values))
	//does something for errors
	//set order id to sqlsrv_get_field(resultset, 0)
	//print order Summary
	//print table product id, name, quantity, price, subtotal
	//total = 0
	/*foreach ($productList as $id => $prod){
		echo id \n name \n quantity \ price \ total
		total = total + price*quantity
		insert into OrderProduct
}*/
//update order total set totalAmount where orderid = id
//print order info and return to shop.html
//clear session variables set to null
//close

// today's date
$custName = $re['cname'];
$orderDate = date('Y-m-d H:i:s');
$sql = "INSERT INTO ordersummary (orderDate, total_amount, customerId) OUTPUT INSERTED.orderId (orderDate, total_amount, customerId) VALUES (?, 0, ?);";
$result = sqlsrv_query($con, $sql, array($orderDate, $custId));
if(!sqlsrv_fetch($result)){
	sqlsrv_errors();
}
$orderId = sqlsrv_get_field($result,0);

echo("<h2>Your Order Summary</h2>");
echo("<table border = \"2\"><tr><th>Product Id</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>");
/** Insert each item into OrderedProduct table using OrderId from previous INSERT **/

$total_amount = 0;
foreach ($productList as $product => $productList) {
	//maybe?????
	echo("<tr><td>".$productList['productId']."</td>");
	echo("<td>".$productList['productName']."</td>");
	# maybe you need a select for the product
	# is it a name or id
	# get cost
	# i have no idea how to make quantity work
	$total_amount += $productList['quantity']*$price;
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
}
?>
</body>
</html>

