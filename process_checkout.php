<?php
session_start();
include_once 'Includes/Processconfig.php';  // Ensure this path is correct

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve posted values
    $user_id = $_SESSION['user_id'];
    $payment_method = isset($_POST['payment']) ? $_POST['payment'] : null;
    $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : null;

    // Validate input
    if (!$payment_method || !$total_amount) {
        die("Required fields are missing.");
    }

    // Open database connection
    $conn = openDbConnection();

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert order into `order` table
        $query = "INSERT INTO `order` (`user_id`, `total_amount`) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }
        $stmt->bind_param("id", $user_id, $total_amount);
        $stmt->execute();
        
        $order_id = $stmt->insert_id;

        // Insert cart items into `order_items` table
        $query = "INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`) 
                  SELECT ?, `product_id`, `quantity`, `price` 
                  FROM `cart` 
                  WHERE `user_id` = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();

        // Handle file upload for bank transfer if needed
        if ($payment_method === 'bank' && isset($_FILES['slip']) && $_FILES['slip']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            $upload_file = $upload_dir . basename($_FILES['slip']['name']);
            
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    throw new Exception("Failed to create upload directory.");
                }
            }

            if (move_uploaded_file($_FILES['slip']['tmp_name'], $upload_file)) {
                // Optionally store file info in database
                $query = "INSERT INTO `bank_transfers` (`order_id`, `file_path`) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                if ($stmt === false) {
                    throw new Exception("Prepare statement failed: " . $conn->error);
                }
                $stmt->bind_param("is", $order_id, $upload_file);
                $stmt->execute();
            } else {
                throw new Exception("File upload failed.");
            }
        }

        // Clear the cart
        $query = "DELETE FROM `cart` WHERE `user_id` = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        echo "<script>alert('Order placed successfully!'); window.location.href = 'ThankYou.html';</script>";
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href = 'Cart.html';</script>";
    }

    // Close database connection
    closeDbConnection($conn);
} else {
    echo "Invalid request method.";
}
?>
