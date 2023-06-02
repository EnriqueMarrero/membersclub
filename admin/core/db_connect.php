<?php
    // Database credentials
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'ask777';

    // Create connection
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if ($db->connect_error) {
        die('Connection failed: ' . $db->connect_error);
    }
?>
