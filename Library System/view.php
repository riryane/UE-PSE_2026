<?php

    include("database.php");

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
    <table>
        <thead>
            <tr>
                <td><b>ID</b></td>
                <td><b>Book ID</b></td>
                <td><b>Title</b></td>
                <td><b>Author</b></td>
                <td><b>Genre</b></td>
                <td><b>Copies</b></td>
            </tr>
        </thead>
        <tbody>
        <?php
            $books = getBooks();
            foreach ($books as $book) {
                $id     = $book["id"];
                $bookId = $book["book_id"];
                $title  = $book["title"];
                $author = $book["author"];
                $genre  = $book["genre"];
                $copies = $book["copies"];
                echo "<tr>";
                echo "<td>$id</td>";
                echo "<td>$bookId</td>";
                echo "<td>$title</td>";
                echo "<td>$author</td>";
                echo "<td>$genre</td>";
                echo "<td>$copies</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    <br>
    <button>
        <a href="books.html">Go Back</a>
    </button>
</body>
</html>
