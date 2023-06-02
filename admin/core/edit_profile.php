<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'mod')) {
    header("Location: index.php");
}

require 'core/db_connect.php';

// Fetch latest blog posts
if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $query = "SELECT post_id, title, body, author, timestamp FROM blog_posts WHERE category = ? ORDER BY timestamp DESC LIMIT 3";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $query = "SELECT post_id, title, body, author, timestamp FROM blog_posts ORDER BY timestamp DESC LIMIT 3";
    $result = $db->query($query);
    $posts = $result->fetch_all(MYSQLI_ASSOC);
}

$query = "SELECT post_id, title, body, author, timestamp, category FROM blog_posts ORDER BY timestamp DESC LIMIT 3";
$result = $db->query($query);
$posts = $result->fetch_all(MYSQLI_ASSOC);

$query = "SELECT username, last_login, status FROM users ORDER BY last_login DESC";
$result = $db->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

// Query to count the number of subscribed users
$query = "SELECT COUNT(*) AS subscribe_count FROM subscribers";
$result = $db->query($query);
$row = $result->fetch_assoc();
$subscribeCount = $row['subscribe_count'] ?? 0; // Assign a default value if the query fails or no subscribers found

// Fetch user's profile information
$query = "SELECT name, email FROM users WHERE username = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();
?>