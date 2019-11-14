<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pokeshop Order Processing</title>
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
}else{
	die("<p>There are no products in your shopping cart :( </p>");
}

/**
Determine if valid customer id was entered
Determine if there are products in the shopping cart
If either are not true, display an error message
**/

// valid customer id?
// maybe if its an integer? Because the ddl wants one?
if(!is_numeric($custId)){
	die("<p>ids are supposed to be numbers buddy :( </p>");
}
// maybe if its in the customer list

include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);


$sql = "SELECT * FROM customer WHERE customerId = ?;";
$result = sqlsrv_query($con, $sql, array($custId));
if(!$result){
	die("<p>You are not a valid customer :( </p>");
}



/** Make connection and validate **/

// oh fuck i did that earlier
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

/** Save order information to database**/

	/**
	// Use retrieval of auto-generated keys.
	$sql = "INSERT INTO <TABLE> OUTPUT INSERTED.orderId VALUES( ... )";
	$pstmt = sqlsrv_query( ... );
	if(!sqlsrv_fetch($pstmt)){
		//Use sqlsrv_errors();
	}
	$orderId = sqlsrv_get_field($pstmt,0);
	**/
$customer_name = $row['firstName']." ".$row['lastName'];

// the order date is today
$orderDate = date('Y-m-d H:i:s');

// ok Ramon
$sql = "INSERT INTO ordersummary (customerId, totalAmount, orderDate) OUTPUT INSERTED.orderId VALUES(?, 0, ?);";
$result = sqlsrv_query($con, $sql, array($custId, $orderDate));

if(!$result){
	echo("idk the query didn't insert or something. idk how to fix that");
}

$orderId = sqlsrv_get_field($result,0);

echo("<h1>Your Order Summary</h1>");
echo("<table border = \"2\">");
echo("<tr><th>Product Id</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>");

/** Insert each item into OrderedProduct table using OrderId from previous INSERT **/

$total = 0;
foreach($productList as $id => $product){
	// maybe someone can check this?
	$product_id = intval($product['id'], 10);
	$product_name = $product['name'];
	$product_price = floatval($product['price']);
	$product_quantity = $product['quantity'];

	echo("<tr>");
	echo("<td>".$product_id."</td>");
	echo("<td>".$product_name."</td>");

	echo("<td align=\"center\">".$product_quantity."</td>");
	echo("<td align=\"right\">$".number_format($product_price, 2)."</td>");

	$subtotal = $product_price * $product_quantity;
	echo("<td align=\"right\">$".number_format($subtotal, 2)."</td>");
	echo("</tr>");

	$sql = "INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (?, ?, ?, ?);";
	sqlsrv_query($con, $sql, array($orderId, $product_id, $product_quantity, $product['price']));
	// if(!$result){
	// 	die("the ordered product didn't insert so i think thats whats wrong but idk maybe i forgot a semicolon");
	// }

	// update the total
	$total = $total + $subtotal;
}

/** Update total amount for order record **/

$sql = "UPDATE ordersummary SET totalAmount = ? WHERE orderId = ?;";
$result = sqlsrv_query($con, $sql, array($total, $orderId));

if(!$result){
	echo("the update failed and i think i need a nap");
}

/** For each entry in the productList is an array with key values: id, name, quantity, price **/
/**
	foreach ($productList as $id => $prod) {
		\\$prod['id'], $prod['name'], $prod['quantity'], $prod['price']
		...
	}
**/

// wait isn;t that what im supposed to do before the update?
// why would you do that after the update?
// that makes no sense

// im not going to do it

/** Print out order summary **/

echo("Order Complete :). Your pokemon will be wired to you shortly<br>");
echo("Your order reference is: ".$orderId."<br");
echo("We are shipping to Pokemon Trainer ".$customer_name." with id ".$custId."</br>");
echo("friendly reminder that animal fighting is a crime :)");

echo("<h2><a href=\"shop.html\">Return to collecting 'em all :)</a></h2>");

/** Clear session/cart **/
$_SESSION['productList'] = NULL;
sqlsrv_close($con);
?>
</body>
</html>

