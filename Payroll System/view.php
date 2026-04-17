<?php

    include("database.php");

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
            $employees = getEmployees();
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
    <br>
    <button>
        <a href="employees.html">Go Back</a>
    </button>
</body>
</html>
