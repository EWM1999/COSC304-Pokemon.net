<!DOCTYPE html>
<html>
<head>
<title>Pokémon CheckOut Line</title>
</head>
<body>

<h1>Enter your customer id and password to complete the transaction:</h1>

<form method="POST" action="order.php">
<input type="text" name="customerId" size="50" required>
<input type="password" name="password" size="30" required>
<input type="submit" value="Submit">
<input type="reset" value="Reset">
</form>

</body>
</html>