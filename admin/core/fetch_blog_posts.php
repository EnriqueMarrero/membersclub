<?php
require 'db_connect.php';

// Fetch latest blog posts
$query = "SELECT post_id, title, body, author, timestamp FROM blog_posts ORDER BY timestamp DESC LIMIT 3";
$result = $db->query($query);
$posts = $result->fetch_all(MYSQLI_ASSOC);

// Generate HTML output for the blog posts
$html = '';
foreach ($posts as $post) {
    $html .= '<div class="card mb-4">';
    $html .= '<div class="card-header">';
    $html .= '<h5 class="card-title">';
    $html .= '<i class="fas fa-info-circle"></i> Website Update';
    $html .= '</h5>';
    $html .= '<button class="btn btn-link delete-post float-right" data-post-id="' . $post['post_id'] . '">';
    $html .= '<i class="fas fa-trash-alt"></i> Delete';
    $html .= '</button>';
    $html .= $post['title'];
    $html .= '</div>';
    $html .= '<div class="card-body">';
    $html .= '<h6 class="card-subtitle mb-2 text-muted">';
    $html .= 'Posted by ' . $post['author'];
    $html .= ' on ' . $post['timestamp'];
    $html .= '</h6>';
    $html .= '<p class="card-text">' . $post['body'] . '</p>';
    $html .= '</div>';
    $html .= '</div>';
}

// Send the HTML response
echo $html;

// Close the database connection
$db->close();
?>
