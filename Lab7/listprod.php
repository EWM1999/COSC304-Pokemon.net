		<!DOCTYPE html>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Pokémon.net</title>
		</head>
		<body>

		<h1>Search for the Pokémon you want to buy:</h1>

		<form method="get" action="listprod.php">
		<input type="text" name="productName" size="50">
		<input type="submit" value="Submit"><input type="reset" value="Reset"> (Leave blank for all products)
		</form>

		<?php
			include 'include/db_credentials.php';

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
			echo("<tr><td><a href =\"addcart.php?id=".$row['productId']."&name=".$row['productName']. "&price=" . $row['productPrice'] . "\">Add</a></td><td>".$row['productName']."</td><td>".number_format($row['productPrice'],2)."</td></tr>");
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

		</body>
		</html>