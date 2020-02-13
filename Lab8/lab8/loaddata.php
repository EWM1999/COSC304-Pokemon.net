<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
	session_start();
	if($_SESSION['admin'] != 1){
		header('Location: index.php');
	}

	include 'include/db_credentials.php';
	$con = sqlsrv_connect($server, $connectionInfo);
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}

	$fileName = "./data/pokemon_db.ddl";

	$file = file_get_contents($fileName, true);
	$lines = explode(";", $file);
	foreach ($lines as $line){
		$line = trim($line);
		if($line != ""){
			sqlsrv_query($con, $line, array());
		}
	}
	sqlsrv_close($con);

	header("Location: admin.php");
?>
</body>
</html>