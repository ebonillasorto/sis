<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
</head>
<body>
    <h1>Add an Item</h1>
    <form action="" method="post">
        <fieldset>
            <table>
            <tr>
                <th>Item Name</th>
                <td><input type="text" name="itemName" required></td>
            </tr>

            <tr>
                <th>Quantity</th>
                <td><input type="text" name="itemQuantity" required></td>
            </tr>

            <tr>
                <th>Shelf Number</th>
                <td><input type="text" name="shelfNumber" required></td>
            </tr>

            </table>
        </fieldset>

        <br>
        <input type="submit" name= "submit" value="Submit">
        <input type="reset" value="Reset">
    </form>
</body>
</html>




<?php
    include "SQLFunctions.php";

    if (isset ($_POST["submit"])){
        $conn = connectDB();
        $sql = "INSERT INTO Shelves (shelfNumber, itemName, itemQuantity)
            VALUES ('".$_POST["shelfNumber"]."', '".$_POST["itemName"]."', '".$_POST["itemQuantity"]."');";
        exeSQL($conn, $sql);
    }


?>