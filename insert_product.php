<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $productName = $_POST['productName'];
    $quantity =$_POST['quantity'];
    $price = $_POST['price'];
    $review = $_POST['review'];

    require_once('connection2.php');

    try {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("INSERT INTO products (name, quantity, price, review) VALUES (:productName, :quantity, :price, :review)");
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price); // Assuming price is stored as string
        $stmt->bindParam(':review', $review);

        if ($stmt->execute()) {
            echo "Product added successfully!";
            // You can redirect or perform additional actions here
        } else {
            echo "Product addition failed.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
