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
      .login_things{
          text-align: right;
          color: #FFCB05;
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

  <div class="container">
  <h3 class="muted">Pokémon.net</h3>
  <h1 style="float:left"><img src="https://i.imgur.com/AZOk0XJ.png" border="0"></h1>
  <?php
    include 'loginHeader.php';
  ?>
  <br></div>
       
<?php 
    include 'header.php';
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
if ($rst = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC)) {
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

    sqlsrv_free_stmt($pstmt);

    /* Adding reviews? */
    echo "<h2>Reviews</h2>";

    // viewing previous reviews
    $sql = "SELECT reviewRating, reviewDate, reviewComment FROM Review WHERE productId = ?";
    $con = sqlsrv_connect($server, $connectionInfo);
    $pstmt = sqlsrv_query($con, $sql, array($prodId));
    if(!$pstmt){
      echo("can I get uhhh");
    }
    if($row = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC)){
      echo("<table border = \"2\" style = 'float: right'>");
      echo("<tr><th>Review Date</th><th>Review Rating</th><th>Review Comment</th></tr>");
      echo("<tr><td>".$row['reviewDate']->format('Y-m-d')."</td><td>".$row['reviewRating']."</td><td>".$row['reviewComment']."</td></tr>");
      while ($row = sqlsrv_fetch_array($pstmt, SQLSRV_FETCH_ASSOC)){
        echo("<tr><td>".$row['reviewDate']->format('Y-m-d')."</td><td>".$row['reviewRating']."</td><td>".$row['reviewComment']."</td></tr>");
      }
      echo "<table>";
    }else{
      echo("<p>There are no reviews of this item yet</p>");
    }

    // adding your own review
    echo("<h4>Review this Product</h4>");
    echo("<p>All reviews are anonymous, for your safety. Ids are for internal use only</p>");
    echo("<form method='get' action='review.php?'>");
    echo("<input type=\"hidden\" name=\"productId\" value=".$prodId.">");
    echo("<p>Product Rating</p>");
    echo('<input type="number" name="reviewRating" max=5 min=1 required><br>');
    echo("<p>Comment</p>");
    echo('<input type="text" name="reviewComment" maxlength=1000><br>');
    echo('<input type="submit" value="submit">');
    echo("</form>");

  }else{
    echo "Invalid product";
}
                 
sqlsrv_close($con);
?>
</body>
</html>