<?php

    include("database.php");

    $showSearch  = true;
    $showPayroll = false;
    $employee    = "";
    $error       = "";

    $workingDays     = "";
    $otHours         = "";
    $basicPay        = 0;
    $otPay           = 0;
    $grossPay        = 0;
    $sss             = 0;
    $philHealth      = 0;
    $pagIbig         = 0;
    $totalDeductions = 0;
    $netPay          = 0;

    if (isset($_POST["search"])) {
        $employeeNumber = $_POST["employeeNumber"];
        $res            = getEmployee($employeeNumber);
        if (!$res) {
            $error       = "Employee Number Does Not Exist.";
        } else {
            $showSearch  = false;
            $showPayroll = true;
            $employee    = $res;
        }
    }

    if (isset($_POST["calculate"])) {
        $employeeNumber = $_POST["employeeNumber"];
        $dailyRate      = $_POST["dailyRate"];
        $workingDays    = $_POST["workingDays"];
        $otHours        = $_POST["otHours"];

        $employee    = getEmployee($employeeNumber);
        $showSearch  = false;
        $showPayroll = true;

        $basicPay        = $dailyRate * $workingDays;
        $otPay           = ($dailyRate / 8) * 1.25 * $otHours;
        $grossPay        = $basicPay + $otPay;
        $sss             = 581.30;
        $philHealth      = ($basicPay * 0.025) / 2;
        $pagIbig         = 100.00;
        $totalDeductions = $sss + $philHealth + $pagIbig;
        $netPay          = $grossPay - $totalDeductions;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll System</title>
</head>
<body>
    <h1>PAYROLL SYSTEM | PAYROLL MODULE</h1>
    <?php if (!empty($error)) echo "<b>$error</b>"; ?>
    <?php if ($showSearch): ?>
        <form method="POST">
            Employee Number:
            <input type="text" name="employeeNumber" required>
            <input type="submit" name="search" value="Search Employee">
        </form>
    <?php endif; ?>
    <?php if ($showPayroll): ?>
        <form method="POST">
            <table>
                <tr>
                    <td>Employee Number:</td>
                    <td><input type="text" name="employeeNumber" value="<?php echo $employee["employee_number"]; ?>" readonly><br></td>
                </tr>
                <tr>
                    <td>Employee Name:</td>
                    <td><input type="text" value="<?php echo $employee["employee_name"]; ?>" readonly><br></td>
                </tr>
                <tr>
                    <td>Department:</td>
                    <td><input type="text" value="<?php echo $employee["department_name"]; ?>" readonly><br></td>
                </tr>
                <tr>
                    <td>Employment Type:</td>
                    <td><input type="text" value="<?php echo $employee["employment_type"]; ?>" readonly><br></td>
                </tr>
                <tr>
                    <td>Daily Rate:</td>
                    <td><input type="text" name="dailyRate" value="<?php echo $employee["daily_rate"]; ?>" readonly><br></td>
                </tr>
                <tr>
                    <td>Working Days:</td>
                    <td><input type="number" min="1" name="workingDays" value="<?= $workingDays ?>" required><br></td>
                </tr>
                <tr>
                    <td>OT Hours:</td>
                    <td><input type="number" min="0" step="0.5" name="otHours" value="<?= $otHours ?>" required><br></td>
                </tr>
            </table>
            <br>
            <input type="submit" name="calculate" value="Calculate">
        </form>
    <?php endif; ?>
    <?php if (empty($error) && isset($_POST["calculate"])): ?>
        <br>
        <b>Payroll Summary for: <?= $employee["employee_name"] ?></b><br>
        Employee Number: <b><?= $employee["employee_number"] ?></b><br>
        Working Days: <b><?= intval($workingDays) ?></b> | OT Hours: <b><?= $otHours ?></b><br>
        <br>
        Basic Pay: <b>PHP <?= number_format($basicPay, 2) ?></b><br>
        OT Pay: <b>PHP <?= number_format($otPay, 2) ?></b><br>
        Gross Pay: <b>PHP <?= number_format($grossPay, 2) ?></b><br>
        <br>
        Deductions:<br>
        SSS: <b>PHP <?= number_format($sss, 2) ?></b><br>
        PhilHealth: <b>PHP <?= number_format($philHealth, 2) ?></b><br>
        Pag-IBIG: <b>PHP <?= number_format($pagIbig, 2) ?></b><br>
        Total Deductions: <b>PHP <?= number_format($totalDeductions, 2) ?></b><br>
        <br>
        Net Pay: <b>PHP <?= number_format($netPay, 2) ?></b><br>
    <?php endif; ?>
    <br>
    <button>
        <a href="index.html">Go Back</a>
    </button>
</body>
</html>
