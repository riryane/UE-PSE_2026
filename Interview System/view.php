<?php

    include("database.php");

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
    <table>
        <thead>
            <tr>
                <td><b>Application No</b></td>
                <td><b>Last Name</b></td>
                <td><b>First Name</b></td>
                <td><b>Position</b></td>
                <td><b>Department</b></td>
                <td><b>Date Applied</b></td>
                <td><b>Status</b></td>
            </tr>
        </thead>
        <tbody>
        <?php
            $applicants = getApplicants();
            foreach ($applicants as $applicant) {
                $applicationNo = $applicant["application_no"];
                $lastName      = $applicant["last_name"];
                $firstName     = $applicant["first_name"];
                $position      = $applicant["position"];
                $department    = $applicant["department"];
                $dateApplied   = $applicant["date_applied"];
                $status        = $applicant["status"];
                echo "<tr>";
                echo "<td>$applicationNo</td>";
                echo "<td>$lastName</td>";
                echo "<td>$firstName</td>";
                echo "<td>$position</td>";
                echo "<td>$department</td>";
                echo "<td>$dateApplied</td>";
                echo "<td>$status</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    <br>
    <button>
        <a href="applicants.html">Go Back</a>
    </button>
</body>
</html>
