<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'config.php';
include 'fetch_bill_details.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    // Sanitize and validate inputs
    $tableusers_id = filter_var($_POST['tableusers_id'], FILTER_VALIDATE_INT);
    $readingDate = $_POST['readingDueDate'];
    $dueDate = $_POST['billDueDate'];
    $currentAmount = filter_var($_POST['current'], FILTER_VALIDATE_FLOAT);
    $previous = isset($_POST['previous']) ? filter_var($_POST['previous'], FILTER_VALIDATE_FLOAT) : 0;
    $service = isset($_POST['service']) ? filter_var($_POST['service'], FILTER_VALIDATE_FLOAT) : 10;
    $penalties = isset($_POST['penalties']) ? filter_var($_POST['penalties'], FILTER_VALIDATE_FLOAT) : 0;
    $totalAmount = $currentAmount + $service;
    $status = $_POST['status'];

    // Check if a record already exists for the user
    $recordExists = checkBillingRecordExists($conn, $tableusers_id);

    if ($recordExists) {
        // If a record exists, update it
        $stmt = $conn->prepare("UPDATE tablebilling_list SET reading_date=?, due_date=?, reading=?, previous=?, service=?, total=?, status=? WHERE tableusers_id = ?");
        $stmt->bind_param("sssssssi", $readingDate, $dueDate, $currentAmount, $previous, $service, $totalAmount, $status, $tableusers_id);

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
    } else {
        // If no record exists, display an error
        echo json_encode(array('status' => 'error', 'message' => 'Error: Billing record not found for the user.'));
        
        echo "SQL Query: SELECT * FROM `tablebilling_list` WHERE `tableusers_id` = $tableusers_id LIMIT 1<br>";
        echo "User ID: $tableusers_id<br>";
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}

function checkBillingRecordExists($conn, $tableusers_id) {
    $stmt = $conn->prepare("SELECT * FROM `tablebilling_list` WHERE `tableusers_id` = ? LIMIT 1");
    $stmt->bind_param("i", $tableusers_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result && $result->num_rows > 0;
}
function sendEmailNotification($tableusers_id, $totalAmount, $dueDate, $conn) {
    // Your email configuration
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'billinghoa@gmail.com'; // SMTP username
        $mail->Password = 'sqtrxkdxrkbalgfu'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to, use 587 for `PHPMailer::ENCRYPTION_STARTTLS` above

        // Retrieve recipient's email from the database based on $tableusers_id
        $sql = "SELECT `email` FROM `tableusers` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tableusers_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Recipient email address
            $recipientEmail = $row['email'];

            // Recipients
            $mail->setFrom('billinghoa@gmail.com');
            $mail->addAddress($recipientEmail, 'Recipient Name'); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Billing Notification';
            $mail->Body = "Hello! Your bill of $totalAmount is due on $dueDate. Thank you!";

            $mail->send();
            echo 'Email sent successfully';
        } else {
            echo 'Error: User not found';
        }
    } catch (Exception $e) {
        // Log any exception that occurs
        echo 'Error: ' . $e->getMessage();
    }
}

function fetchBillingDetails($conn, $tableusers_id) {
    $user = $conn->prepare("SELECT * FROM `tablebilling_list` WHERE `tableusers_id` = ? ORDER BY `reading_date` DESC LIMIT 1");
    $user->bind_param("i", $tableusers_id);
    $user->execute();
    $result = $user->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}
?>
