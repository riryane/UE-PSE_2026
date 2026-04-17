<?php

    include("database.php");

    if (isset($_POST["add"])) {

        $error         = "";
        $applicationNo = "";

        $lastName    = $_POST["lastName"];
        $firstName   = $_POST["firstName"];
        $middleName  = $_POST["middleName"];
        $position    = $_POST["position"];
        $department  = $_POST["department"];
        $dateApplied = $_POST["dateApplied"];
        $contactNo   = $_POST["contactNo"];
        $email       = $_POST["email"];

        $res = addApplicant($lastName, $firstName, $middleName, $position, $department, $dateApplied, $contactNo, $email);
        if (!$res) {
            $error = "Failed to add applicant.";
        } else {
            $applicationNo = $res;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview System</title>
</head>
<body>
    <h1>INTERVIEW SCHEDULING SYSTEM | APPLICANTS MODULE</h1>
    <p><b>ADD APPLICANT</b></p>
    <?php
        if (!empty($error)) {
            echo "<b>$error</b>";
        } else {
            if (isset($applicationNo) && !empty($applicationNo)) {
                echo "<b>Successfully added applicant. Application No: $applicationNo</b>";
            }
        }
    ?>
    <form method="POST">
        <table>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="lastName" required><br></td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="firstName" required><br></td>
            </tr>
            <tr>
                <td>Middle Name:</td>
                <td><input type="text" name="middleName"><br></td>
            </tr>
            <tr>
                <td>Position:</td>
                <td><input type="text" name="position" required><br></td>
            </tr>
            <tr>
                <td>Department:</td>
                <td><input type="text" name="department" required><br></td>
            </tr>
            <tr>
                <td>Date Applied:</td>
                <td><input type="date" name="dateApplied" required><br></td>
            </tr>
            <tr>
                <td>Contact No:</td>
                <td><input type="text" name="contactNo"><br></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email"><br></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="add" value="Add Applicant">
    </form>
    <br>
    <button>
        <a href="applicants.html">Go Back</a>
    </button>
</body>
</html>
