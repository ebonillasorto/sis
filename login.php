<?php
session_start(); 

// Define user accounts
$users = array(
    "user" => "password",
    "admin" => "admin"
);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the submitted username and password match a user account
    if (isset($users[$username]) && $users[$username] === $password) {
        // Authentication successful, set session variable
        $_SESSION["username"] = $username;
        
        // Redirect to the storage.php page
        header("Location: storage.php");
        exit(); // Ensure that no further code is executed after the header redirect
    } else {
        // Authentication failed, display an error message
        echo "Invalid username or password.";
    }
}
?>
