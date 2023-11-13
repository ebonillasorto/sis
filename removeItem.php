<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Item</title>
</head>
<body>
    <h1>Remove an Item</h1>
    <form action="" method="post">
        <fieldset>
            <table>
                <tr>
                    <th>Item Name</th>
                    <td><input type="text" name="itemNameToRemove" required></td>
                </tr>
            </table>
        </fieldset>

        <br>
        <input type="submit" name="submit" value="Remove">
        <input type="reset" value="Reset">
    </form>
</body>
</html>


<?php
include "SQLFunctions.php";

if (isset($_POST["submit"])) {
    $conn = connectDB();
    $itemNameToRemove = $_POST["itemNameToRemove"];

    
    $sql = "DELETE FROM Shelves WHERE itemName = '$itemNameToRemove';";
    exeSQL($conn, $sql);
}
?>