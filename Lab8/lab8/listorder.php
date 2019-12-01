<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pokemon.net - Order List</title>
<!-- Le styles -->
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
          color: #FFCB05;
        }

      table {
      border-collapse: collapse;
      width: 50%;
  }

  th, td {
      text-align: right;
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
    <?php
      include 'auth.php';
      if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1){
        header('Location: index.php');
      }
    ?>


    <div class="container">
        <h3 class="muted">Pokémon.net</h3>
        <h1 style="float:left"><img src="https://i.imgur.com/5Yp1Afk.png" border="0"></h1>
        <?php
        include 'loginHeader.php'
        ?>
        <br>
    </div>


    <div class="container">

      <div class="masthead">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="admin.php">Admin Page</a></li>
              <li class="active"><a href="listorder.php">All Orders</a></li>
              <li><a href="listcust.php">All Customers</a></li>
              <li><a href="dataManagement.php">Manage Database</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>

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

	include 'include/db_credentials.php';
	$con = sqlsrv_connect($server, $connectionInfo);
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
	$orderId = 0;
	$sql = "SELECT orderId, orderDate, C.customerId, firstName+' '+lastName as cname, totalAmount FROM ordersummary O, customer C WHERE O.customerId = C.customerId";
	$results = sqlsrv_query($con, $sql, array());
	echo("<table border = \"2\" style = 'width: 100%'><tr><th>Order Id</th><th>Order Date</th><th> Customer Id</th><th>Customer Name</th><th>Total Amount</th></tr>");
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
		echo("<tr align = \"right\"><td = colspan = \"5\"><table border = \"2\" style = 'float: right'>");
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