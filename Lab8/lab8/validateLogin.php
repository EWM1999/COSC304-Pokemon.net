<?php 
    session_start();          
    $authenticatedUser = validateLogin();
    
    if ($authenticatedUser != null)
        header('Location: index.php');      		// Successful login
    else
        header('Location: login.php');	             // Failed login - redirect back to login page with a message     
    
	function validateLogin()
	{	  
	    $user = $_POST["username"];	 
	    $pw = $_POST["password"];
		$retStr = null;

		if ($user == null || $pw == null)
			return null;
		if ((strlen($user) == 0) || (strlen($pw) == 0))
			return null;

		include 'include/db_credentials.php';
		$con = sqlsrv_connect($server, $connectionInfo);
		
		// TODO: Check if userId and password match some customer account. If so, set retStr to be the username.
		$sql = "SELECT customerId, admin FROM customer WHERE userid = ? AND password = ?;";	
		$stmt = sqlsrv_query($con, $sql, array($user, $pw));
		if(!stmt)
			die("<p>There has been an error in validating your account. I tried and I failed.</p>");
		if($rst = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
			// the userid and password fields aren't actually unique. You can have two of the same.
			// so im just checking to see if there is someone.
			$retStr = $user;
			$_SESSION['admin']=$rst['admin'];

			// also I'm saving the customerId to the session because it would really speed up our queries
		}
		
		// i don't think im tehnically using a prepared statement
		sqlsrv_free_stmt($pstmt);
		sqlsrv_close($con);
		
		if ($retStr != null)
		{	$_SESSION["loginMessage"] = null;
	       	$_SESSION["authenticatedUser"] = $user;
		}
		else
		    $_SESSION["loginMessage"] = "Could not connect to the system using that username/password.";

		return $retStr;
	}	
?>
