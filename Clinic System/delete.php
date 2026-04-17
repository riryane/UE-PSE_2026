<?php

    include("database.php");

    if (isset($_POST["delete"])) {
        deleteDrug($_POST["drugId"]);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic System</title>
</head>
<body>
    <h1>CLINIC SYSTEM | PRESCRIPTION DRUGS MODULE</h1>
    <form method="POST">
        Drug ID:
        <input type="text" name="drugId" required>
        <input type="submit" name="delete" value="Delete Drug">
    </form>
    <br>
    <button>
        <a href="drugs.html">Go Back</a>
    </button>
</body>
</html>
