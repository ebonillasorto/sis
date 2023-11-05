<?php
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
        // Authentication successful, you can redirect to a dashboard or another page
        echo "Welcome, $username!";
    } else {
        // Authentication failed, display an error message
        echo "Invalid username or password.";
    }
}
?>
