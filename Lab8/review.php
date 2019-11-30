<?php
include 'auth.php';
include 'include/db_credentials.php';

if(!isset($_GET['reviewRating']) || !isset($_GET['customerId']) || !isset($_GET['productId']) || !isset($_GET['reviewComment'])){
    if(!isset($_GET['productId'])){
        die("well that didn't work");
    }
    header("Location: product.php");
}

$reviewRating = $_GET['reviewRating'];
$customerId = $_GET['customerId'];
$productId = $_GET['productId'];
$reviewComment = $_GET['reviewComment'];
$reviewDate = date('Y-m-d H:i:s');


$con = sqlsrv_connect($server, $connectionInfo);
$sql = "INSERT INTO review (reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (?,?,?,?,?);";
$results = sqlsrv_query($con, $sql, array($reviewRating, $reviewDate, $customerId, $productId, $reviewComment));
if(!sqlsrv_fetch($result)){
	die("idk the query didn't insert or something. idk how to fix that");
}
sqlsrv_close($con);
header("Location: product.php?productId=".$productId);
?>