<?php
include_once 'Includes/configdonate.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $donatorsName = filter_var($_POST['DonatorsName'], FILTER_SANITIZE_STRING);
    $contactNumber = filter_var($_POST['ContactNumber'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['Address'], FILTER_SANITIZE_STRING);
    $collectionPoint = filter_var($_POST['CollectionPoint'], FILTER_SANITIZE_STRING);
    $amount = filter_var($_POST['Amount'], FILTER_VALIDATE_FLOAT);

    // Check if amount is valid
    if ($amount !== false) {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO donate (DonatorsName, ContactNumber, Address, CollectionPoint, Amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssd", $donatorsName, $contactNumber, $address, $collectionPoint, $amount);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Thank you for your donation! Your record has been successfully stored.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Please enter a valid amount.";
    }

    // Close the connection
    $conn->close();
}
?>

