<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pokeshop Order Processing</title>
<link href="bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }
      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }
      .container-narrow {
    background color: #003A70; repeat 0 0;
      }
      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 80px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
        background-color: #3D73DA;
      }
      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
        color: #EAEBED;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }
      .login_things{
          text-align: right;
          padding: 10px;
          color: #FFCB05;
        }
      table {
      border-collapse: collapse;
      width: 50%;
  }
  th, td {
      text-align: left;
      padding: 8px;
  }
  tr{background-color: #494948}
  th {
      background-color: #FFCB05;
      color: #494948;
  }
    </style>
    <link href="bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../bootstrap/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../bootstrap/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../bootstrap/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../bootstrap/ico/favicon.png">
  </head>
<body>

<div class="container">

<?php
include 'include/db_credentials.php';
/** Get customer id **/
if ((!filter_input(INPUT_POST, 'customerId'))|| (!filter_input(INPUT_POST, 'password'))) {
  $_SESSION['checkoutMessage'] = "You didn't even enter anything?!?";
	header("Location: checkout.php");
	exit;
}
$custId = filter_input(INPUT_POST, 'customerId');
$password = filter_input(INPUT_POST, 'password');
session_start();
$productList = null;
if (isset($_SESSION['productList'])){
	$productList = $_SESSION['productList'];
}else{
  $_SESSION['checkoutMessage'] = "There are no products in your shopping cart :(";
  header('Location: checkout.php');
}
/**
Determine if valid customer id was entered
Determine if there are products in the shopping cart
If either are not true, display an error message
**/
// valid customer id?
// maybe if its an integer? Because the ddl wants one?
if(!is_numeric($custId)){
  $_SESSION['checkoutMessage'] = "Your customer id should be a number, my dude :(";
  header('Location: checkout.php');
}
// maybe if its in the customer list
include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);
$sql = "SELECT * FROM customer WHERE customerId = ? AND password = ?;";
$result = sqlsrv_query($con, $sql, array($custId, $password));
if(!$result){
  $_SESSION['checkoutMessage'] = "Invalid customerId and password combination :(";
  header('Location: checkout.php');
}
//  if you made it this far you did fine
$_SESSION['checkoutMessage'] = null;
$custId = intval($custId);
$orderId=0;
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
if(!sqlsrv_fetch($result)){
	die("idk the query didn't insert or something. idk how to fix that");
}
$orderId = sqlsrv_get_field($result,0);
echo('<h1 style="float:left"><img src="https://i.imgur.com/SYl1PF8.png" border="0"></h1>');
include 'loginHeader.php';
echo "<br>";
echo("<table border = \"2\">");
echo("<tr><th>Product Id</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>");
/** Insert each item into OrderedProduct table using OrderId from previous INSERT **/
$total = 0;
foreach($productList as $id => $product){
	// maybe someone can check this?
	$product_id = intval($product['id']);
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
	$result = sqlsrv_query($con, $sql, array($orderId, $product_id, $product_quantity, $product['price']));
	 if(!$result){
	 	die("the ordered product didn't insert so i think thats whats wrong but idk maybe i forgot a semicolon");
	 }
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
echo("");
echo("Order Complete :) :). Your pokemon will be wired to you shortly<br>");
echo("Your order reference is: ".$orderId."<br>");
echo("We are shipping to Pokemon Trainer ".$customer_name." with id ".$custId."<br>");
echo("friendly reminder that animal fighting is a crime :)");
echo("<h2><a href=\"index.php\">Return to collecting 'em all :)</a></h2>");
/** Clear session/cart **/
$_SESSION['productList'] = NULL;
sqlsrv_close($con);
?>

</div>
</body>
</html>
