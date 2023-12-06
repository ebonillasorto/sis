<?php
include "SQLFunctions.php";
$conn = connectDB();

// Retrieve item details based on itemID from the URL
$itemID = $_GET['itemID'];

// Check if the form is submitted for updating
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newItemName = $_POST['itemName'];
    $newShelfNumber = $_POST['shelfNumber'];
    $newQuantity = $_POST['quantity'];

    // Update the item in the database
    $updateSql = "UPDATE Shelves SET itemName = '$newItemName', shelfNumber = $newShelfNumber, itemQuantity = $newQuantity WHERE itemID = $itemID";
    mysqli_query($conn, $updateSql);
}

// Retrieve updated item details
$sql = "SELECT itemName, shelfNumber, itemQuantity FROM Shelves WHERE itemID = $itemID";
$result = mysqli_query($conn, $sql);

// Start the HTML content
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="styles.css">
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            margin: auto; /* Center the table */
        }

        th,
        td {
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
<h1>Product Page</h1>
<main>
  <div class="item-details">
    <?php
    // Display item details
    if ($row = mysqli_fetch_assoc($result)) {
      $itemName = $row['itemName'];
      $shelfNumber = $row['shelfNumber'];
      $quantity = $row['itemQuantity'];
    ?>
      <form method="post" action="">
        <div>
          <label for="itemName">Item Name:</label>
          <input type="text" name="itemName" value="<?php echo $itemName; ?>" required>
        </div>
<br>
        <div>
          <label for="shelfNumber">Shelf Number:</label><br>

          <input type="number" name="shelfNumber" value="<?php echo $shelfNumber; ?>" required>
        </div>
<br>
        <div>
          <label for="quantity">Quantity:</label><br>
          <input type="number" name="quantity" value="<?php echo $quantity; ?>" required>
        </div>
        <br>
        <button type="button" id="editButton">Edit</button>
        <button type="submit" id="updateButton" style="display: none;">Update</button>

      </form>
    <?php
    } else {
      echo "<p>Item not found.</p>";
    }
    ?>
  </div>
</main>


</body>
</html>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const editButton = document.getElementById("editButton");
    const updateButton = document.getElementById("updateButton");
    const inputFields = document.querySelectorAll(".item-details input");

    // Initial state: Disable input fields and hide the "Update" button
    inputFields.forEach((input) => {
      input.disabled = true;
    });
    updateButton.style.display = "none";

    // Toggle the disabled attribute and show/hide the "Update" button when the "Edit" button is clicked
    editButton.addEventListener("click", function () {
      inputFields.forEach((input) => {
        input.disabled = !input.disabled;
      });

      // Show/hide the "Update" button based on the state of the text boxes
      updateButton.style.display = inputFields[0].disabled ? "none" : "block";
    });
  });
</script>



<?php
// Close the PHP block after the HTML content
?>
