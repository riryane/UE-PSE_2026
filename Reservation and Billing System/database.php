<?php

    $username = "root";
    $server   = "localhost";
    $dbName   = "db_pse";
    $dbTable  = "items";

    $conn = mysqli_connect($server, $username);
    mysqli_select_db($conn, $dbName);

    function itemExists($itemCode) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE id = '$itemCode'");
        return mysqli_num_rows($query) >= 1;
    }

    function addItem($itemDescription, $price) {
        global $conn;
        global $dbTable;
        $query_string = "
            INSERT INTO `{$dbTable}` (item_description, price)
            VALUES ('$itemDescription', '$price');
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return mysqli_insert_id($conn);
    }

    function getItems() {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}`");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    function getItem($itemCode) {
        if (!itemExists($itemCode)) {
            return false;
        }
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE id = '$itemCode'");
        return mysqli_fetch_assoc($query);
    }

    function editItem($itemCode, $itemDescription, $price) {
        global $conn;
        global $dbTable;
        $query_string = "
            UPDATE `{$dbTable}` SET
            item_description = '$itemDescription',
            price            = '$price'
            WHERE id = '$itemCode';
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return $itemCode;
    }

    function deleteItem($itemCode) {
        global $conn;
        global $dbTable;
        mysqli_query($conn, "DELETE FROM `{$dbTable}` WHERE id = '$itemCode'");
    }

    function searchItem($column, $value) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE $column LIKE '%$value%'");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

?>
