<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['billingId'])) {
    // Fetch payment details for the given billing ID
    $billingId = $_GET['billingId'];
    $selectQuery = "SELECT tableusers_id, amountpay, paymode FROM `tablebilling_list` WHERE `id` = $billingId";
    $result = mysqli_query($conn, $selectQuery);

    if ($result) {
        $paymentDetails = mysqli_fetch_assoc($result);

        if ($paymentDetails) {
            echo json_encode(['success' => true, 'paymentDetails' => $paymentDetails]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Payment details not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching payment details']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['billingId'])) {
    // Update the status to 1 (Paid) for the given billing ID
    $billingId = $_POST['billingId'];
    $updateQuery = "UPDATE `tablebilling_list` SET `status` = 1 WHERE `id` = $billingId";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating payment status']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
