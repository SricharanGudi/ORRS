<?php

require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $train_id = $_POST['train_id'];
    $no_of_tickets = $_POST['no_of_tickets'];

    // Retrieve train details
    $query = "SELECT * FROM train WHERE train_id = :train_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':train_id', $train_id);
    $stmt->execute();
    $train = $stmt->fetch(PDO::FETCH_ASSOC);

    // Calculate total price
    $total_price = $train['price'] * $no_of_tickets;

    // Update payments table
    $query = "INSERT INTO Payment (amount) VALUES (:amount)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':amount', $total_price);
    $stmt->execute();

    // Retrieve the payment_id for the inserted record
    $payment_id = $conn->lastInsertId();

    // Update payments_user table
    // Assuming you have a user session with user_id
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) {
        $user_id = $_SESSION['user_id'];

        $query = "INSERT INTO payments_user (user_id, payment_id) VALUES (:user_id, :payment_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':payment_id', $payment_id);
        $stmt->execute();

        // Display success message or redirect to a success page
        echo "Payment successful!";
    } else {
        echo "Error: User ID is not set or is null.";
    }
} else {
    // Redirect if the form is not submitted
    header('Location: home.html');
    exit();
}
?>
