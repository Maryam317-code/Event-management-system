<?php
session_start();
include_once 'Includes/Signinconfig.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Open database connection
    $conn = openDbConnection();

    // Sanitize inputs to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Prepare and execute the query to fetch user data
    $query = "SELECT * FROM user WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['Password'])) {
            // Store user information in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['FullName'];
            $_SESSION['email'] = $user['Email'];

            // Redirect to the profile page or homepage
            header('Location: index.html');
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Invalid Email or Password!'); window.location.href = 'Login.html';</script>";
        }
    } else {
        // No user found
        echo "<script>alert('Invalid Email or Password!'); window.location.href = 'Login.html';</script>";
    }

    // Close the statement and database connection
    $stmt->close();
    closeDbConnection($conn);
}
