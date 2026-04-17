<?php

    include("database.php");

    $showSearch = true;
    $showEdit   = false;
    $drug       = "";
    $error      = "";

    if (isset($_POST["search"])) {
        $drugId = $_POST["drugId"];
        $res    = getDrug($drugId);
        if (!$res) {
            $error      = "Drug ID Does Not Exist.";
        } else {
            $showSearch = false;
            $showEdit   = true;
            $drug       = $res;
        }
    }

    if (isset($_POST["edit"])) {
        $drugId          = $_POST["drugId"];
        $drugDescription = $_POST["drugDescription"];
        $dosage          = $_POST["dosage"];
        $batchDate       = $_POST["batchDate"];
        $expirationDate  = $_POST["expirationDate"];
        $price           = $_POST["price"];

        $res = editDrug($drugId, $drugDescription, $dosage, $batchDate, $expirationDate, $price);
        if (!$res) {
            $error      = "Failed to edit drug.";
        } else {
            $showSearch = true;
            $showEdit   = false;
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
    <?php if ($showSearch): ?>
        <?php if (!empty($error)) echo "<b>$error</b>"; ?>
        <form method="POST">
            Drug ID:
            <input type="text" name="drugId" required>
            <input type="submit" name="search" value="Search Drug">
        </form>
    <?php endif; ?>
    <?php if ($showEdit): ?>
        <form method="POST">
            <table>
                <tr>
                    <td>Drug Description:</td>
                    <td><input type="text" name="drugDescription" value="<?php echo $drug["drug_description"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Dosage (quantity of usage):</td>
                    <td><input type="text" name="dosage" value="<?php echo $drug["dosage"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Batch Date:</td>
                    <td><input type="date" name="batchDate" value="<?php echo $drug["batch_date"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Expiration Date:</td>
                    <td><input type="date" name="expirationDate" value="<?php echo $drug["expiration_date"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Price (PHP):</td>
                    <td><input type="number" step="0.01" min="0" name="price" value="<?php echo $drug["price"]; ?>" required><br></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="drugId" value="<?php echo $drugId; ?>">
            <input type="submit" name="edit" value="Edit Drug">
        </form>
    <?php endif; ?>
    <br>
    <button>
        <a href="drugs.html">Go Back</a>
    </button>
</body>
</html>
