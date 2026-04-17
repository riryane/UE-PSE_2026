<?php

    $username         = "root";
    $server           = "localhost";
    $dbName           = "db_pse";
    $dbTable          = "applicants";
    $dbTableInterview = "interviews";

    $conn = mysqli_connect($server, $username);
    mysqli_select_db($conn, $dbName);

    function generateApplicationNo($lastName, $position, $dateApplied) {
        $seq    = rand(1000, 9999);
        $prefix = strtoupper(substr($lastName, 0, 3));
        $pos    = strtoupper(substr($position, 0, 3));
        $date   = strtoupper(date("dMY", strtotime($dateApplied)));
        return $prefix . "-" . $pos . $seq . "-" . $date;
    }

    function applicationNoExists($applicationNo) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE application_no = '$applicationNo'");
        return mysqli_num_rows($query) >= 1;
    }

    function addApplicant($lastName, $firstName, $middleName, $position, $department, $dateApplied, $contactNo, $email) {
        do {
            $applicationNo = generateApplicationNo($lastName, $position, $dateApplied);
        } while (applicationNoExists($applicationNo));
        global $conn;
        global $dbTable;
        $query_string = "
            INSERT INTO `{$dbTable}` (application_no, last_name, first_name, middle_name, position, department, date_applied, contact_no, email, status)
            VALUES ('$applicationNo', '$lastName', '$firstName', '$middleName', '$position', '$department', '$dateApplied', '$contactNo', '$email', 'Pending');
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return $applicationNo;
    }

    function getApplicants() {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}`");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    function getApplicant($applicationNo) {
        if (!applicationNoExists($applicationNo)) {
            return false;
        }
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE application_no = '$applicationNo'");
        return mysqli_fetch_assoc($query);
    }

    function editApplicant($applicationNo, $lastName, $firstName, $middleName, $position, $department, $dateApplied, $contactNo, $email) {
        global $conn;
        global $dbTable;
        $query_string = "
            UPDATE `{$dbTable}` SET
            last_name   = '$lastName',
            first_name  = '$firstName',
            middle_name = '$middleName',
            position    = '$position',
            department  = '$department',
            date_applied = '$dateApplied',
            contact_no  = '$contactNo',
            email       = '$email'
            WHERE application_no = '$applicationNo';
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return $applicationNo;
    }

    function deleteApplicant($applicationNo) {
        global $conn;
        global $dbTable;
        global $dbTableInterview;
        mysqli_query($conn, "DELETE FROM `{$dbTableInterview}` WHERE application_no = '$applicationNo'");
        mysqli_query($conn, "DELETE FROM `{$dbTable}` WHERE application_no = '$applicationNo'");
    }

    function searchApplicant($column, $value) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE $column LIKE '%$value%'");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    function addInterview($applicationNo, $interviewDateTime, $interviewType, $interviewerName, $round, $result, $remarks, $bgCheck, $docsVerified) {
        global $conn;
        global $dbTable;
        global $dbTableInterview;

        $newStatus = "Pending";
        if ($result === "Fail") {
            $newStatus = "Rejected";
        } else if ($result === "Pass") {
            if ($round === "Initial")   $newStatus = "For Technical Interview";
            if ($round === "Technical") $newStatus = "For Final Interview";
            if ($round === "Final")     $newStatus = "Hired";
        }

        $query_string = "
            INSERT INTO `{$dbTableInterview}` (application_no, interview_date_time, interview_type, interviewer_name, round, result, remarks, bg_check, docs_verified)
            VALUES ('$applicationNo', '$interviewDateTime', '$interviewType', '$interviewerName', '$round', '$result', '$remarks', '$bgCheck', '$docsVerified');
        ";
        try {
            mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }

        mysqli_query($conn, "UPDATE `{$dbTable}` SET status = '$newStatus' WHERE application_no = '$applicationNo'");
    }

    function getInterviews($applicationNo) {
        global $conn;
        global $dbTableInterview;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTableInterview}` WHERE application_no = '$applicationNo' ORDER BY id DESC");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

?>
