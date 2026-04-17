<?php

    include("database.php");

    $showSearch = true;
    $showEdit   = false;
    $applicant  = "";
    $error      = "";

    if (isset($_POST["search"])) {
        $applicationNo = $_POST["applicationNo"];
        $res           = getApplicant($applicationNo);
        if (!$res) {
            $error      = "Application Number Does Not Exist.";
        } else {
            $showSearch = false;
            $showEdit   = true;
            $applicant  = $res;
        }
    }

    if (isset($_POST["edit"])) {
        $applicationNo = $_POST["applicationNo"];
        $lastName      = $_POST["lastName"];
        $firstName     = $_POST["firstName"];
        $middleName    = $_POST["middleName"];
        $position      = $_POST["position"];
        $department    = $_POST["department"];
        $dateApplied   = $_POST["dateApplied"];
        $contactNo     = $_POST["contactNo"];
        $email         = $_POST["email"];

        $res = editApplicant($applicationNo, $lastName, $firstName, $middleName, $position, $department, $dateApplied, $contactNo, $email);
        if (!$res) {
            $error      = "Failed to edit applicant.";
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
    <title>Interview System</title>
</head>
<body>
    <h1>INTERVIEW SCHEDULING SYSTEM | APPLICANTS MODULE</h1>
    <?php if ($showSearch): ?>
        <?php if (!empty($error)) echo "<b>$error</b>"; ?>
        <form method="POST">
            Application No:
            <input type="text" name="applicationNo" required>
            <input type="submit" name="search" value="Search Applicant">
        </form>
    <?php endif; ?>
    <?php if ($showEdit): ?>
        <form method="POST">
            <table>
                <tr>
                    <td>Last Name:</td>
                    <td><input type="text" name="lastName" value="<?php echo $applicant["last_name"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>First Name:</td>
                    <td><input type="text" name="firstName" value="<?php echo $applicant["first_name"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Middle Name:</td>
                    <td><input type="text" name="middleName" value="<?php echo $applicant["middle_name"]; ?>"><br></td>
                </tr>
                <tr>
                    <td>Position:</td>
                    <td><input type="text" name="position" value="<?php echo $applicant["position"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Department:</td>
                    <td><input type="text" name="department" value="<?php echo $applicant["department"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Date Applied:</td>
                    <td><input type="date" name="dateApplied" value="<?php echo $applicant["date_applied"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Contact No:</td>
                    <td><input type="text" name="contactNo" value="<?php echo $applicant["contact_no"]; ?>"><br></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" value="<?php echo $applicant["email"]; ?>"><br></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="applicationNo" value="<?php echo $applicationNo; ?>">
            <input type="submit" name="edit" value="Edit Applicant">
        </form>
    <?php endif; ?>
    <br>
    <button>
        <a href="applicants.html">Go Back</a>
    </button>
</body>
</html>
