<?php

    include("database.php");

    if (isset($_POST["add"])) {

        $error    = "";
        $itemCode = "";

        $itemDescription = $_POST["itemDescription"];
        $price           = $_POST["price"];

        $res = addItem($itemDescription, $price);
        if (!$res) {
            $error = "Failed to add item.";
        } else {
            $itemCode = $res;
        }
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
    <p><b>ADD ITEM</b></p>
    <?php
        if (!empty($error)) {
            echo "<b>$error</b>";
        } else {
            if (isset($itemCode) && !empty($itemCode)) {
                echo "<b>Successfully added item. Item Code: $itemCode</b>";
            }
        }
    ?>
    <form method="POST">
        <table>
            <tr>
                <td>Item Description:</td>
                <td><input type="text" name="itemDescription" required><br></td>
            </tr>
            <tr>
                <td>Price (PHP):</td>
                <td><input type="number" step="0.01" min="0" name="price" required><br></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="add" value="Add Item">
    </form>
    <br>
    <button>
        <a href="items.html">Go Back</a>
    </button>
</body>
</html>
