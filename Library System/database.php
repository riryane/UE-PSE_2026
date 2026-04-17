<?php

    $username = "root";
    $server   = "localhost";
    $dbName   = "db_pse";
    $dbTable  = "books";

    $conn = mysqli_connect($server, $username);
    mysqli_select_db($conn, $dbName);

    function generateBookId($author, $title) {
        $words        = explode(" ", trim($author));
        $surname      = end($words);
        $authorPrefix = strtoupper(substr($surname, 0, 3));
        $titlePrefix  = strtoupper(substr(trim($title), 0, 3));
        $randomNum    = str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);
        return $authorPrefix . "-" . $titlePrefix . "-" . $randomNum;
    }

    function bookIdExists($bookId) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE book_id = '$bookId'");
        return mysqli_num_rows($query) >= 1;
    }

    function addBook($title, $author, $genre, $copies) {
        do {
            $bookId = generateBookId($author, $title);
        } while (bookIdExists($bookId));
        global $conn;
        global $dbTable;
        $query_string = "
            INSERT INTO `{$dbTable}` (book_id, title, author, genre, copies)
            VALUES ('$bookId', '$title', '$author', '$genre', '$copies');
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return $bookId;
    }

    function getBooks() {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}`");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    function getBook($bookId) {
        if (!bookIdExists($bookId)) {
            return false;
        }
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE book_id = '$bookId'");
        return mysqli_fetch_assoc($query);
    }

    function editBook($bookId, $title, $author, $genre, $copies) {
        global $conn;
        global $dbTable;
        $query_string = "
            UPDATE `{$dbTable}` SET
            title   = '$title',
            author  = '$author',
            genre   = '$genre',
            copies  = '$copies'
            WHERE book_id = '$bookId';
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return $bookId;
    }

    function deleteBook($bookId) {
        global $conn;
        global $dbTable;
        mysqli_query($conn, "DELETE FROM `{$dbTable}` WHERE book_id = '$bookId'");
    }

    function searchBook($column, $value) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE $column LIKE '%$value%'");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

?>
