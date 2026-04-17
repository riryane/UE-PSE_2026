<?php

    include("database.php");

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
    <table>
        <thead>
            <tr>
                <td><b>Item Code</b></td>
                <td><b>Item Description</b></td>
                <td><b>Price</b></td>
            </tr>
        </thead>
        <tbody>
        <?php
            $items = getItems();
            foreach ($items as $item) {
                $itemCode        = $item["id"];
                $itemDescription = $item["item_description"];
                $price           = $item["price"];
                echo "<tr>";
                echo "<td>$itemCode</td>";
                echo "<td>$itemDescription</td>";
                echo "<td>PHP $price</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    <br>
    <button>
        <a href="items.html">Go Back</a>
    </button>
</body>
</html>
