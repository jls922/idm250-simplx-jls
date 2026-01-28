<?php
session_start();

require_once 'db.php';

function register_user($username, $password) {
    global $pdo;
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        // prep SQL statement to prevent SQL bad
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();
        return true;
    } catch(PDOException $e) {
        // username already exists or other error
        return false;
    }
}

// creates variables to store messages
$error = '';
$success = '';

// check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // validates that passwords match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters.';
    } else {
        // registers the user
        if (register_user($username, $password)) {
            $success = 'Registration successful! You can now login.';
        } else {
            $error = 'Username already exists or registration failed.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="images/logo.webp" alt="Logo" class="logo">
            <h1>REGISTER</h1>
            <!-- checks if an error message to show -->
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <!-- checks if a success message to display -->
            <?php if ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <!-- creates a form that submits data...POST method -->
            <form method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <!-- password input box -->
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <!-- password input box for confirmation -->
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                </div>
                <button type="submit">Register</button>
            </form>
            <!-- link to login page -->
            <p style="text-align: center; margin-top: 20px; color: #9197B3;">
                Already have an account? <a href="login.php" style="color: #2C50D4; text-decoration: none;">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>