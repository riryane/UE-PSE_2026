<?php

    include("database.php");

    $drugs           = "";
    $showFilter      = true;
    $showValue       = false;
    $filter          = "";
    $validatedFields = ["batch_date", "expiration_date", "price"];
    $needsValidation = false;

    if (isset($_POST["search"])) {
        $column     = $_POST["filter"];
        $value      = $_POST["value"];
        $showFilter = true;
        $showValue  = false;
        $drugs      = searchDrug($column, $value);
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
    <title>Clinic System</title>
</head>
<body>
    <h1>CLINIC SYSTEM | PRESCRIPTION DRUGS MODULE</h1>
    <?php if ($showFilter): ?>
    <form method="POST">
        Filter:
        <select name="column">
            <option value="drug_id">Drug ID</option>
            <option value="drug_description">Drug Description</option>
            <option value="dosage">Dosage</option>
            <option value="batch_date">Batch Date</option>
            <option value="expiration_date">Expiration Date</option>
            <option value="price">Price</option>
        </select>
        <input type="submit" name="filter" value="Next">
    </form>
    <?php endif; ?>
    <?php if ($showValue): ?>
    <form method="POST">
        Value:
        <?php if ($needsValidation): ?>
            <?php if ($filter === "batch_date"): ?>
                <input type="date" name="value" required>
            <?php endif; ?>
            <?php if ($filter === "expiration_date"): ?>
                <input type="date" name="value" required>
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
                    <td><b>ID</b></td>
                    <td><b>Drug ID</b></td>
                    <td><b>Drug Description</b></td>
                    <td><b>Dosage</b></td>
                    <td><b>Batch Date</b></td>
                    <td><b>Expiration Date</b></td>
                    <td><b>Price</b></td>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($drugs as $drug) {
                    $id              = $drug["id"];
                    $drugId          = $drug["drug_id"];
                    $drugDescription = $drug["drug_description"];
                    $dosage          = $drug["dosage"];
                    $batchDate       = $drug["batch_date"];
                    $expirationDate  = $drug["expiration_date"];
                    $price           = $drug["price"];
                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td>$drugId</td>";
                    echo "<td>$drugDescription</td>";
                    echo "<td>$dosage</td>";
                    echo "<td>$batchDate</td>";
                    echo "<td>$expirationDate</td>";
                    echo "<td>PHP $price</td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    <?php endif; ?>
    <br>
    <button>
        <a href="drugs.html">Go Back</a>
    </button>
</body>
</html>
