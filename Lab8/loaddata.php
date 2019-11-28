<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
	include 'include/db_credentials.php';
	$con = sqlsrv_connect($server, $connectionInfo);
	echo("<h2>Connecting to database.</h2><p>");
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}

	$fileName = "./data/pokemon_db.ddl";
	if(isset($_GET['filename'])){
		$fileName=$_GET['filename'];
	}

	$file = file_get_contents($fileName, true);
	$lines = explode(";", $file);
	echo("<ol>");
	foreach ($lines as $line){
		$line = trim($line);
		if($line != ""){
			echo("<li>".$line . ";</li><br/>");
			sqlsrv_query($con, $line, array());
		}
	}
	sqlsrv_close($con);
	echo("</p><h2>Database loading complete!</h2>");
?>
</body>
</html>