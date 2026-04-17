<?php

    include("database.php");

    if (isset($_POST["delete"])) {
        deleteItem($_POST["itemCode"]);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation and Billing System</title>
</head>
<body>
    <h1>RESERVATION AND BILLING SYSTEM | ITEMS MODULE</h1>
    <form method="POST">
        Item Code:
        <input type="number" min="1" name="itemCode" required>
        <input type="submit" name="delete" value="Delete Item">
    </form>
    <br>
    <button>
        <a href="items.html">Go Back</a>
    </button>
</body>
</html>
