<?php
function Connect()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "college_resource_rental_system";
    
    // Create connection
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>