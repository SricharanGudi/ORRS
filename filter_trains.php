<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trains Availability</title>
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
    <h1>Available Trains</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Train Code</th>
                <th>Frequency</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Class</th>
                <th>Category</th>
                <th>Price</th>
                <th>Enter No.of tickets</th>
                <th>Confirm Here</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once('connection.php');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $from_address = $_POST['from_address'];
                $to_address = $_POST['to_address'];
                $date = $_POST['date'];
                $class = $_POST['class'];
                $category = $_POST['category'];

                $formatted_date = DateTime::createFromFormat('Y-m-d', $date)->format('d-m-Y');

                $query = "SELECT * FROM train WHERE from_address = :from_address AND to_address = :to_address AND dates = :date AND class = :class AND category = :category";

                $stmt = $conn->prepare($query);
                $stmt->bindParam(':from_address', $from_address);
                $stmt->bindParam(':to_address', $to_address);
                $stmt->bindParam(':date', $formatted_date);
                $stmt->bindParam(':class', $class);
                $stmt->bindParam(':category', $category);
                $stmt->execute();
                $trains = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($trains as $train) {
                    echo "<tr>";
                    echo "<td>" . $train['train_name'] . "</td>";
                    echo "<td>" . $train['train_code'] . "</td>";
                    echo "<td>" . $train['frequency'] . "</td>";
                    echo "<td>" . $train['from_address'] . "</td>";
                    echo "<td>" . $train['to_address'] . "</td>";
                    echo "<td>" . $train['dates'] . "</td>";
                    echo "<td>" . $train['class'] . "</td>";
                    echo "<td>" . $train['category'] . "</td>";
                    echo "<td>" . $train['price'] . "</td>";
                    echo "<td><form method='post' action='confirm.php'>";  
                    echo "<input type='hidden' name='train_id' value='" . $train['train_id'] . "'>";  
                    echo "<input type='number' name='no_of_tickets' required></td>";  
                    echo "<td><button type='submit' class='custom-btn'>Confirm</button></form></td>";  
                    echo "</tr>";
                }
            } else {
                header('Location: home.html');
                exit();
            }
            ?>
        </tbody>
    </table> 
</body>
</html>
