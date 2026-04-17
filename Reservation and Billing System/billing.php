<?php

    include("database.php");

    $customerNumber      = "";
    $reservationDate     = "";
    $expectedPaymentDate = "";
    $paymentType         = "";
    $error               = "";
    $subtotal            = 0;
    $amountDue           = 0;
    $discount            = 0;
    $multiplier          = 1.0;
    $adjustmentLabel     = "";
    $orderedItems        = [];

    if (isset($_POST["calculate"])) {

        $customerNumber      = $_POST["customerNumber"];
        $reservationDate     = $_POST["reservationDate"];
        $expectedPaymentDate = $_POST["expectedPaymentDate"];
        $paymentType         = $_POST["paymentType"];
        $itemCodes           = $_POST["itemCode"];
        $quantities          = $_POST["quantity"];

        // Process each item row
        for ($i = 0; $i < count($itemCodes); $i++) {
            if (!empty($itemCodes[$i]) && !empty($quantities[$i])) {
                $code = $itemCodes[$i];
                $qty  = intval($quantities[$i]);
                if (!itemExists($code)) {
                    $error = "Item Code $code does not exist.";
                    break;
                }
                $item      = getItem($code);
                $lineTotal = floatval($item["price"]) * $qty;
                $subtotal += $lineTotal;
                $orderedItems[] = [
                    "code"        => $code,
                    "description" => $item["item_description"],
                    "price"       => $item["price"],
                    "quantity"    => $qty,
                    "lineTotal"   => $lineTotal
                ];
            }
        }

        if (empty($error) && empty($orderedItems)) {
            $error = "Please enter at least one item.";
        }

        if (empty($error)) {
            // Compare today vs expected payment date
            $today    = strtotime(date("Y-m-d"));
            $expected = strtotime($expectedPaymentDate);
            $diffDays = ($today - $expected) / (60 * 60 * 24);

            if ($paymentType === "CASH") {
                if ($diffDays < 0) {
                    $multiplier       = 0.90;
                    $adjustmentLabel  = "10% Discount (paid before expected date)";
                } else if ($diffDays == 0) {
                    $multiplier       = 0.95;
                    $adjustmentLabel  = "5% Discount (paid on expected date)";
                } else if ($diffDays > 5) {
                    $multiplier       = 1.03;
                    $adjustmentLabel  = "3% Surcharge (paid more than 5 days after expected date)";
                } else {
                    $multiplier       = 1.0;
                    $adjustmentLabel  = "No adjustment (paid 1-5 days after expected date)";
                }
            } else {
                if ($diffDays < 0) {
                    $multiplier       = 0.95;
                    $adjustmentLabel  = "5% Discount (paid before expected date)";
                } else if ($diffDays == 0) {
                    $multiplier       = 0.98;
                    $adjustmentLabel  = "2% Discount (paid on expected date)";
                } else if ($diffDays > 5) {
                    $multiplier       = 1.05;
                    $adjustmentLabel  = "5% Surcharge (paid more than 5 days after expected date)";
                } else {
                    $multiplier       = 1.0;
                    $adjustmentLabel  = "No adjustment (paid 1-5 days after expected date)";
                }
            }

            $amountDue = $subtotal * $multiplier;
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
    <h1>RESERVATION AND BILLING SYSTEM | BILLING MODULE</h1>
    <?php if (!empty($error)): ?>
        <?= "<b>$error</b>" ?>
    <?php endif; ?>
    <form method="POST">
        <table>
            <tr>
                <td>Customer Number:</td>
                <td><input type="text" name="customerNumber" value="<?= $customerNumber ?>" required><br></td>
            </tr>
            <tr>
                <td>Reservation Date:</td>
                <td><input type="date" name="reservationDate" value="<?= $reservationDate ?>" required><br></td>
            </tr>
            <tr>
                <td>Expected Payment Date:</td>
                <td><input type="date" name="expectedPaymentDate" value="<?= $expectedPaymentDate ?>" required><br></td>
            </tr>
            <tr>
                <td>Payment Type:</td>
                <td>
                    <select name="paymentType">
                        <option value="CASH" <?php if ($paymentType === "CASH") echo "selected=\"selected\""; ?>>CASH</option>
                        <option value="CREDIT" <?php if ($paymentType === "CREDIT") echo "selected=\"selected\""; ?>>CREDIT</option>
                    </select>
                </td>
            </tr>
        </table>
        <br>
        <p><b>Items to Order:</b></p>
        <table>
            <tr>
                <td><b>Item Code</b></td>
                <td><b>Quantity</b></td>
            </tr>
            <tr>
                <td><input type="number" min="1" name="itemCode[]"><br></td>
                <td><input type="number" min="1" name="quantity[]"><br></td>
            </tr>
            <tr>
                <td><input type="number" min="1" name="itemCode[]"><br></td>
                <td><input type="number" min="1" name="quantity[]"><br></td>
            </tr>
            <tr>
                <td><input type="number" min="1" name="itemCode[]"><br></td>
                <td><input type="number" min="1" name="quantity[]"><br></td>
            </tr>
            <tr>
                <td><input type="number" min="1" name="itemCode[]"><br></td>
                <td><input type="number" min="1" name="quantity[]"><br></td>
            </tr>
            <tr>
                <td><input type="number" min="1" name="itemCode[]"><br></td>
                <td><input type="number" min="1" name="quantity[]"><br></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="calculate" value="Calculate">
    </form>
    <?php if (empty($error) && isset($_POST["calculate"]) && !empty($orderedItems)): ?>
        <br>
        <b>Billing Summary for Customer: <?= $customerNumber ?></b><br>
        Reservation Date: <b><?= $reservationDate ?></b><br>
        Expected Payment Date: <b><?= $expectedPaymentDate ?></b><br>
        Payment Type: <b><?= $paymentType ?></b><br>
        <br>
        <table>
            <thead>
                <tr>
                    <td><b>Item Code</b></td>
                    <td><b>Item Description</b></td>
                    <td><b>Unit Price</b></td>
                    <td><b>Quantity</b></td>
                    <td><b>Line Total</b></td>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orderedItems as $ordered): ?>
                <tr>
                    <td><?= $ordered["code"] ?></td>
                    <td><?= $ordered["description"] ?></td>
                    <td>PHP <?= number_format($ordered["price"], 2) ?></td>
                    <td><?= $ordered["quantity"] ?></td>
                    <td>PHP <?= number_format($ordered["lineTotal"], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        Subtotal: <b>PHP <?= number_format($subtotal, 2) ?></b><br>
        Adjustment: <b><?= $adjustmentLabel ?></b><br>
        Amount Due: <b>PHP <?= number_format($amountDue, 2) ?></b><br>
    <?php endif; ?>
    <br>
    <button>
        <a href="index.html">Go Back</a>
    </button>
</body>
</html>
