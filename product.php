<!DOCTYPE html>
<html>
<head>
<title>Pokemon</title>
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
    </style>
    <link href="bootstrap-responsive.css" rel="stylesheet">
</head>
<body>
<h1><<img src="https://i.imgur.com/cPbtQw3.png" border="0"></h1>
<?php 
    include 'header.php';
    include 'include/db_credentials.php';
?>

<?php
// Retrieve and display info for the product
// $id = $_GET['id'];
$sql = "SELECT productId, productName, productPrice, productImageURL, productImage FROM Product P WHERE productId = ?";
$id = $_GET['id'];

$con = sqlsrv_connect($server, $connectionInfo);
if($con == false){
    die(print_r(sqlsrv_errors(), true));
}
$pstmt = sqlsrv_query($con, $sql, array($id));

$sql = "";
if ($rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC)) 
{
    echo "<h2>" . $rst['productName'] . "</h2>";
    $prodId = $rst['productId'];
    echo "<table><tr>";
    echo "<th>Id</th><td>" . $prodId . "</td></tr>"
        . "<tr><th>Price</th><td>$" . $rst['productPrice'] .  "</td></tr>";
    
    //  Retrieve any image with a URL
    $imageLoc = $rst['productImageURL'];
    if ($imageLoc != null)
        echo "<img src=\"" . $imageLoc . "\">";
        
    // Retrieve any image stored directly in database
    $imageBinary = $rst['productImage'];
    if ($imageBinary != null)
        echo "<img src=\"displayImage.php?id=" . $prodId . "\">";
    
    echo "</table>";
        
        
    echo "<h3><a href=\"addcart.php?id=" . $prodId . "&name=" . $rst['productName']
            . "&price=" . $rst['productPrice'] . "\">Add to Cart</a></h3>";
        
    echo "<h3><a href=\"listprod.php\">Continue Shopping</a>";    
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