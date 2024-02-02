<?php
// process_payment.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $billingId = $_POST['billing_id'];
    $amount = $_POST['amountpay'];

    // Perform validation (you should add more thorough validation)
    if (empty($billingId) || empty($amount) || !is_numeric($amount)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit;
    }

    // Your payment gateway integration here...

    // Update the billing status
    $conn = new mysqli("localhost", "root", "", "billing");

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection error']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE tablebilling_list SET paymode = 1, status = 2 WHERE id = ?");
    $stmt->bind_param("i", $billingId);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to update billing status']);
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();

    // Insert payment details into a payments table (create this table)
    $stmt = $conn->prepare("INSERT INTO tablepayments (billing_id, amount, reference_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $billingId, $amount, $_POST['referenceId']); // Use the referenceId from the form

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Payment successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to store payment details']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
