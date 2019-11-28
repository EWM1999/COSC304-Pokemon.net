<?php

include 'auth.php';

//productName, categoryId, productDesc, productPrice

if(!isset($_GET['productName']) || !isset($_GET['categoryName']) || !isset($_GET['productPrice'])){
    $_SESSION['addProductMessage'] = "literally i made this fucking required how did you do this";
    header('Location: dataManagement.php');
}

$productName = $_GET['productName'];
$categoryName = $_GET['categoryName'];
$productPrice = floatval($_GET['productPrice']);


$productDesc = null;
if(isset($_GET['$productDesc'])){
    $productDesc = $_GET['productDesc'];
}

include 'include/db_credentials.php';
$con = sqlsrv_connect($server, $connectionInfo);


// checking the category
$categoryId = 0;
$sql = "SELECT categoryId FROM category WHERE UPPER(categoryName)=UPPER(?);";
$result = sqlsrv_query($con, $sql, array($categoryName));
if(!$result){
    die("<p>I borke the query. sorry fam i really thought that would work</p>");
}
if ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    $categoryId = $row['categoryId'];
}else{
    $_SESSION['addProductMessage'] = "that's not a category. dont do that";
    header('Location: dataManagement.php');
}


// adding the dude
$sql = "INSERT product(productName, categoryId, productDesc, productPrice) VALUES (?, ?, ?,?);";
$result = sqlsrv_query($con, $sql, array($productName, $categoryId, $productDesc, $productPrice));
if(!$result){
    die('<p> i brok the query sorry fam i really thought that would work</p>');
}

sqlsrv_close($con);
$_SESSION['addProductMessage'] = null;
header("Location: listprod.php");

?>