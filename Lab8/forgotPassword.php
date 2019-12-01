<?php
//require_once('connect.php');
include 'include/db_credentials.php';
$link = sqlsrv_connect($server, $connectionInfo);
//require('config.php');
 //require('PHPMailer/PHPMailerAutoload.php');
$err_email = "";
if (isset($_POST['reset-password'])) {
  //$email = mysqli_real_escape_string($db, $_POST['email']);
	$email = $_POST['email'];
  // ensure that the user exists on our system
  $query = "SELECT email FROM customer WHERE email=?";
  $results = sqlsrv_query($link, $query, array($email));

  if (empty($email)) {
  	$err_email  = "Your email is required";
    echo($err_email);
  }else if(!($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC))) {
    $err_email = "Sorry, no user exists on our system with that email";
    echo($err_email);
  }
  // generate a unique random token of length 100
  //$token = bin2hex(random_bytes(50));

  if (empty($err_email)) {
    // store token in the password-reset database table against the user's email
    $sql = "SELECT password from customer where email = ?";
    $results = sqlsrv_query($link, $sql, array($email));
    $password = "ahhaha";
    if($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)){
    	$password = $row['password'];
    }
    // Send email to user with the token in a link they can click on
    $to = $email;
    $subject = "Reset your password on pokemon.net";
    $msg = "Hi there, reset your password here: cosc304.ok.ubc.ca/91175448/lab8/resetPassword.php";
    $msg = wordwrap($msg,70);
    $headers = "From: katchemall.pokemon.net@gmail.com";
    mail($to, $subject, $msg, $headers);
    header('location: pending.php');
  }
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<!-- Latest compiled and minified CSS -->
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
          width:77%;
          margin-left: 5%; 
          
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
	<form class="login-form" method="post">
		<h2 class="form-title">Reset password</h2>

		<div class="form-group">
			<label>Your email address</label>
			<input type="email" name="email">
		</div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Submit</button>
		</div>
	</form>
</body>
</html>