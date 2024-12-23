<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Earth Savior</title>
    <link rel="stylesheet" href="Assets/style.css">
</head>
<body>
    <div class="login-box">
        <h2>Reset Password</h2>
        <form action="ResetPassProcess.php" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <input type="password" name="new_password" placeholder="Enter New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" class="button">Reset Password</button>
        </form>
        <p>Remembered? <a href="Login.html">Login</a></p>
    </div>
</body>
</html>
