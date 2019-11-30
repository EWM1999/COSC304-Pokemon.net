<?php
include 'auth.php';
include 'include/db_credentials.php';

$userid = $_SESSION["authenticatedUser"];

if(!isset($_GET['reviewRating']) || !isset($_GET['productId'])){
    header("Location: product.php");
}

$reviewRating = $_GET['reviewRating'];
$productId = $_GET['productId'];

$reviewComment = "";
if(isset($_GET['reviewComment'])){
    $reviewComment = $_GET['reviewComment'];
}

$reviewDate = date('Y-m-d H:i:s');

$con = sqlsrv_connect($server, $connectionInfo);

$sql = "SELECT customerId FROM customer c WHERE userid = ? AND customerId NOT IN (SELECT customerId FROM review WHERE productId = ?);";
$result = sqlsrv_query($con, $sql, array($userid, $productId));
if ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    $customerId = $row['customerId'];

    $sql = "INSERT review (reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (?,?,?,?,?);";
    $result = sqlsrv_query($con, $sql, array($reviewRating, $reviewDate, $customerId, $productId, $reviewComment));
    if(!$result){
        die("idk the query didn't insert or something. idk how to fix that");
    }
}
sqlsrv_close($con);
header("Location: product.php?productId=".$productId);
?>