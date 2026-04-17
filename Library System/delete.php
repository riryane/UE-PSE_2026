<?php

    include("database.php");

    if (isset($_POST["delete"])) {
        deleteBook($_POST["bookId"]);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
</head>
<body>
    <h1>LIBRARY SYSTEM | BOOKS MODULE</h1>
    <form method="POST">
        Book ID:
        <input type="text" name="bookId" required>
        <input type="submit" name="delete" value="Delete Book">
    </form>
    <br>
    <button>
        <a href="books.html">Go Back</a>
    </button>
</body>
</html>
