<?php

    include("database.php");

    if (isset($_POST["add"])) {

        $error          = "";
        $employeeNumber = "";

        $employeeName   = $_POST["employeeName"];
        $departmentName = $_POST["departmentName"];
        $dateHired      = $_POST["dateHired"];
        $employmentType = $_POST["employmentType"];
        $dailyRate      = $_POST["dailyRate"];

        $res = addEmployee($employeeName, $departmentName, $dateHired, $employmentType, $dailyRate);
        if (!$res) {
            $error = "Failed to add employee.";
        } else {
            $employeeNumber = $res;
        }
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
    <p><b>ADD EMPLOYEE</b></p>
    <?php
        if (!empty($error)) {
            echo "<b>$error</b>";
        } else {
            if (isset($employeeNumber) && !empty($employeeNumber)) {
                echo "<b>Successfully added employee. Employee Number: $employeeNumber</b>";
            }
        }
    ?>
    <form method="POST">
        <table>
            <tr>
                <td>Employee Name:</td>
                <td><input type="text" name="employeeName" required><br></td>
            </tr>
            <tr>
                <td>Department Name:</td>
                <td><input type="text" name="departmentName" required><br></td>
            </tr>
            <tr>
                <td>Date Hired:</td>
                <td><input type="date" name="dateHired" required><br></td>
            </tr>
            <tr>
                <td>Employment Type:</td>
                <td>
                    <select name="employmentType">
                        <option value="Regular">Regular</option>
                        <option value="Contractual">Contractual</option>
                        <option value="Probationary">Probationary</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Daily Rate:</td>
                <td><input type="number" step="0.01" min="0" name="dailyRate" required><br></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="add" value="Add Employee">
    </form>
    <br>
    <button>
        <a href="employees.html">Go Back</a>
    </button>
</body>
</html>
