<!DOCTYPE html>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Pokémon.net</title>
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

      /* Display table very pretty */
        table {
  		    border-collapse: collapse;
  		    width: 100%;
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

      <div class="masthead">
        <h3 class="muted">Pokémon.net</h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="listorder.php">List All Orders</a></li>
                <li><a href="listprod.php">Start Shopping</a></li>
                <li><a href="customer.php">Customer Info</a></li>
                <li><a href="admin.php">Administrators</a></li>
                 <li><a href="login.php">Login</a></li>
                 <li><a href="logout.php">Log Out</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>


		<h1><img src="https://i.imgur.com/7E7HphH.png" border="0"></h1>

		<form method="get" action="listprod.php">
		<input type="text" name="productName" size="50">
		<input type="submit" value="Submit"><input type="reset" value="Reset" onclick="location.href='listprod.php'"> (Leave blank for all products)
    </form>
    
    <?php 
    #include 'header.php';
    include 'include/db_credentials.php';
    ?>

		<?php
			#include 'include/db_credentials.php';

			$name = "";
			/** Get product name to search for **/
			if (isset($_GET['productName'])){
				$name = $_GET['productName'];
			}

			/** $name now contains the search string the user entered
			 Use it to build a query and print out the results. **/

			/** Create and validate connection **/

			$con = sqlsrv_connect($server, $connectionInfo);
			if($con == false){
				die(print_r(sqlsrv_errors(), true));
			}
			$result1 = null;
			$sql = "";
			if($name == ""){
				$sql= "SELECT productId, productName, productPrice from product";
				$result1 = sqlsrv_query($con, $sql, array());
				if(!$result1){
					echo("Bitch you thought");
				}
				echo("<h2>All Products</h2>");

			}else{
                echo("<h2>Products containing '" . $name . "'</h2>");
                $sql = "SELECT productId, productName, productPrice from product where productName LIKE ?";
                $name = "%".$name."%";
                $result1 = sqlsrv_query($con, $sql, array($name));
                if(!$result1){
                    echo("Bitch you thought");
			}
		}
		echo("<table border = \"1\"><tr><th>Add to Cart</th><th>Product Name</th><th>Price</th></tr>");
		while($row = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)){
            echo("<tr><td><a href =\"addcart.php?id=".$row['productId']."&name=".$row['productName']. "&price=" . $row['productPrice'] . "\">Add</a></td>");
            echo("<td><a href =\"product.php?productId=".$row['productId']."\">".$row['productName']."</a></td>");
            echo("<td>".number_format($row['productPrice'],2)."</td></tr>");
		}
		echo("</table>");
		

			/** Print out the ResultSet **/

			/** 
			For each product create a link of the form
			addcart.php?id=<productId>&name=<productName>&price=<productPrice>
			Note: As some product names contain special characters, you may need to encode URL parameter for product name like this: urlencode($productName)
			**/
			
			/** Close connection **/

			/**
		        Useful code for formatting currency:
			       number_format(yourCurrencyVariableHere,2)
		     **/
			//$name = "";
		sqlsrv_close($con);
	?>

    </div>

</body>
</html>