<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once('connection.php');

    $stmt = $conn->prepare("SELECT * FROM users WHERE emailaddress = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

   // if ($user && password_verify($password, $user['password'])) {
        if ($user) {
        // Start a session and store user data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to the home page after successful login
        header('Location: home1.html');
        exit();
    } else {
        $error = 'Invalid email or password';

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content remains unchanged -->
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <p class="mt-5 mb-3 text-body-secondary">© By Sricharan Gudi</p>
    </main>
</body>
</html>
