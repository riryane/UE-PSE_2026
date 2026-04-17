<?php

    include("database.php");

    $showSearch      = true;
    $showTransaction = false;
    $applicant       = "";
    $error           = "";

    if (isset($_POST["search"])) {
        $applicationNo = $_POST["applicationNo"];
        $res           = getApplicant($applicationNo);
        if (!$res) {
            $error           = "Application Number Does Not Exist.";
        } else {
            $showSearch      = false;
            $showTransaction = true;
            $applicant       = $res;
        }
    }

    if (isset($_POST["processInterview"])) {
        $applicationNo     = $_POST["applicationNo"];
        $interviewDateTime = $_POST["interviewDateTime"];
        $interviewType     = $_POST["interviewType"];
        $interviewerName   = $_POST["interviewerName"];
        $round             = $_POST["round"];
        $result            = $_POST["result"];
        $remarks           = $_POST["remarks"];
        $bgCheck           = isset($_POST["bgCheck"])      ? "Completed" : "Pending";
        $docsVerified      = isset($_POST["docsVerified"]) ? "Yes"       : "No";

        if (empty($round) || empty($result)) {
            $error = "Please select the required radio buttons.";
        } else {
            addInterview($applicationNo, $interviewDateTime, $interviewType, $interviewerName, $round, $result, $remarks, $bgCheck, $docsVerified);
        }

        $applicant       = getApplicant($applicationNo);
        $showSearch      = false;
        $showTransaction = true;
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
    <h1>INTERVIEW SCHEDULING SYSTEM | PROCESS INTERVIEW</h1>
    <?php if (!empty($error)) echo "<b>$error</b>"; ?>
    <?php if ($showSearch): ?>
        <form method="POST">
            Application No:
            <input type="text" name="applicationNo" required>
            <input type="submit" name="search" value="Search Applicant">
        </form>
    <?php endif; ?>
    <?php if ($showTransaction): ?>
        <p>
            Applicant: <b><?= $applicant["last_name"] . ", " . $applicant["first_name"] ?></b><br>
            Application No: <b><?= $applicant["application_no"] ?></b><br>
            Position: <b><?= $applicant["position"] ?></b><br>
            Current Status: <b><?= $applicant["status"] ?></b>
        </p>
        <form method="POST">
            <table>
                <tr>
                    <td>Interview Round:</td>
                    <td>
                        <input type="radio" name="round" value="Initial"> Initial
                        <input type="radio" name="round" value="Technical"> Technical
                        <input type="radio" name="round" value="Final"> Final
                    </td>
                </tr>
                <tr>
                    <td>Pre-Interview Checklist:</td>
                    <td>
                        <input type="checkbox" name="bgCheck" value="1"> Background Check Cleared<br>
                        <input type="checkbox" name="docsVerified" value="1"> Requirements Submitted
                    </td>
                </tr>
                <tr>
                    <td>Result:</td>
                    <td>
                        <input type="radio" name="result" value="Pass"> Pass
                        <input type="radio" name="result" value="Fail"> Fail
                    </td>
                </tr>
                <tr>
                    <td>Interview Type:</td>
                    <td>
                        <select name="interviewType">
                            <option value="Phone Screening">Phone Screening</option>
                            <option value="Online/Video">Online/Video</option>
                            <option value="Face-to-Face">Face-to-Face</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Date and Time:</td>
                    <td><input type="datetime-local" name="interviewDateTime"><br></td>
                </tr>
                <tr>
                    <td>Interviewer:</td>
                    <td><input type="text" name="interviewerName"><br></td>
                </tr>
                <tr>
                    <td>Remarks:</td>
                    <td><textarea name="remarks"></textarea><br></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="applicationNo" value="<?= $applicant["application_no"] ?>">
            <input type="submit" name="processInterview" value="Save Interview Result">
        </form>
        <br>
        <b>Interview History</b>
        <table>
            <thead>
                <tr>
                    <td><b>Date and Time</b></td>
                    <td><b>Type</b></td>
                    <td><b>Interviewer</b></td>
                    <td><b>Round</b></td>
                    <td><b>Result</b></td>
                    <td><b>BG Check</b></td>
                    <td><b>Docs Verified</b></td>
                    <td><b>Remarks</b></td>
                </tr>
            </thead>
            <tbody>
            <?php
                $interviews = getInterviews($applicant["application_no"]);
                if (!empty($interviews)) {
                    foreach ($interviews as $interview) {
                        $interviewDateTime = $interview["interview_date_time"];
                        $interviewType     = $interview["interview_type"];
                        $interviewerName   = $interview["interviewer_name"];
                        $round             = $interview["round"];
                        $result            = $interview["result"];
                        $bgCheck           = $interview["bg_check"];
                        $docsVerified      = $interview["docs_verified"];
                        $remarks           = $interview["remarks"];
                        echo "<tr>";
                        echo "<td>$interviewDateTime</td>";
                        echo "<td>$interviewType</td>";
                        echo "<td>$interviewerName</td>";
                        echo "<td>$round</td>";
                        echo "<td>$result</td>";
                        echo "<td>$bgCheck</td>";
                        echo "<td>$docsVerified</td>";
                        echo "<td>$remarks</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No interview history found.</td></tr>";
                }
            ?>
            </tbody>
        </table>
    <?php endif; ?>
    <br>
    <button>
        <a href="index.html">Go Back</a>
    </button>
</body>
</html>
