<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Move Item</title>
</head>
<body>
    <h1>Move an Item</h1>
    <form action="" method="post">
        <fieldset>
            <table>
                <tr>
                    <th>Item Name</th>
                    <td><input type="text" name="MovedItem" required></td>
                </tr>
                <tr>
                    <th>Shelf Number</th>
                    <td><input type="text" name="ShelfNumber" required></td>
                </tr>
            </table>
        </fieldset>

        <br>
        <input type="submit" name="submit" value="Move">
        <input type="reset" value="Reset">
    </form>
</body>
</html>


<?php
include "SQLFunctions.php";

if (isset($_POST["submit"])) {
    $conn = connectDB();
    $itemNameToRemove = $_POST["MovedItem"];
    $shelfNumber = $_POST["ShelfNumber"];

    
    $sql = "UPDATE Shelves SET shelfNumber = '$shelfNumber' WHERE itemName = '$itemNameToRemove';";
    exeSQL($conn, $sql);
}
?>