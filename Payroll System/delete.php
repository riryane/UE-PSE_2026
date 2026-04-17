<?php

    include("database.php");

    if (isset($_POST["delete"])) {
        deleteEmployee($_POST["employeeNumber"]);
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
    <form method="POST">
        Employee Number:
        <input type="text" name="employeeNumber" required>
        <input type="submit" name="delete" value="Delete Employee">
    </form>
    <br>
    <button>
        <a href="employees.html">Go Back</a>
    </button>
</body>
</html>
