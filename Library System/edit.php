<?php

    include("database.php");

    $showSearch = true;
    $showEdit   = false;
    $book       = "";
    $error      = "";

    if (isset($_POST["search"])) {
        $bookId = $_POST["bookId"];
        $res    = getBook($bookId);
        if (!$res) {
            $error      = "Book ID Does Not Exist.";
        } else {
            $showSearch = false;
            $showEdit   = true;
            $book       = $res;
        }
    }

    if (isset($_POST["edit"])) {
        $bookId = $_POST["bookId"];
        $title  = $_POST["title"];
        $author = $_POST["author"];
        $genre  = $_POST["genre"];
        $copies = $_POST["copies"];

        $res = editBook($bookId, $title, $author, $genre, $copies);
        if (!$res) {
            $error      = "Failed to edit book.";
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
    <title>Library System</title>
</head>
<body>
    <h1>LIBRARY SYSTEM | BOOKS MODULE</h1>
    <?php if ($showSearch): ?>
        <?php if (!empty($error)) echo "<b>$error</b>"; ?>
        <form method="POST">
            Book ID:
            <input type="text" name="bookId" required>
            <input type="submit" name="search" value="Search Book">
        </form>
    <?php endif; ?>
    <?php if ($showEdit): ?>
        <form method="POST">
            <table>
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $book["title"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Author:</td>
                    <td><input type="text" name="author" value="<?php echo $book["author"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Genre:</td>
                    <td><input type="text" name="genre" value="<?php echo $book["genre"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Number of Copies:</td>
                    <td><input type="number" min="1" name="copies" value="<?php echo $book["copies"]; ?>" required><br></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="bookId" value="<?php echo $bookId; ?>">
            <input type="submit" name="edit" value="Edit Book">
        </form>
    <?php endif; ?>
    <br>
    <button>
        <a href="books.html">Go Back</a>
    </button>
</body>
</html>
