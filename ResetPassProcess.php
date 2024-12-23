<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "earthsavior";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $email = trim($_POST["email"]);

    // Check if email is retrieved correctly
    if (!$email) {
        die("Error: Email not found. Please try again.");
    }

    if ($new_password === $confirm_password) {
        // Passwords match, update the user table without hashing
        $sql = "UPDATE user SET Password = ? WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $new_password, $email);
            if ($stmt->execute()) {
                echo "<script>alert('Password has been reset successfully.'); window.location.href = 'Login.html';</script>";
            } else {
                // Debugging information for query execution
                echo "Error updating password: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Debugging information for statement preparation
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        // Passwords do not match, display error message
        echo "<script>alert('Passwords do not match.'); window.location.href = 'ResetPass.html?email=" . urlencode($email) . "';</script>";
    }
}
$conn->close();
?>