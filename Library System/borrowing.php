<?php

    include("database.php");

    $borrowerName       = "";
    $bookId             = "";
    $borrowDate         = "";
    $expectedReturnDate = "";
    $actualReturnDate   = "";
    $error              = "";
    $overdueDays        = 0;
    $fineAmount         = 0;
    $fineLabel          = "";

    if (isset($_POST["calculate"])) {

        $borrowerName       = $_POST["borrowerName"];
        $bookId             = $_POST["bookId"];
        $borrowDate         = $_POST["borrowDate"];
        $expectedReturnDate = $_POST["expectedReturnDate"];
        $actualReturnDate   = $_POST["actualReturnDate"];

        if (!bookIdExists($bookId)) {
            $error = "Book ID Does Not Exist.";
        } else {
            $book        = getBook($bookId);
            $expected    = strtotime($expectedReturnDate);
            $actual      = strtotime($actualReturnDate);
            $overdueDays = ($actual - $expected) / (60 * 60 * 24);

            if ($overdueDays <= 0) {
                $fineAmount = 0;
                $fineLabel  = "Returned on time. No fine.";
            } else if ($overdueDays <= 3) {
                $fineAmount = $overdueDays * 5;
                $fineLabel  = "PHP 5.00/day for $overdueDays day(s) overdue";
            } else if ($overdueDays <= 7) {
                $fineAmount = $overdueDays * 10;
                $fineLabel  = "PHP 10.00/day for $overdueDays day(s) overdue";
            } else {
                $fineAmount = $overdueDays * 20;
                $fineLabel  = "PHP 20.00/day for $overdueDays day(s) overdue";
            }
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
    <h1>LIBRARY SYSTEM | BORROWING MODULE</h1>
    <?php if (!empty($error)): ?>
        <?= "<b>$error</b>" ?>
    <?php endif; ?>
    <form method="POST">
        <table>
            <tr>
                <td>Borrower Name:</td>
                <td><input type="text" name="borrowerName" value="<?= $borrowerName ?>" required><br></td>
            </tr>
            <tr>
                <td>Book ID:</td>
                <td><input type="text" name="bookId" value="<?= $bookId ?>" required><br></td>
            </tr>
            <tr>
                <td>Borrow Date:</td>
                <td><input type="date" name="borrowDate" value="<?= $borrowDate ?>" required><br></td>
            </tr>
            <tr>
                <td>Expected Return Date:</td>
                <td><input type="date" name="expectedReturnDate" value="<?= $expectedReturnDate ?>" required><br></td>
            </tr>
            <tr>
                <td>Actual Return Date:</td>
                <td><input type="date" name="actualReturnDate" value="<?= $actualReturnDate ?>" required><br></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="calculate" value="Calculate">
    </form>
    <?php if (empty($error) && isset($_POST["calculate"])): ?>
        <br>
        <b>Borrowing Summary for: <?= $borrowerName ?></b><br>
        Book ID: <b><?= $bookId ?></b><br>
        Book Title: <b><?= $book["title"] ?></b><br>
        Author: <b><?= $book["author"] ?></b><br>
        Borrow Date: <b><?= $borrowDate ?></b><br>
        Expected Return Date: <b><?= $expectedReturnDate ?></b><br>
        Actual Return Date: <b><?= $actualReturnDate ?></b><br>
        Days Overdue: <b><?= max(0, $overdueDays) ?></b><br>
        Fine Computation: <b><?= $fineLabel ?></b><br>
        Fine Amount: <b>PHP <?= number_format($fineAmount, 2) ?></b><br>
    <?php endif; ?>
    <br>
    <button>
        <a href="index.html">Go Back</a>
    </button>
</body>
</html>
