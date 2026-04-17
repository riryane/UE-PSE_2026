<?php

    include("database.php");

    if (isset($_POST["delete"])) {
        deleteApplicant($_POST["applicationNo"]);
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
    <form method="POST">
        Application No:
        <input type="text" name="applicationNo" required>
        <input type="submit" name="delete" value="Delete Applicant">
    </form>
    <br>
    <button>
        <a href="applicants.html">Go Back</a>
    </button>
</body>
</html>
