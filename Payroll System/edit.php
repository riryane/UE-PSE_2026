<?php

    include("database.php");

    $showSearch = true;
    $showEdit   = false;
    $employee   = "";
    $error      = "";

    if (isset($_POST["search"])) {
        $employeeNumber = $_POST["employeeNumber"];
        $res            = getEmployee($employeeNumber);
        if (!$res) {
            $error      = "Employee Number Does Not Exist.";
        } else {
            $showSearch = false;
            $showEdit   = true;
            $employee   = $res;
        }
    }

    if (isset($_POST["edit"])) {
        $employeeNumber = $_POST["employeeNumber"];
        $employeeName   = $_POST["employeeName"];
        $departmentName = $_POST["departmentName"];
        $dateHired      = $_POST["dateHired"];
        $employmentType = $_POST["employmentType"];
        $dailyRate      = $_POST["dailyRate"];

        $res = editEmployee($employeeNumber, $employeeName, $departmentName, $dateHired, $employmentType, $dailyRate);
        if (!$res) {
            $error      = "Failed to edit employee.";
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
    <title>Payroll System</title>
</head>
<body>
    <h1>PAYROLL SYSTEM | EMPLOYEES MODULE</h1>
    <?php if ($showSearch): ?>
        <?php if (!empty($error)) echo "<b>$error</b>"; ?>
        <form method="POST">
            Employee Number:
            <input type="text" name="employeeNumber" required>
            <input type="submit" name="search" value="Search Employee">
        </form>
    <?php endif; ?>
    <?php if ($showEdit): ?>
        <form method="POST">
            <table>
                <tr>
                    <td>Employee Name:</td>
                    <td><input type="text" name="employeeName" value="<?php echo $employee["employee_name"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Department Name:</td>
                    <td><input type="text" name="departmentName" value="<?php echo $employee["department_name"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Date Hired:</td>
                    <td><input type="date" name="dateHired" value="<?php echo $employee["date_hired"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Employment Type:</td>
                    <td>
                        <select name="employmentType">
                            <option value="Regular" <?php if ($employee["employment_type"] === "Regular") echo "selected=\"selected\""; ?>>Regular</option>
                            <option value="Contractual" <?php if ($employee["employment_type"] === "Contractual") echo "selected=\"selected\""; ?>>Contractual</option>
                            <option value="Probationary" <?php if ($employee["employment_type"] === "Probationary") echo "selected=\"selected\""; ?>>Probationary</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Daily Rate:</td>
                    <td><input type="number" step="0.01" min="0" name="dailyRate" value="<?php echo $employee["daily_rate"]; ?>" required><br></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="employeeNumber" value="<?php echo $employeeNumber; ?>">
            <input type="submit" name="edit" value="Edit Employee">
        </form>
    <?php endif; ?>
    <br>
    <button>
        <a href="employees.html">Go Back</a>
    </button>
</body>
</html>
