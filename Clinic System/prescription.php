<?php

    include("database.php");

    $patientName        = "";
    $drugId             = "";
    $startDate          = "";
    $endDate            = "";
    $prescriptionDosage = "";
    $error              = "";
    $periodDays         = 0;
    $units              = 0;
    $amountDue          = 0;

    if (isset($_POST["calculate"])) {

        $patientName        = $_POST["patientName"];
        $drugId             = $_POST["drugId"];
        $startDate          = $_POST["startDate"];
        $endDate            = $_POST["endDate"];
        $prescriptionDosage = $_POST["prescriptionDosage"];

        if (!drugIdExists($drugId)) {
            $error = "Drug ID Does Not Exist.";
        } else {
            $drug       = getDrug($drugId);
            $start      = new DateTime($startDate);
            $end        = new DateTime($endDate);
            $periodDays = $start->diff($end)->days;
            $units      = $periodDays * intval($prescriptionDosage);
            $amountDue  = $units * floatval($drug["price"]);
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
    <h1>CLINIC SYSTEM | PRESCRIPTION MODULE</h1>
    <?php if (!empty($error)): ?>
        <?= "<b>$error</b>" ?>
    <?php endif; ?>
    <form method="POST">
        <table>
            <tr>
                <td>Patient Name:</td>
                <td><input type="text" name="patientName" value="<?= $patientName ?>" required><br></td>
            </tr>
            <tr>
                <td>Drug ID:</td>
                <td><input type="text" name="drugId" value="<?= $drugId ?>" required><br></td>
            </tr>
            <tr>
                <td>Prescription Start Date:</td>
                <td><input type="date" name="startDate" value="<?= $startDate ?>" required><br></td>
            </tr>
            <tr>
                <td>Prescription End Date:</td>
                <td><input type="date" name="endDate" value="<?= $endDate ?>" required><br></td>
            </tr>
            <tr>
                <td>Prescription Dosage (units per day):</td>
                <td><input type="number" name="prescriptionDosage" min="1" value="<?= $prescriptionDosage ?>" required><br></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="calculate" value="Calculate">
    </form>
    <?php if (empty($error) && isset($_POST["calculate"])): ?>
        <br>
        <b>Prescription Summary for: <?= $patientName ?></b><br>
        Prescription Period: <b><?= $periodDays ?> day(s)</b><br>
        Units to Buy: <b><?= $units ?></b><br>
        Amount Due: <b>PHP <?= number_format($amountDue, 2) ?></b><br>
    <?php endif; ?>
    <br>
    <button>
        <a href="index.html">Go Back</a>
    </button>
</body>
</html>
