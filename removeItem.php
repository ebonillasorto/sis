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

        legend {
            font-size: 18px;
            font-weight: bold;
            color: #343a40;
        }

        input[type="checkbox"] {
            margin-right: 5px;
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

    <h1>Remove Items</h1>

    <form action="" method="post">
        <fieldset>
            <legend>Filter Items:</legend>
            <label for="shelf-number-input">Shelf Number:</label>
            <input type="text" name="filter_shelf" id="shelf-number-input" placeholder="Enter Shelf Number"><br>

            <label for="operator-select"></label>
            <select name="operator" id="operator-select">
                <option value="equal">Equal</option>
                <option value="less">Less Than</option>
                <option value="greater">Greater Than</option>
            </select>

            <label for="quantity-input"></label>
            <input type="text" name="filter_quantity" id="quantity-input" placeholder="Enter Quantity">


            <button type="submit" name="filter_submit">Filter</button>
        </fieldset>

        <fieldset>
            <legend>Select Items to Remove:</legend>
            <?php
            include "SQLFunctions.php";

            $conn = connectDB();

            // Retrieve items from the database based on filters
            $sql = "SELECT itemID, itemName, shelfNumber FROM Shelves";

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $filter_shelf = mysqli_real_escape_string($conn, $_POST['filter_shelf']);
                $filter_quantity = mysqli_real_escape_string($conn, $_POST['filter_quantity']);
                $operator = $_POST['operator'];

                if (!empty($filter_shelf)) {
                    $sql .= " WHERE shelfNumber = '$filter_shelf'";
                }

                if (!empty($filter_quantity)) {
                    if (!empty($filter_shelf)) {
                        $sql .= " AND ";
                    } else {
                        $sql .= " WHERE ";
                    }

                    // Modify the SQL query based on the selected operator
                    if ($operator === 'equal') {
                        $sql .= "itemQuantity = '$filter_quantity'";
                    } elseif ($operator === 'less') {
                        $sql .= "itemQuantity < '$filter_quantity'";
                    } elseif ($operator === 'greater') {
                        $sql .= "itemQuantity > '$filter_quantity'";
                    }
                }
            }

            $result = mysqli_query($conn, $sql);

            // Generate checkboxes for each item
            while ($row = mysqli_fetch_assoc($result)) {
                $itemID = $row['itemID'];
                $itemName = $row['itemName'];
                $shelfNumber = $row['shelfNumber'];
                echo "<input type='checkbox' name='itemsToRemove[]' value='$itemID'> $itemName (Shelf Number: $shelfNumber)<br>";
            }

            mysqli_close($conn);
            ?>
        </fieldset>

        <br>
        <input type="submit" name="submit" value="Remove">
        <input type="reset" value="Reset">
    </form>

    <?php
    if (isset($_POST["submit"])) {
        $conn = connectDB();

        // Check if any checkboxes are selected
        if (isset($_POST['itemsToRemove'])) {
            // Loop through the selected checkboxes and remove corresponding items
            foreach ($_POST['itemsToRemove'] as $selectedItemID) {
                $sql = "DELETE FROM Shelves WHERE itemID = '$selectedItemID'";
                exeSQL($conn, $sql);
            }
        }

        mysqli_close($conn);
    }
    ?>
</body>

</html>