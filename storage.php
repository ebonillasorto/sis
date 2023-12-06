<?php
include "SQLFunctions.php";

$conn = connectDB();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search'])) {
    // Sanitize the input to prevent SQL injection
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);

    // Modify the SQL query to include the search term
    $sql = "SELECT itemID, itemName, shelfNumber, itemQuantity FROM Shelves WHERE itemName LIKE '%$searchTerm%'";
} else {
    // Default query without search term
    $sql = "SELECT itemID, itemName, shelfNumber, itemQuantity FROM Shelves";
}

// Filter based on user input
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['filter'])) {
    $filter = $_GET['filter'];

    // Modify the SQL query based on the selected filter type
    if ($filter === 'combined') {
        $sql .= " WHERE 1"; // Placeholder for WHERE clause

        // Handle shelfNumber filter
        if (isset($_GET['value_shelf']) && $_GET['value_shelf'] !== '') {
            $value_shelf = mysqli_real_escape_string($conn, $_GET['value_shelf']);
            $sql .= " AND shelfNumber = '$value_shelf'";
        }

        // Handle itemQuantity filter
        if (isset($_GET['value_quantity']) && isset($_GET['operator']) && $_GET['value_quantity'] !== '') {
            $value_quantity = mysqli_real_escape_string($conn, $_GET['value_quantity']);
            $operator = $_GET['operator'];

            // Modify the SQL query based on the selected operator
            if ($operator === 'equal') {
                $sql .= " AND itemQuantity = '$value_quantity'";
            } elseif ($operator === 'less') {
                $sql .= " AND itemQuantity < '$value_quantity'";
            } elseif ($operator === 'greater') {
                $sql .= " AND itemQuantity > '$value_quantity'";
            }
        }
    }
}

$result = mysqli_query($conn, $sql);

// Error handling
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
      <style>
        body {
            background-color: gray;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
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
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr.item-row:nth-child(even) {
            background-color: white; /* White background color for even rows with class item-row */
        }

        tr.item-row:nth-child(odd) {
            background-color: #e6f7ff; /* Light blue background color for odd rows with class item-row */
        }

        .button-container {
            margin-top: 20px;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 10px;
            margin-right: 10px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
        }

        #search-container {
            margin-top: 20px;
            text-align: center;
        }

        #search-input {
            padding: 8px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        #search-button {
            padding: 8px;
            background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff;
            border-radius: 5px;
            cursor: pointer;
        }

        .context-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .context-menu a {
            display: block;
            padding: 8px;
            text-decoration: none;
            color: #333;
        }

        .item-row td {
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

    <h1>Inventory</h1>

    <div id="search-container">
    <form action="storage.php" method="post">
        <input type="text" name="search" id="search-input" placeholder="Search...">
        <button type="submit" id="search-button">Search</button>
    </form>
    </div>

    <div id="filter-container">
        <form action="storage.php" method="get">
            <label for="shelf-number-input">Shelf Number:</label>
            <input type="text" name="value_shelf" id="shelf-number-input" placeholder="Enter Shelf Number"><br>

            <label for="operator-select"></label>
            <select name="operator" id="operator-select">
                <option value="equal">Equal</option>
                <option value="less">Less Than</option>
                <option value="greater">Greater Than</option>
            </select>
            
            <label for="quantity-input"></label>
            <input type="text" name="value_quantity" id="quantity-input" placeholder="Enter Quantity">


            <button type="submit" name="filter" value="combined" class="filter-button">Filter</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Shelf Number</th>
                <th>Item Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display items, shelf number, and item quantity in horizontal columns
            while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr class='item-row' data-item-id='{$row['itemID']}'>";
    echo "<td>{$row['itemName']}</td>";
    echo "<td>{$row['shelfNumber']}</td>";
    echo "<td>{$row['itemQuantity']}</td>";
    echo "</tr>";
}
            ?>
        </tbody>
    </table>
    
    <!-- Context menu for edit option -->
    <div class="context-menu" id="context-menu">
        <a href="#" id="edit-option">Edit</a>
    </div>

    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const itemRows = document.querySelectorAll('.item-row');

        itemRows.forEach(function (itemRow) {
            itemRow.addEventListener('click', function () {
                // Retrieve the itemID from the data-item-id attribute
                const itemId = itemRow.getAttribute('data-item-id');

                // Redirect to the edit page for the selected item
                window.location.href = 'editItem.php?itemID=' + itemId;
            });
        });
    });
</script>

    <div class="button-container">
        <a href="http://simpleinventorysystem.infinityfreeapp.com/addItem.php?i=1" class="button">Add Item</a>
        <a href="http://simpleinventorysystem.infinityfreeapp.com/removeItem.php?i=1" class="button">Remove Item</a>
    </div>
</body>
</html>
