<?php

    include("database.php");

    $items           = "";
    $showFilter      = true;
    $showValue       = false;
    $filter          = "";
    $validatedFields = ["id", "price"];
    $needsValidation = false;

    if (isset($_POST["search"])) {
        $column     = $_POST["filter"];
        $value      = $_POST["value"];
        $showFilter = true;
        $showValue  = false;
        $items      = searchItem($column, $value);
    } else if (isset($_POST["filter"])) {
        $filter          = $_POST["column"];
        $needsValidation = in_array($filter, $validatedFields);
        $showValue       = true;
        $showFilter      = false;
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
    <?php if ($showFilter): ?>
    <form method="POST">
        Filter:
        <select name="column">
            <option value="id">Item Code</option>
            <option value="item_description">Item Description</option>
            <option value="price">Price</option>
        </select>
        <input type="submit" name="filter" value="Next">
    </form>
    <?php endif; ?>
    <?php if ($showValue): ?>
    <form method="POST">
        Value:
        <?php if ($needsValidation): ?>
            <?php if ($filter === "id"): ?>
                <input type="number" min="1" name="value" required>
            <?php endif; ?>
            <?php if ($filter === "price"): ?>
                <input type="number" step="0.01" min="0" name="value" required>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!$needsValidation): ?>
            <input type="text" name="value" required>
        <?php endif; ?>
        <input type="hidden" name="filter" value="<?= $filter ?>">
        <input type="submit" name="search" value="Search">
    </form>
    <?php endif; ?>
    <?php if (isset($_POST["search"])): ?>
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
    <?php endif; ?>
    <br>
    <button>
        <a href="items.html">Go Back</a>
    </button>
</body>
</html>
