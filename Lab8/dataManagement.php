<!DOCTYPE html>
<html>
<head>
<title>Administrator Page</title>
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

    <div class="container">
        <h3 class="muted">Pokémon.net</h3>
      </div>

    <div class="container">
    <h1 style="float:left"><img src="https://i.imgur.com/5Yp1Afk.png" border="0"></h1>
    <?php
      include 'auth.php';
      include 'loginHeader.php';

      if(!issset($_SESSION['admin']) || $_SESSION['admin'] != 1){
          header('Location: index.php');
      }
      if(isset($_SESSION['addProductMessage']) && $_SESSION['addProductMessage'] != null){
          echo "<p>".$_SESSION['addProductMessage']."</p>";
      }
    ?>

    <br></div>

    <div class="container">
    <div class="masthead">
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
          <ul class="nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="admin.php">Admin Page</a></li>
            <li><a href="listorder.php">All Orders</a></li>
            <li><a href="listcust.php">All Customers</a></li>
            <li class="active"><a href="dataManagement.php">Manage Database</a></li>
          </ul>
          </div>
        </div>
    </div><!-- /.navbar -->
    </div>

    <!-- Add a Product -->
    <h3>Add a Product to the Database</h3>

    <form method="get" action="addProduct.php">
        Product Name:   <input type="text" name='productName' required maxlength=40><br>
        Category Name:  <input type="text" name='categoryName' required maxlength=50><br>
        Product Price:  <input type="text" name='productPrice' min=0 required value=4.20><br>
        Description:    <input type="text" name='productDesc' maxlength=1000><br>
        <input type="submit" value="submit">
    </form>

    <h3>Reload the Database From Default</h3>
    <form method="get" action="loaddata.php">
        <input type="submit" value="submit">
    </form>

  </body>
</html>

