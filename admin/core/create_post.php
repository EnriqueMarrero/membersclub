<?php

session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'mod')) {
    header("Location: index.php");
    exit;
}

require 'db_connect.php';

$response = array('success' => false, 'message' => ''); // Response array to send back the success status and message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $title = $_POST['title'];
    $body = $_POST['body'];
    $author = $_SESSION['username'];
    $category = $_POST['category'];

    // Customize the post content and styling based on the category
    switch ($category) {
        case 'website_update':
            // Additional logic for website update category
            $body .= "<p class='website-update'>Version: 1.0.0</p>";
            break;
        case 'info':
            // Additional logic for info category
            // No additional customization required
            break;
        case 'critical':
            // Additional logic for critical category
            $body .= "<p class='critical'>IMPORTANT MESSAGE</p>";
            break;
    }

    // Prepare the query
    $query = "INSERT INTO blog_posts (title, body, author) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sss', $title, $body, $author);

    // Execute the query
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Post created successfully';
    } else {
        $response['message'] = 'Error: ' . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$db->close();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;

?>
