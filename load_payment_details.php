<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $payment_id = $_POST['payment_id'];
    $mobile_number = $_POST['mobile_number'];

    // Perform a database query to fetch payment details
    $query = "SELECT p.payment_id, p.amount, u.username, u.mobile_no
              FROM Payment p
              INNER JOIN payments_user pu ON p.payment_id = pu.payment_id
              INNER JOIN users u ON pu.user_id = u.id
              WHERE p.payment_id = :payment_id AND u.mobile_no = :mobile_number";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':payment_id', $payment_id);
    $stmt->bindParam(':mobile_number', $mobile_number);
    $stmt->execute();

    // Fetch the result
    $paymentDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($paymentDetails) {
        // Display or process payment details
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Payment Details</title>
                  <style>
                      body {
                          font-family: Arial, sans-serif;
                          background-color: #f4f4f4;
                          margin: 20px;
                      }

                      h1 {
                          text-align: center;
                          color: #333;
                      }

                      table {
                          width: 100%;
                          border-collapse: collapse;
                          margin-top: 20px;
                      }

                      th, td {
                          border: 1px solid #ddd;
                          padding: 8px;
                          text-align: left;
                      }

                      th {
                          background-color: #0045c9;
                          color: white;
                      }

                      tr:nth-child(even) {
                          background-color: #f2f2f2;
                      }

                      /* Style for the button */
                      .custom-btn {
                          display: inline-block;
                          width: 100%;
                          padding: 10px 20px; /* Adjust padding as needed */
                          background-color: #007bff; /* Bootstrap primary color */
                          color: #fff; /* Text color */
                          text-align: center;
                          text-decoration: none;
                          cursor: pointer;
                          border: 1px solid transparent;
                          border-radius: 5px;
                          transition: background-color 0.3s ease;
                      }

                      /* Hover effect */
                      .custom-btn:hover {
                          background-color: #0056b3; /* Darker shade for hover effect */
                      }
                  </style>
              </head>
              <body>
                  <h1>Payment Details</h1>";

        // Display the payment details in a table
        echo "<table>
                  <thead>
                      <tr>
                          <th>Payment ID</th>
                          <th>Amount</th>
                          <th>Username</th>
                          <th>Mobile Number</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>" . $paymentDetails['payment_id'] . "</td>
                          <td>Rs." . $paymentDetails['amount'] . "</td>";

        // Check if keys exist before accessing them
        if (isset($paymentDetails['username'])) {
            echo "<td>" . $paymentDetails['username'] . "</td>";
        } else {
            echo "<td>Username not available</td>";
        }

        if (isset($paymentDetails['mobile_no'])) {
            echo "<td>" . $paymentDetails['mobile_no'] . "</td>";
        } else {
            echo "<td>Mobile Number not available</td>";
        }

        echo "</tr>
              </tbody>
          </table>";

        echo "</body>
              </html>";
    } else {
        // No matching payment details found
        echo "No payment details found for the given payment ID and mobile number.";
    }
} else {
    // Redirect if the form is not submitted
    header('Location: payments.html'); // Adjust the page URL
    exit();
}
?>
