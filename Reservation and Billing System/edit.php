<?php

    include("database.php");

    $showSearch = true;
    $showEdit   = false;
    $item       = "";
    $error      = "";

    if (isset($_POST["search"])) {
        $itemCode = $_POST["itemCode"];
        $res      = getItem($itemCode);
        if (!$res) {
            $error      = "Item Code Does Not Exist.";
        } else {
            $showSearch = false;
            $showEdit   = true;
            $item       = $res;
        }
    }

    if (isset($_POST["edit"])) {
        $itemCode        = $_POST["itemCode"];
        $itemDescription = $_POST["itemDescription"];
        $price           = $_POST["price"];

        $res = editItem($itemCode, $itemDescription, $price);
        if (!$res) {
            $error      = "Failed to edit item.";
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
    <title>Reservation and Billing System</title>
</head>
<body>
    <h1>RESERVATION AND BILLING SYSTEM | ITEMS MODULE</h1>
    <?php if ($showSearch): ?>
        <?php if (!empty($error)) echo "<b>$error</b>"; ?>
        <form method="POST">
            Item Code:
            <input type="number" min="1" name="itemCode" required>
            <input type="submit" name="search" value="Search Item">
        </form>
    <?php endif; ?>
    <?php if ($showEdit): ?>
        <form method="POST">
            <table>
                <tr>
                    <td>Item Description:</td>
                    <td><input type="text" name="itemDescription" value="<?php echo $item["item_description"]; ?>" required><br></td>
                </tr>
                <tr>
                    <td>Price (PHP):</td>
                    <td><input type="number" step="0.01" min="0" name="price" value="<?php echo $item["price"]; ?>" required><br></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="itemCode" value="<?php echo $itemCode; ?>">
            <input type="submit" name="edit" value="Edit Item">
        </form>
    <?php endif; ?>
    <br>
    <button>
        <a href="items.html">Go Back</a>
    </button>
</body>
</html>
