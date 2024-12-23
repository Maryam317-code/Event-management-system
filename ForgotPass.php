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
    $email = $_POST["email"];

    // Check if email exists in the user table
    $sql = "SELECT * FROM user WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists, proceed with the next process
        header("Location: ResetPass.php?email=" . urlencode($email));
        exit();
    } else {
        // Email does not exist, display error message
        echo "<script>alert('User not available.'); window.location.href = 'ForgotPass.html';</script>";
    }
    $stmt->close();
}
$conn->close();
?>
