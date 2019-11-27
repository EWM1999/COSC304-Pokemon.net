<!DOCTYPE html>
<html>
<head>
<title>Customer Page</title>
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
        <h1 style="float:left"><img src="https://i.imgur.com/LH65A0E.png" border="0"></h1>'

        <?php
          include 'auth.php';
          include 'loginHeader.php';
          echo("<br>");
          include 'header.php';
        ?>
    </div>

  <?php 
      include 'include/db_credentials.php';
    $con = sqlsrv_connect($server, $connectionInfo);
    if( $con === false ) {
      die( print_r( sqlsrv_errors(), true));
    }
  ?>

  <?php

  // print user information
  $user = $_SESSION['authenticatedUser'];
  $sql = "SELECT customerId, firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid from customer where userid = ?";
  $results = sqlsrv_query($con, $sql, array($user));
  #echo('<h3>Customer Information</h3>');
  #echo('test');
  if($rst = sqlsrv_fetch_array( $results, SQLSRV_FETCH_ASSOC)){
    echo("<table border = \"2\"> <tr><td>Id</td><td>".$rst['customerId']."</td></tr><tr><td>First Name</td><td>".$rst['firstName']."</td></tr><tr><td>Last Name</td><td>".$rst['lastName']."</td></tr><tr><td>Email</td><td>".$rst['email']."<tr><td>Phone</td><td>".$rst['phonenum']."</td></tr><tr><td>Address</td><td>".$rst['address']."</td></tr><tr><td>City</td><td>".$rst['city']."</td></tr><tr><td>State</td><td>".$rst['state']."</td></tr><tr><td>Postal Code</td><td>".$rst['postalCode']."</td></tr><tr><td>Country</td><td>".$rst['country']."</td></tr><tr><td>User Id</td><td>".$rst['userid']."</td></tr></table>");
  }
  sqlsrv_free_stmt($results);
  sqlsrv_close($con);
  // Make sure to close connection
  ?>
  </body>
</html>