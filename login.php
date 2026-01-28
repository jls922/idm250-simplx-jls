<?php
session_start();

require_once 'db.php';

// check if typed username and password match database creds
function authenticate_user($username, $password) {
    global $pdo;
    
    try {
        // prep SQL statement to prevent SQL bad
        $stmt = $pdo->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        // Get the user pass hash from database
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // verify password matches that hash in the database
        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    } catch(PDOException $e) {
        return false;
    }
}

// empty error message
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get username from form, or empty string if not set
    $username = $_POST['username'] ?? '';
    // get pass from form, or empty string if not set
    $password = $_POST['password'] ?? '';
    
// checks if login creds are correct
    if (authenticate_user($username, $password)) {
// user session stuff
        $_SESSION['user'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        // error msg if login fails
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="images/logo.webp" alt="Logo" class="logo">
            <h1>LOGIN</h1>
            <!-- checks for error msg to display -->
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
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
                <!-- submit button that sends the form data -->
                <button type="submit">Login</button>
            </form>
            <!-- link to register link page -->
            <p style="text-align: center; margin-top: 20px; color: #9197B3;">
                Don't have an account? <a href="register.php" style="color: #2C50D4; text-decoration: none;">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>