<?php
include_once 'Includes/Config.php'; // Ensure this path is correct

// Retrieve form data
$fullname = $_POST['full_name'];
$email = $_POST['email'];
$contact_number = $_POST['contact_number'];
$password = $_POST['password'];

// Hash the password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$sql = "INSERT INTO user (FullName, Email, CoNum, Password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

// Bind parameters (s = string, i = integer)
$stmt->bind_param("ssss", $fullname, $email, $contact_number, $passwordHash);

if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

// Success message
echo "<script>alert('Account Created Successfully!'); window.location.href = 'Login.html';</script>";

$stmt->close();
$conn->close();
