<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config/db_connect.php';

session_start();

$message = '';
$status = 0;
$redirect = '';

// When form submitted, check and create user session.
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM `users` WHERE username=?";
    $statement = $db->prepare($query);
    $statement->bind_param('s', $username);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows === 0) {
        $message = "Incorrect Username.";
    } else {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; //assuming there is a 'role' column in your users table
            $message = "You are logged in.";
            $status = 1;
            if($row['role'] == 'admin' || $row['role'] == 'mod') {
                $redirect = 'admin/index.php'; //assuming your dashboard page is named 'dashboard.php'
            }

            // Update the last login timestamp
            $currentTime = date('Y-m-d H:i:s');
            $query = "UPDATE `users` SET last_login=? WHERE username=?";
            $statement = $db->prepare($query);
            $statement->bind_param('ss', $currentTime, $username);
            $statement->execute();
        } else {
            $message = "Incorrect Password.";
        }
    }
}

if (!$db) {
    echo json_encode(['status' => 0, 'message' => 'Unable to connect to the database', 'redirect' => '']);
    exit();
}

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo json_encode(['status' => 0, 'message' => 'Username or password not received', 'redirect' => '']);
    exit();
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode(['status' => $status, 'message' => $message, 'redirect' => $redirect]);
?>
