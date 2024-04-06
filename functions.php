<?php
function connectMySQL() {
    $host = "localhost"; 
    $user = "root"; 
    $password = "passwordhardtoget"; 
    $database = "swincloud"; 
    // Create a database connection
    $conn = new mysqli($host, $user, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        echo "<p>There was an error trying to connect to the database. Please try again later.</p>";
        die("Connection failed: " . $conn->connect_error);
    };
    return $conn;
}
?>