 <!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pokemon.net</title>
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

      table {
  		    border-collapse: collapse;
  		    width: 40%;
          margin: 2%;
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
    </head>
	<body>
       
<?php 
    include 'header.php';
    include 'include/db_credentials.php';
?>
<h2><img src="https://i.imgur.com/AZOk0XJ.png" border="0"></h2>

<?php
include 'include/db_credentials.php';
// Retrieve and display info for the product
// $id = $_GET['id'];
$sql = "SELECT productId, productName, productPrice, productDesc, productImageURL, productImage FROM Product P WHERE productId = ?";

// $id = $_GET['productId'];
$id = ""; //Error here Notice: Undefined index: id in /srv/home/91175448/public_html/lab8/product.php on line 95 Invalid product
if (isset($_GET['productId'])){
    $id = $_GET['productId'];
}
else{
    print("Can I get uhhhh");
}

$con = sqlsrv_connect($server, $connectionInfo);
$pstmt = sqlsrv_query($con, $sql, array($id));

$sql = "";
if ($rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC)) 
{
    echo "<h2>" . $rst['productName'] . "</h2>";
    $prodId = $rst['productId'];
    $prodDesc = $rst['productDesc'];
     
    //  Image retreival with URL
    $imageLoc = $rst['productImageURL'];
        if ($imageLoc != null)
            echo "<img src=\"" . $imageLoc . "\" alt = \"".$rst['productName']."\" style = 'max-width: 50%; border-radius: 50%; margin: 2%; float: left'>";
        echo "</table>";

    // Image retreival from database
    $imageBinary = $rst['productImage'];
    if ($imageBinary != null)
        echo "<img src=\"displayImage.php?id=" . $prodId . "\" alt = \"".$rst['productName']."\">";
    echo "</table>";
    
    echo("<table border = \"1\" style = 'float: right'>");
    echo "<th>Id</th><td>" . $prodId . "</td></tr>"
        . "<tr><th>Price</th><td>$" . $rst['productPrice'] .  "</td></tr>" 
        ."<th>Description</th><td>" . $prodDesc . "</td></tr>";
    echo "<table><tr>";

        
    echo "<h4><a href=\"addcart.php?id=" . $prodId . "&name=" . $rst['productName']
            . "&price=" . $rst['productPrice'] . "\" style = 'float: right; margin: 2%; color: #EAEBED'>Add to Cart</a></h4>";
        
    echo "<h4><a href=\"listprod.php\" style = 'float: right; margin: 2%; color: #EAEBED'>Continue Shopping</a></h4>";    
}
else
{
    echo "Invalid product";
}
                 
sqlsrv_free_stmt($pstmt);
sqlsrv_close($con);
?>
</body>
</html>