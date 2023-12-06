<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: grey;
        }

        header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px;
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

        main {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: white;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
            width: 30%;
            margin-bottom: 20px;
        }

        .item:hover {
            transform: scale(1.05);
        }

        .item h2 {
            margin: 0;
            font-size: 20px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .item p {
            margin: 0;
            color: #495057;
        }

        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
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

    <main>
        <?php
        // Loop through the items and display them
        while ($row = mysqli_fetch_assoc($result)) {
            $itemID = $row['itemID'];
            $itemName = $row['itemName'];
            $shelfNumber = $row['shelfNumber'];
            $quantity = $row['itemQuantity'];
        ?>
       
            <div class="item" onclick="redirectToDetails(<?php echo $itemID; ?>)">
                <h2 class="item-name"><?php echo $itemName; ?></h2>
                <p class="shelf-number">Shelf <?php echo $shelfNumber; ?></p>
                <p class="item-quantity">Quantity: <?php echo $quantity; ?></p>
            </div>
            
        <?php
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2023 SIS</p>
    </footer>

    <script>
        function redirectToDetails(itemID) {
            window.location.href = 'itemDetails.php?itemID=' + itemID;
        }
    </script>

</body>

</html>
