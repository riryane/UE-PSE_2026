<?php

    include("database.php");

    $items           = "";
    $showFilter      = true;
    $showValue       = false;
    $filter          = "";
    $validatedFields = ["copies"];
    $needsValidation = false;

    if (isset($_POST["search"])) {
        $column     = $_POST["filter"];
        $value      = $_POST["value"];
        $showFilter = true;
        $showValue  = false;
        $books      = searchBook($column, $value);
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
    <title>Library System</title>
</head>
<body>
    <h1>LIBRARY SYSTEM | BOOKS MODULE</h1>
    <?php if ($showFilter): ?>
    <form method="POST">
        Filter:
        <select name="column">
            <option value="book_id">Book ID</option>
            <option value="title">Title</option>
            <option value="author">Author</option>
            <option value="genre">Genre</option>
            <option value="copies">Number of Copies</option>
        </select>
        <input type="submit" name="filter" value="Next">
    </form>
    <?php endif; ?>
    <?php if ($showValue): ?>
    <form method="POST">
        Value:
        <?php if ($needsValidation): ?>
            <?php if ($filter === "copies"): ?>
                <input type="number" min="1" name="value" required>
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
    <?php endif; ?>
    <br>
    <button>
        <a href="books.html">Go Back</a>
    </button>
</body>
</html>
