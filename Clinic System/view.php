<?php

    include("database.php");

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
            $drugs = getDrugs();
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
    <br>
    <button>
        <a href="drugs.html">Go Back</a>
    </button>
</body>
</html>
