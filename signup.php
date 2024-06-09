<?php
// Require the database connection file
require_once('connection.php');

// Check if the HTTP method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the form
    $username = $_POST['username'];
    $email = $_POST['emailaddress'];
    $mobile_no = $_POST['mobile_no'];
    $age = $_POST['age'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare an SQL statement to insert user data into the 'users' table
    $stmt = $conn->prepare("INSERT INTO users (username, emailaddress, mobile_no, age, password) VALUES (:username, :email, :mobile_no, :age, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mobile_no', $mobile_no);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':password', $password);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "Signup successful!"; // You can redirect or perform additional actions here
    } else {
        echo "Signup failed.";
    }
}
?>
