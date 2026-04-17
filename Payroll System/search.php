<?php

    include("database.php");

    $employees       = "";
    $showFilter      = true;
    $showValue       = false;
    $filter          = "";
    $validatedFields = ["date_hired", "daily_rate"];
    $needsValidation = false;

    if (isset($_POST["search"])) {
        $column     = $_POST["filter"];
        $value      = $_POST["value"];
        $showFilter = true;
        $showValue  = false;
        $employees  = searchEmployee($column, $value);
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
    <title>Payroll System</title>
</head>
<body>
    <h1>PAYROLL SYSTEM | EMPLOYEES MODULE</h1>
    <?php if ($showFilter): ?>
    <form method="POST">
        Filter:
        <select name="column">
            <option value="employee_number">Employee Number</option>
            <option value="employee_name">Employee Name</option>
            <option value="department_name">Department Name</option>
            <option value="date_hired">Date Hired</option>
            <option value="employment_type">Employment Type</option>
            <option value="daily_rate">Daily Rate</option>
        </select>
        <input type="submit" name="filter" value="Next">
    </form>
    <?php endif; ?>
    <?php if ($showValue): ?>
    <form method="POST">
        Value:
        <?php if ($needsValidation): ?>
            <?php if ($filter === "date_hired"): ?>
                <input type="date" name="value" required>
            <?php endif; ?>
            <?php if ($filter === "daily_rate"): ?>
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
                    <td><b>Employee Number</b></td>
                    <td><b>Employee Name</b></td>
                    <td><b>Department</b></td>
                    <td><b>Date Hired</b></td>
                    <td><b>Employment Type</b></td>
                    <td><b>Daily Rate</b></td>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($employees as $employee) {
                    $employeeNumber = $employee["employee_number"];
                    $employeeName   = $employee["employee_name"];
                    $departmentName = $employee["department_name"];
                    $dateHired      = $employee["date_hired"];
                    $employmentType = $employee["employment_type"];
                    $dailyRate      = $employee["daily_rate"];
                    echo "<tr>";
                    echo "<td>$employeeNumber</td>";
                    echo "<td>$employeeName</td>";
                    echo "<td>$departmentName</td>";
                    echo "<td>$dateHired</td>";
                    echo "<td>$employmentType</td>";
                    echo "<td>PHP $dailyRate</td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    <?php endif; ?>
    <br>
    <button>
        <a href="employees.html">Go Back</a>
    </button>
</body>
</html>
