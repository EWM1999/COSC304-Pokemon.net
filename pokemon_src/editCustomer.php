<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page

 
// Include config file
include 'include/db_credentials.php';;
 
// Define variables and initialize with empty values
$new_userid = $new_email = $new_address = $new_city = $new_state = $new_postalCode = $new_country= $new_firstName = $new_lastName = $new_phone = "";
$new_userid_err = $new_email_err = $new_address_err = $new_city_err = $new_state_err = $new_postalCode_err = $new_country_err = $new_firstName_err = $new_lastName_err = $new_phone_err="";
$link = sqlsrv_connect($server, $connectionInfo);
$user = $_SESSION['authenticatedUser'];
$id = "";
$sql = "SELECT customerId FROM customer where userid = ?";
$r2 = sqlsrv_query($link, $sql, array($user));
if($row = sqlsrv_fetch_array($r2, SQLSRV_FETCH_ASSOC)){
  $id = $row['customerId'];
}
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["new_userid"]))){
        $new_userid_err = "Please enter a username.";
    } else{
        // Prepare a select statement
       
            $new_userid = trim($_POST["new_userid"]);
           
         
         
         
        // Close statement
       // mysqli_stmt_close($stmt);
    }
    if(empty(trim($_POST["new_firstName"]))){
        $new_firstName_err = "Please enter a first name.";
    } else{
        // Prepare a select statement
          $new_firstName = trim($_POST["new_firstName"]);
        }
    
    if(empty(trim($_POST["new_lastName"]))){
        $new_lastName_err = "Please enter a last name.";
    } else{
        // Prepare a select statement
          $new_lastName = trim($_POST["new_lastName"]);
        }
    

    if(empty(trim($_POST["new_phone"]))){
        $new_phone_err = "Please enter a Phone Number.";
    } else{
        // Prepare a select statement
          $new_phone = trim($_POST["new_phone"]);
        }
    

    if(empty(trim($_POST["new_email"]))){
        $new_email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
          $mystring = trim($_POST["new_email"]);
          $word = '@';
          $word2 = '.';
          if(strpos($mystring, $word) > 0 and strpos($mystring, $word) >0 ){
            $new_email = trim($_POST["new_email"]);
          }else{
            $new_email_err = "Enter a Valid Email Address";
          }
        }
    

    if(empty(trim($_POST["new_address"]))){
        $new_address_err = "Please enter an address.";
    } else{
        // Prepare a select statement
          $new_address = trim($_POST["new_address"]);
        }
    

    if(empty(trim($_POST["new_city"]))){
        $new_city_err = "Please enter a city.";
    } else{
        // Prepare a select statement
          $new_city = trim($_POST["new_city"]);
        }
    
     if(empty(trim($_POST["new_state"]))){
        $new_state_err = "Please enter a state.";
    } else{
        // Prepare a select statement
          $new_state = trim($_POST["new_state"]);
        }
    
    if(empty(trim($_POST["new_postalCode"]))){
        $new_postalCode_err = "Please enter a postal code.";
    } else{
        // Prepare a select statement
          $new_postalCode = trim($_POST["new_postalCode"]);
        }
    
    if(empty(trim($_POST["new_country"]))){
        $new_country_err = "Please enter a country.";
    } else{
        // Prepare a select statement
          $new_country = trim($_POST["new_country"]);
        }
        
    // Check input errors before updating the database
    if($new_userid_err == "" && empty($new_firstName_err)&& empty($new_lastName_err)&& empty($new_email_err)&& empty($new_phone_err)&& empty($new_address_err)&& empty($new_city_err)&& empty($new_state_err)&& empty($new_postalCode_err)&& empty($new_country_err)){
        // Prepare an update statement
        $sql = "UPDATE customer SET userid = ?, firstName = ?, lastName = ?, email = ?, phonenum = ?, address = ?, city = ?, state = ?, postalCode = ?, country = ? WHERE customerId = ?";
        //echo("".$new_userid.$new_firstName.$new_lastName.$new_email. $new_phone.$new_address.$new_city. $new_state.$new_postalCode. $new_country."");
            // Bind variables to the prepared statement as parameters
        echo($new_userid);
            $result = sqlsrv_query($link, $sql, array($new_userid, $new_firstName, $new_lastName, $new_email, $new_phone,$new_address, $new_city, $new_state,$new_postalCode, $new_country, $id));
            //echo($user);
            // Attempt to execute the prepared statement
            if($result){
                // Password updated successfully. Destroy the session, and redirect to login page

                session_destroy();
                header("location: login.php");
                exit();
                //echo($user);
               // echo($new_password);
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        
        
        // Close statement
        //mysqli_stmt_close($stmt);
    }
    
    // Close connection
    sqlsrv_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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
    <div class="wrapper" style  = "margin-left: 5%">
        <h2>Update Information</h2>
        <p>Please fill out this form to update your customer information.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_userid_err)) ? 'has-error' : ''; ?>">
                <label>New Username</label>
                <input type="text" name="new_userid" class="form-control" value="<?php echo $new_userid; ?>">
                <span class="help-block"><?php echo $new_userid_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_firstName_err)) ? 'has-error' : ''; ?>">
                <label>New First Name</label>
                <input type="text" name="new_firstName" class="form-control" value="<?php echo $new_firstName; ?>">
                <span class="help-block"><?php echo $new_firstName_err; ?></span>
            </div>
             <div class="form-group <?php echo (!empty($new_lastName_err)) ? 'has-error' : ''; ?>">
                <label>New Last Name</label>
                <input type="text" name="new_lastName" class="form-control" value="<?php echo $new_lastName; ?>"required>
                <span class="help-block"><?php echo $new_lastName_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($new_email_err)) ? 'has-error' : ''; ?>">
                <label>New Email</label>
                <input type="text" name="new_email" class="form-control" value="<?php echo $new_email; ?>"required>
                <span class="help-block"><?php echo $new_email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_phone_err)) ? 'has-error' : ''; ?>">
                <label>New Phone Number</label>
                <input type="text" name="new_phone" class="form-control" value="<?php echo $new_phone; ?>"required>
                <span class="help-block"><?php echo $new_phone_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_address_err)) ? 'has-error' : ''; ?>">
                <label>New Address</label>
                <input type="text" name="new_address" class="form-control" value="<?php echo $new_address; ?>"required>
                <span class="help-block"><?php echo $new_address_err; ?></span>
            </div>
             <div class="form-group <?php echo (!empty($new_city_err)) ? 'has-error' : ''; ?>">
                <label>New City</label>
                <input type="text" name="new_city" class="form-control" value="<?php echo $new_city; ?>"required>
                <span class="help-block"><?php echo $new_city_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_state_err)) ? 'has-error' : ''; ?>">
                <label>New State</label>
                <input type="text" name="new_state" class="form-control" value="<?php echo $new_state; ?>"required>
                <span class="help-block"><?php echo $new_state_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_postalCode_err)) ? 'has-error' : ''; ?>">
                <label>New Postal Code</label>
                <input type="text" name="new_postalCode" class="form-control" value="<?php echo $new_postalCode; ?>"required>
                <span class="help-block"><?php echo $new_postalCode_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_country_err)) ? 'has-error' : ''; ?>">
                <label>New Country</label>
                <input type="text" name="new_country" class="form-control" value="<?php echo $new_country; ?>"required>
                <span class="help-block"><?php echo $new_country_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="index.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>