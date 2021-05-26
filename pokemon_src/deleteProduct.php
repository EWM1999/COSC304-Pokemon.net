<?php

include 'auth.php';
if($_SESSION['admin'] != 1){
          header('Location: index.php');
      }

//productName, categoryId, productDesc, productPrice

if(!isset($_GET['productName'])){
    $_SESSION['addProductMessage'] = "literally i made this fucking required how did you do this";
    header('Location: dataManagement.php');
}
$productName = $_GET['productName'];

include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);

// deleting the dude
$sql = "DELETE FROM product WHERE productName = ?;";
$result = sqlsrv_query($con, $sql, array($productName));
if(!$result){
    die('<p> i brok the query sorry fam i really thought that would work</p>');
}

sqlsrv_close($con);
$_SESSION['addProductMessage'] = null;
header("Location: admin.php");

?>