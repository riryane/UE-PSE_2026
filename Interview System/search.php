<?php

    include("database.php");

    $applicants      = "";
    $showFilter      = true;
    $showValue       = false;
    $filter          = "";
    $validatedFields = ["date_applied"];
    $needsValidation = false;

    if (isset($_POST["search"])) {
        $column     = $_POST["filter"];
        $value      = $_POST["value"];
        $showFilter = true;
        $showValue  = false;
        $applicants = searchApplicant($column, $value);
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
    <title>Interview System</title>
</head>
<body>
    <h1>INTERVIEW SCHEDULING SYSTEM | APPLICANTS MODULE</h1>
    <?php if ($showFilter): ?>
    <form method="POST">
        Filter:
        <select name="column">
            <option value="application_no">Application No</option>
            <option value="last_name">Last Name</option>
            <option value="first_name">First Name</option>
            <option value="position">Position</option>
            <option value="department">Department</option>
            <option value="date_applied">Date Applied</option>
            <option value="status">Status</option>
        </select>
        <input type="submit" name="filter" value="Next">
    </form>
    <?php endif; ?>
    <?php if ($showValue): ?>
    <form method="POST">
        Value:
        <?php if ($needsValidation): ?>
            <?php if ($filter === "date_applied"): ?>
                <input type="date" name="value" required>
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
    <?php endif; ?>
    <br>
    <button>
        <a href="applicants.html">Go Back</a>
    </button>
</body>
</html>
