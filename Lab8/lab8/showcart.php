<!DOCTYPE html>
<html>
<head>
<title>Your Shopping Cart</title>
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
  <div class = "container">
  <?php
  // Get the current list of products

  session_start();
  if(isset($_SESSION['err_message'])){
            if ($_SESSION['err_message']  != null) 
              $message = $_SESSION['err_message']; 
              echo "<script type='text/javascript'>alert('$message');</script>";
            }
  $_SESSION['err_message'] = null;
  $productList = null;
  if (isset($_SESSION['productList'])){
    $productList = $_SESSION['productList'];
    echo("<h1 style=\"float:left\"><img src='https://i.imgur.com/iGaHTLA.png' border='0'></h1>");
    include('loginHeader.php');
    echo("<br><br>");
    echo("<form action=\"updatecart.php\"><table border = \"1\"><tr><th>Product Id</th><th>Product Name</th><th>Quantity</th>");
    echo("<th>Price</th><th>Subtotal</th><th>Remove from Order</th><th>Change Quantity</th></tr>");
    $count = 0;
    $total =0;
    foreach ($productList as $id => $prod) {
      $quantity = $prod['quantity'];
      if(isset($_GET['update'])){
          $quantity = $_GET['newqty'];
          //echo($quantity);
      }
      $count = $count + 1;
      echo("<tr><td>". $prod['id'] . "</td>");
      echo("<td>" . $prod['name'] . "</td>");

      echo("<td align=\"center\"><input type='number' name='quantity-".$prod['id']."' size='3' placeholder='". $prod['quantity'] . "'\></td>");
      $price = $prod['price'];

      echo("<td align=\"right\">$" . number_format($price ,2) ."</td>");
      echo("<td align=\"right\">$" . number_format($quantity*$price, 2) . "</td>");
      echo("<td><a class=deletecartoption href='deletecart.php?did=".$prod['id']."'>Remove Item from Cart</a></td>");
      // Change quantities of product in shopping cart
      /*echo("<td><input type=\"button\" onclick=\"update(".$prod['id'].", document.form1.newqty".$count.".value)\" value=\"Update Quantity\"></td></tr>");*/
      echo("<td colspan=\"5\" align=\"right\"> <input type=\"submit\" class=\"btn btn-primary\" value=\"Update Quantity\"/></td></tr>");
      echo("</tr>");
      $total = $total +$quantity*$price;
    }
    echo("<tr><td colspan=\"4\" align=\"right\"><b>Order Total</b></td><td align=\"right\">$" . number_format($total,2) ."</td></tr>");
    echo("</table>");

    echo("<h3><a href=\"checkout.php\">Check Out</a></h3>");
  } else{
    echo("<h3>Your shopping cart is empty!</h3>");
  }
  ?>
  <h3><a href="listprod.php">Continue Shopping</a></h3>

</div>
</body>
</html> 

