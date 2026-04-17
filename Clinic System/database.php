<?php

    $username = "root";
    $server   = "localhost";
    $dbName   = "db_pse";
    $dbTable  = "drugs";

    $conn = mysqli_connect($server, $username);
    mysqli_select_db($conn, $dbName);

    function generateDrugId($drugDescription, $batchDate, $expirationDate) {
        $words    = explode(" ", trim($drugDescription));
        $initials = "";
        if (count($words) >= 2) {
            $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            $initials = strtoupper(substr($words[0], 0, 2));
            if (strlen($initials) < 2) {
                $initials .= "X";
            }
        }
        $batchFormatted  = date("mdY", strtotime($batchDate));
        $expiryFormatted = date("mdY", strtotime($expirationDate));
        $randomNum       = str_pad(rand(0, 99999), 5, "0", STR_PAD_LEFT);
        return $initials . "-" . $batchFormatted . "-" . $expiryFormatted . "-" . $randomNum;
    }

    function drugIdExists($drugId) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE drug_id = '$drugId'");
        return mysqli_num_rows($query) >= 1;
    }

    function addDrug($drugDescription, $dosage, $batchDate, $expirationDate, $price) {
        do {
            $drugId = generateDrugId($drugDescription, $batchDate, $expirationDate);
        } while (drugIdExists($drugId));
        global $conn;
        global $dbTable;
        $query_string = "
            INSERT INTO `{$dbTable}` (drug_id, drug_description, dosage, batch_date, expiration_date, price)
            VALUES ('$drugId', '$drugDescription', '$dosage', '$batchDate', '$expirationDate', '$price');
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return $drugId;
    }

    function getDrugs() {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}`");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

    function getDrug($drugId) {
        if (!drugIdExists($drugId)) {
            return false;
        }
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE drug_id = '$drugId'");
        return mysqli_fetch_assoc($query);
    }

    function editDrug($drugId, $drugDescription, $dosage, $batchDate, $expirationDate, $price) {
        global $conn;
        global $dbTable;
        $query_string = "
            UPDATE `{$dbTable}` SET
            drug_description = '$drugDescription',
            dosage           = '$dosage',
            batch_date       = '$batchDate',
            expiration_date  = '$expirationDate',
            price            = '$price'
            WHERE drug_id = '$drugId';
        ";
        try {
            $query = mysqli_query($conn, $query_string);
        } catch (mysqli_sql_exception $e) {
            die($e);
        }
        return $drugId;
    }

    function deleteDrug($drugId) {
        global $conn;
        global $dbTable;
        mysqli_query($conn, "DELETE FROM `{$dbTable}` WHERE drug_id = '$drugId'");
    }

    function searchDrug($column, $value) {
        global $conn;
        global $dbTable;
        $query = mysqli_query($conn, "SELECT * FROM `{$dbTable}` WHERE $column LIKE '%$value%'");
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }

?>
