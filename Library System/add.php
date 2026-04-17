<?php

    include("database.php");

    if (isset($_POST["add"])) {

        $error  = "";
        $bookId = "";

        $title  = $_POST["title"];
        $author = $_POST["author"];
        $genre  = $_POST["genre"];
        $copies = $_POST["copies"];

        $res = addBook($title, $author, $genre, $copies);
        if (!$res) {
            $error = "Failed to add book.";
        } else {
            $bookId = $res;
        }
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
    <p><b>ADD BOOK</b></p>
    <?php
        if (!empty($error)) {
            echo "<b>$error</b>";
        } else {
            if (isset($bookId) && !empty($bookId)) {
                echo "<b>Successfully added book. Book ID: $bookId</b>";
            }
        }
    ?>
    <form method="POST">
        <table>
            <tr>
                <td>Title:</td>
                <td><input type="text" name="title" required><br></td>
            </tr>
            <tr>
                <td>Author:</td>
                <td><input type="text" name="author" required><br></td>
            </tr>
            <tr>
                <td>Genre:</td>
                <td><input type="text" name="genre" required><br></td>
            </tr>
            <tr>
                <td>Number of Copies:</td>
                <td><input type="number" min="1" name="copies" required><br></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="add" value="Add Book">
    </form>
    <br>
    <button>
        <a href="books.html">Go Back</a>
    </button>
</body>
</html>
