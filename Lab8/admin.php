<!DOCTYPE html>
<html>
<head>
<title>Administrator Page</title>
</head>
<body>

<?php 
// TODO: Include files auth.php and include/db_credentials.php
include 'include/db_credentials.php';
include 'auth.php'

?>

<?php
// TODO: Write SQL query that prints out total order amount by day

/*

SELECT SUM(totalAmount) as total_order_amount
FROM ordersummary
GROUP BY orderDate
ORDER BY orderDate DESC;


ughhh i want to save the customerId so i don't have to joinnnn

*/
$userId = $_SESSION['authenticatedUser'];

$con = sqlsrv_connect($server, $connectionInfo);

$sql = "SELECT orderDate, SUM(totalAmount) as total FROM ordersummary, customer WHERE customer.customerId = ordersummary.customerId AND customer.userid = ? GROUP BY orderDate ORDER BY orderDate DESC;";
$result = sqlsrv_query($con, $sql, array($userId));

if(!$result){
    die('<p> i brok the query sorry fam i really thought that would work</p>');
}

echo('<table border = \"2\">');
echo('<th><td>Order Date</td><td>Total Order Amount</td></th>');

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    $orderDate = $row['orderDate'];
    $total = $row['total'];
    echo('<tr><td>'.$orderDate->format('Y-m-d H:i:s')."</td><td>".$total."</td></tr>");
}
echo("</table>");

sqlsrv_close($con);


?>
</body>
</html>
