
<!DOCTYPE html>
<html>
<head>
<title>Sign Up</title>
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
<?php
// Include config file
include 'include/db_credentials.php';
$link = sqlsrv_connect($server, $connectionInfo);
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $address = $city = $state = $postalCode = $country= $firstName = $lastName = $phone = "";
$username_err = $password_err = $confirm_password_err = $email_err = $address_err = $city_err = $state_err = $postalCode_err = $country_err = $firstName_err = $lastName_err = $phone_err="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE userid = ?";
        
        
            // Bind variables to the prepared statement as parameters
            $r = sqlsrv_query($link, $stmt, array($param_username));
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
                
                if($row = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
           }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    if(empty(trim($_POST["firstName"]))){
        $firstName_err = "Please enter a first name.";
    } else{
        // Prepare a select statement
        	$firstName = trim($_POST["firstName"]);
        }
    }
    if(empty(trim($_POST["lastName"]))){
        $lastName_err = "Please enter a last name.";
    } else{
        // Prepare a select statement
        	$lastName = trim($_POST["lastName"]);
        }
    

    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter a Phone Number.";
    } else{
        // Prepare a select statement
        	$phone = trim($_POST["phone"]);
        }
    

    if(empty(trim($_POST["email"]))){
        $firstName_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        	$mystring = trim($_POST["email"]);
        	$word = '@';
        	$word2 = '.';
        	if(strpos($mystring, $word) > 0 and strpos($mystring, $word) >0 ){
        		$email = trim($_POST["email"]);
        	}else{
        		$email_err = "Enter a Valid Email Address";
        	}
        }
    

    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter an address.";
    } else{
        // Prepare a select statement
        	$address = trim($_POST["address"]);
        }
    

    if(empty(trim($_POST["city"]))){
        $city_err = "Please enter a city.";
    } else{
        // Prepare a select statement
        	$city = trim($_POST["city"]);
        }
    
     if(empty(trim($_POST["state"]))){
        $state_err = "Please enter a state.";
    } else{
        // Prepare a select statement
        	$state = trim($_POST["state"]);
        }
    
    if(empty(trim($_POST["postalCode"]))){
        $postalCode_err = "Please enter a postal code.";
    } else{
        // Prepare a select statement
        	$postalCode = trim($_POST["postalCode"]);
        }
    
    if(empty(trim($_POST["country"]))){
        $country_err = "Please enter a country.";
    } else{
        // Prepare a select statement
        	$country = trim($_POST["country"]);
        }
    
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

      if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            // Bind variables to the prepared statement as parameters
            $result1 = sqlsrv_query($con, $stmt, array($firstName, $lastName, $email, $phonenum, $address, $city, $state, $postalCode, $country, $username, $password));
            
            // Attempt to execute the prepared statement
            if($result1){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
         
        // Close statement
        sqlsrv_close($stmt);
    }
    
    // Close connection
    sqlsrv_close($link);

?>
 
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($firstName_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="firstName" class="form-control" value="<?php echo $firstName; ?>">
                <span class="help-block"><?php echo $firstName_err; ?></span>
            </div>  
              <div class="form-group <?php echo (!empty($lastName_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label>
                <input type="text" name="lastName" class="form-control" value="<?php echo $lastName; ?>">
                <span class="help-block"><?php echo $lastName_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>
             <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                <label>City</label>
                <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                <span class="help-block"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($state_err)) ? 'has-error' : ''; ?>">
                <label>State</label>
                <input type="text" name="state" class="form-control" value="<?php echo $state; ?>">
                <span class="help-block"><?php echo $state_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($postalCode_err)) ? 'has-error' : ''; ?>">
                <label>Postal Code</label>
                <input type="text" name="postalCode" class="form-control" value="<?php echo $postalCode; ?>">
                <span class="help-block"><?php echo $postalCode_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                <label>Country</label>
                <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                <span class="help-block"><?php echo $country_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>