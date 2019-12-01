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

        .login_things{
          text-align: right;
          color: #FFCB05;
        }
        .product-container {
            display: flex;
            flex-flow: row wrap;
            align-content: stretch;
            justify-content: center;
            align-items: stretch;

        }
        .product-item{
            background-color: #494948;
            flex-grow: 1;
            padding: 10px;
            margin: 5px;
            max-width: 20%;
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
        <h3 class="muted">Pokémon.net</h3>
        <h1 style="float:left"><img src="https://i.imgur.com/7E7HphH.png" border="0"></h1>

        <?php
        include 'loginHeader.php';
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
                <li class="active"><a href="listprod.php">Start Shopping</a></li>
                <li><a href="aboutus.php">About Us</a></li>
              </ul>
            </div>
            </div>
            </div><!-- /.navbar -->
        </div>

            <h3>Search for a product</h3>
            <form method="get" action="listprod.php">
                <div>
                    <div style='float:left; max-width:50%;padding:5px;margin:10px;'>
                        <p>By Type</p>
                        <select size="1" name="categoryName">
                        <option>All</option>
                        <option>Bug</option>
                        <option>Dark</option>
                        <option>Dragon</option>
                        <option>Electric</option>
                        <option>Fairy</option>
                        <option>Fighting</option>
                        <option>Fire</option>
                        <option>Ghost</option> 
                        <option>Grass</option>
                        <option>Ground</option>
                        <option>Ice</option>
                        <option>Normal</option>
                        <option>Poison</option>
                        <option>Psychic</option> 
                        <option>Rock</option>  
                        <option>Steel</option>   
                        <option>Water</option>
                        </select><br>
                    </div>
                    <div style='max-width: 50%;padding:5px;margin:10px;'>
                        <p>By Name</p>
                        <input type="text" name="productName" size="50"><br>
                    </div>
                </div>
                <div style='padding:5px;margin:10px;'>
                <input type="submit" value="Submit"><input type="reset" value="Reset" onclick="location.href='listprod.php'"> (Leave blank for all products)
                </div>
            </p>
            </form>
        <br>
    
    <?php 
    #include 'header.php';
    include 'include/db_credentials.php';
    ?>

		<?php
			#include 'include/db_credentials.php';

			$name = "";
            $hasName = false;
			/** Get product name to search for **/
			if (isset($_GET['productName'])){
				$name = $_GET['productName'];
                if ($name != '')
                    $hasName = true;
			}
            $category = "";
            $hasCategory = false;
            if (isset($_GET['categoryName'])){
                $category = $_GET['categoryName'];
                if ($category != 'All')
                    $hasCategory = true;
            }
            $filter = "";
			/** $name now contains the search string the user entered
			 Use it to build a query and print out the results. **/

			/** Create and validate connection **/

			$con = sqlsrv_connect($server, $connectionInfo);
			if($con == false){
				die(print_r(sqlsrv_errors(), true));
			}
			$result1 = null;
			$sql = "";
			if($hasName&&$hasCategory){
                $filter = "<h3>Products containing '" . $name . "' in category: '" . $category . "'</h3>";
                $name = '%' . $name . '%';
                $sql = "SELECT productId, productName, productPrice, categoryName, productImageURL FROM Product P JOIN Category C ON P.categoryId = C.categoryId WHERE productName LIKE ? AND categoryName = ?";
                $result1 = sqlsrv_query($con, $sql, array( $name, $category ));
                echo($filter);

			}else if($hasName){
                echo("<h2>Products containing '" . $name . "'</h2>");
                $sql = "SELECT productId, productName, productPrice, categoryName, productImageURL FROM Product P JOIN Category C ON P.categoryId = C.categoryId where productName LIKE ?";
                $name = "%".$name."%";
                $result1 = sqlsrv_query($con, $sql, array($name));
                if(!$result1)
                    echo("Bitch you thought");
			}else if($hasCategory){
                $filter = "<h3>Products in category: '" . $category . "'</h3>";
                $sql = "SELECT productId, productName, productPrice, categoryName, productImageURL FROM Product P JOIN Category C ON P.categoryId = C.categoryId WHERE categoryName = ?";
                $result1 = sqlsrv_query($con, $sql, array( $category ));
                echo($filter);
            }else{
                $sql= "SELECT productId, productName, productPrice, categoryName, productImageURL FROM Product P JOIN Category C ON P.categoryId = C.categoryId";
                $result1 = sqlsrv_query($con, $sql, array());
                if(!$result1){
                    echo("Bitch you thought");
                }
                echo("<h2>All Products</h2>");
            }

		// echo("<table border = \"1\"><tr><th>Add to Cart</th><th>Image</th><th>Product Name</th><th>Price</th><th>Category</th></tr>");
		// while($row = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)){
        //     echo("<tr><td><a href =\"addcart.php?id=".$row['productId']."&name=".$row['productName']. "&price=" . $row['productPrice'] . "\" style = 'color: #FFCB05'>Add</a></td>");
        //     $imageLoc = $row['productImageURL'];
        //     echo "<td><img src=\"" . $imageLoc . "\" alt = \"".$row['productName']."\" style = 'max-width: 10%; border-radius: 50%; margin: 2%; float: left'></td>";
        //     echo("<td><a href =\"product.php?productId=".$row['productId']."\" style = 'color: #FFCB05'>".$row['productName']."</a></td>");
        //     echo("<td>".number_format($row['productPrice'],2)."</td>");
        //     echo("<td>".$row['categoryName']."</td></tr>");
		// }
        // echo("</table>");
        
        echo("<div class=\"product-container\">");
        while($row = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)){
            echo("<div class=\"product-item\">");
            echo("<a href =\"product.php?productId=".$row['productId']."\" style = 'color: #FFCB05'>");
            echo("<img src=\"".$row['productImageURL']."\" alt = \"".$row['productName']."\" style = 'max-width: 80%; border-radius: 50%; margin: 2%; display: block; margin-left: auto; margin-right: auto;'></a>");
            echo("<a href =\"product.php?productId=".$row['productId']."\" style = 'color: #FFCB05;'><h5 style = 'color: #FFCB05; text-align: center;'>".$row['productName']."</h5></a>");
            echo("<p style = 'color: #FFCB05; text-align: center;'>".$row['categoryName']."<br>$".$row['productPrice']."</p>"); 
            echo("</div>");
        }
        echo("</div>");

        sqlsrv_close($con);
	?>

</div>

</body>
</html>