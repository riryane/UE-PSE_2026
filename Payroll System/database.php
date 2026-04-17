<?php

    $username = "root";
    $server   = "localhost";
    $dbName   = "db_pse";
    $dbTable  = "employee";

    $conn = mysqli_connect($server, $username);
    mysqli_select_db($conn, $dbName);

    function generateEmployeeNumber($employeeName, $dateHired) {
        $prefix = strtoupper(substr($employeeName, 0, 3));
        $rand   = str_pad(rand(0, 99999), 5, "0", STR_PAD_LEFT);
        $date   = strtoupper(date("dMY", strtotime($dateHired)));
        return $prefix . "-" . $rand . "-" . $date;
    }

    function employeeExists($employeeNumber) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE employee_number = '$employeeNumber'");
        return mysqli_num_rows($query) >= 1;
    }

    function addEmployee($employeeName, $departmentName, $dateHired, $employmentType, $dailyRate) {
        do {
            $employeeNumber = generateEmployeeNumber($employeeName, $dateHired);
        } while (employeeExists($employeeNumber));
        global $conn;
        global $dbTable;
        $query_string = "
            INSERT INTO `{$dbTable}` (employee_number, employee_name, department_name, date_hired, employment_type, daily_rate)
            VALUES ('$employeeNumber', '$employeeName', '$departmentName', '$dateHired', '$employmentType', '$dailyRate');
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return $employeeNumber;
    }

    function getEmployees() {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}`");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    function getEmployee($employeeNumber) {
        if (!employeeExists($employeeNumber)) {
            return false;
        }
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE employee_number = '$employeeNumber'");
        return mysqli_fetch_assoc($query);
    }

    function editEmployee($employeeNumber, $employeeName, $departmentName, $dateHired, $employmentType, $dailyRate) {
        do {
            $newEmployeeNumber = generateEmployeeNumber($employeeName, $dateHired);
        } while (employeeExists($newEmployeeNumber) && $newEmployeeNumber !== $employeeNumber);
        global $conn;
        global $dbTable;
        $query_string = "
            UPDATE `{$dbTable}` SET
            employee_number = '$newEmployeeNumber',
            employee_name   = '$employeeName',
            department_name = '$departmentName',
            date_hired      = '$dateHired',
            employment_type = '$employmentType',
            daily_rate      = '$dailyRate'
            WHERE employee_number = '$employeeNumber';
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return $newEmployeeNumber;
    }

    function deleteEmployee($employeeNumber) {
        global $conn;
        global $dbTable;
        mysqli_query($conn, "DELETE FROM `{$dbTable}` WHERE employee_number = '$employeeNumber'");
    }

    function searchEmployee($column, $value) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE $column LIKE '%$value%'");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

?>
