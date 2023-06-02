<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    // Include the database connection file
    require 'core/db_connect.php';

    // Get the username and password from the POST request
    $username = $_POST['username'];
    $password = $_POST['pwd'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $result = $db->query("INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')");

    if ($result) {
        // Registration was successful
        echo 'Registration successful. You may <a href="login.html">login</a> now.';
    } else {
        // Registration failed
        echo 'Registration failed: ' . $db->error;
    }

    $db->close();

    
?>
