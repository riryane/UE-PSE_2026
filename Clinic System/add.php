<?php

    include("database.php");

    if (isset($_POST["add"])) {

        $error  = "";
        $drugId = "";

        $drugDescription = $_POST["drugDescription"];
        $dosage          = $_POST["dosage"];
        $batchDate       = $_POST["batchDate"];
        $expirationDate  = $_POST["expirationDate"];
        $price           = $_POST["price"];

        $res = addDrug($drugDescription, $dosage, $batchDate, $expirationDate, $price);
        if (!$res) {
            $error = "Failed to add drug.";
        } else {
            $drugId = $res;
        }
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
    <p><b>ADD DRUG</b></p>
    <?php
        if (!empty($error)) {
            echo "<b>$error</b>";
        } else {
            if (isset($drugId) && !empty($drugId)) {
                echo "<b>Successfully added drug. Drug ID: $drugId</b>";
            }
        }
    ?>
    <form method="POST">
        <table>
            <tr>
                <td>Drug Description:</td>
                <td><input type="text" name="drugDescription" required><br></td>
            </tr>
            <tr>
                <td>Dosage (quantity of usage):</td>
                <td><input type="text" name="dosage" required><br></td>
            </tr>
            <tr>
                <td>Batch Date:</td>
                <td><input type="date" name="batchDate" required><br></td>
            </tr>
            <tr>
                <td>Expiration Date:</td>
                <td><input type="date" name="expirationDate" required><br></td>
            </tr>
            <tr>
                <td>Price (PHP):</td>
                <td><input type="number" step="0.01" min="0" name="price" required><br></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="add" value="Add Drug">
    </form>
    <br>
    <button>
        <a href="drugs.html">Go Back</a>
    </button>
</body>
</html>
