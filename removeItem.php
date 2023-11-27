<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Item</title>
    <style>
        body {
            background-color: green;
        }
    </style>
</head>
<body>
    <h1>Remove an Item</h1>
    <form action="" method="post">
        <fieldset>
            <legend>Select Item to Remove</legend>
            <?php
                include "SQLFunctions.php";
                $conn = connectDB();

                // Fetch all current items from the database
                $sql = "SELECT itemName FROM Shelves";
                $result = mysqli_query($conn, $sql);

                // Create a radio button for each item
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<input type="radio" name="itemNameToRemove" value="' . $row["itemName"] . '"> ' . $row["itemName"] . '<br>';
                }

                // Close the database connection
                mysqli_close($conn);
            ?>
        </fieldset>

        <br>
        <input type="submit" name="submit" value="Remove">
        <input type="reset" value="Reset">
    </form>
</body>
</html>

<?php
if (isset($_POST["submit"])) {
    include "SQLFunctions.php";
    $conn = connectDB();
    $itemNameToRemove = $_POST["itemNameToRemove"];

    $sql = "DELETE FROM Shelves WHERE itemName = '$itemNameToRemove';";
    exeSQL($conn, $sql);

    // Close the database connection
    mysqli_close($conn);
}
?>
