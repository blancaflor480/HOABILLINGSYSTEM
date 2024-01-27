<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data (sanitize user input to prevent SQL injection)
    $billing_id = intval($_POST['billing_id']);
    $readingDate = $_POST['readingDueDate'];
    $dueDate = $_POST['billDueDate'];
    $currentAmount = floatval($_POST['current']);

    $previous = isset($_POST['previous']) ? floatval($_POST['previous']) : 0;
    $service = isset($_POST['service']) ? floatval($_POST['service']) : 10;
    $penalties = isset($_POST['penalties']) ? floatval($_POST['penalties']) : 0;

    $totalAmount = $currentAmount + $service;
    $status = $_POST['status'];

    // Use prepared statement to update existing record
    $stmt = $conn->prepare("UPDATE tablebilling_list SET reading_date=?, due_date=?, reading=?, previous=?, service=?, total=?, status=? WHERE billing_id=?");
    $stmt->bind_param("sssssssi", $readingDate, $dueDate, $currentAmount, $previous, $service, $totalAmount, $status, $billing_id);

    if ($stmt->execute()) {
        // Success
        echo json_encode(array('status' => 'success', 'message' => 'Billing record updated successfully'));

        // Close the statement
        $stmt->close();

        // Call the function to send email notification using PHPMailer
        sendEmailNotification($tableusers_id, $totalAmount, $dueDate, $conn);
    } else {
        // Error
        echo json_encode(array('status' => 'error', 'message' => 'Error updating billing record: ' . $conn->error));
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>
