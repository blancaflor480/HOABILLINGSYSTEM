<?php
// process_payment.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $billingId = $_POST['billing_id'];
    $amount = $_POST['amountpay'];

    // Validate data
    if (empty($billingId) || empty($amount) || !is_numeric($amount) || empty($_POST['referenceId'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit;
    }

    // Check if the 'receipt' key exists in the $_FILES array
    if(isset($_FILES['receipt_file'])) {
        // Handle file upload
        $uploadDir = 'uploads/';
        $receiptFile = $_FILES['receipt_file'];
        $uploadPath = $uploadDir . basename($receiptFile['name']);

        if (move_uploaded_file($receiptFile['tmp_name'], $uploadPath)) {
            // File uploaded successfully
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload receipt']);
            exit;
        }
    }

    // Database connection
    $conn = new mysqli("localhost", "root", "", "billing");

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection error']);
        exit;
    }

    // Update billing status
    $stmt = $conn->prepare("UPDATE tablebilling_list SET paymode = 1, status = 2 WHERE id = ?");
    $stmt->bind_param("i", $billingId);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to update billing status']);
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();

// Check if $uploadPath is not empty
if (!empty($uploadPath)) {
    // Insert payment details into payments table
    $stmt = $conn->prepare("INSERT INTO tablepayments (billing_id, amount, reference_id, receipt_path) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: (' . $conn->errno . ') ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("idss", $billingId, $amount, $_POST['referenceId'], $uploadPath);
} else {
    // Insert payment details without receipt_path
    $stmt = $conn->prepare("INSERT INTO tablepayments (billing_id, amount, reference_id) VALUES (?, ?, ?)");

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: (' . $conn->errno . ') ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("ids", $billingId, $amount, $_POST['referenceId']);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Payment successful']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to store payment details: (' . $stmt->errno . ') ' . $stmt->error]);
}

$stmt->close();
$conn->close();

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
