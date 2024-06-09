<?php
// connection.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "railway";  // Adjust the database name if needed

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
