<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: grey;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px;
        }

        #logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav {
            display: inline-block;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 15px;
        }

        a {
            color: white;
            text-decoration: none;
        }

        h1 {
            margin-top: 20px;
            text-align: center;
            color: black;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        fieldset {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"],
        input[type="reset"] {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <div id="logo">SIS</div>
        <nav>
            <ul>
                <li><a href="storage.php">Home</a></li>
                <li><a href="index.html" id="login-btn">Logout</a></li>
            </ul>
        </nav>
    </header>

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
        <input type="submit" name="submit" value="Submit">
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
