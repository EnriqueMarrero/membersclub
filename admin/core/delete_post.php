<?php
session_start();

// Check if the user is logged in and has the necessary role
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'mod')) {
    header("Location: index.php");
    exit;
}

require 'db_connect.php';

$response = array('success' => false, 'message' => ''); // Response array to send back the success status and message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the post ID from the request
    $postId = $_POST['post_id'];

    // Prepare the delete query
    $query = "DELETE FROM blog_posts WHERE post_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $postId);

    // Execute the query
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Post deleted successfully';
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
