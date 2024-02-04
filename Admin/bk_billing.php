<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $tableusers_id = $_POST['tableusers_id'];
    $readingDueDate = $_POST['readingDueDate'];
    $billDueDate = $_POST['billDueDate'];
    $currentAmount = $_POST['current'];
    $penalties = $_POST['penalties'];
    $serviceFee = $_POST['service']; // Get the service fee from the user input
    $totalAmount = floatval($currentAmount) + floatval($penalties) + floatval($serviceFee); // Calculate total amount
    $status = $_POST['status'];

    // Extracting ID from $tableusers_id
    list($userId) = explode(' - ', $tableusers_id);
    $userId = intval($userId);  // Ensure $userId is an integer

    // Check if the user exists
    $userQuery = "SELECT * FROM tableusers WHERE Id = $userId";
    $userResult = $conn->query($userQuery);

    if ($userResult === FALSE) {
        // Handle SQL error
        echo json_encode(['error' => 'Error checking user: ' . $conn->error]);
    } elseif ($userResult->num_rows > 0) {
        // User found, proceed with billing creation

        // Insert the billing details into your database using prepared statements
        $insertQuery = $conn->prepare("INSERT INTO tablebilling_list (tableusers_id, reading_date, due_date, reading, penalties, service, total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insertQuery->bind_param("isssssss", $userId, $readingDueDate, $billDueDate, $currentAmount, $penalties, $serviceFee, $totalAmount, $status);

        if ($insertQuery->execute() === TRUE) {
            // Send email notification using PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; // You can set DEBUG_SERVER, DEBUG_CLIENT, or DEBUG_OFF
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server host
                $mail->SMTPAuth = true;
                $mail->Username = 'billinghoa@gmail.com'; // Replace with your SMTP username
                $mail->Password = 'sqtrxkdxrkbalgfu'; // Replace with your SMTP password
                $mail->SMTPSecure = 'ssl'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port = 465; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                // Recipients
                $mail->setFrom('billinghoa@gmail.com');
                $mail->addAddress($userResult->fetch_assoc()['email']);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'New Bill Generated';
                $mail->Body = "Dear User,<br>A new bill has been generated for you. Here are the details:<br><br>
                               Reading Date: $readingDueDate<br>
                               Due Date: $billDueDate<br>
                               Current Amount: $currentAmount<br>
                               Penalties: $penalties<br>
                               Service Fee: $serviceFee<br>
                               Total Amount: $totalAmount<br>
                               Status: $status<br><br>
                               Please log in to check the details.<br>

                               <b>Disclaimer</b>: The message in and bills to this e-mail may be privileged and/or confidential and are intended only for authorized recipients. If you are not its intended recipient, please delete. Views and opinions expressed in this e-mail are those of the sender. They do not necessarily reflect the views of Rosedale Residence and its officials.

                               <br><br>
                               ** This is an auto-generated email.<b> DO NOT REPLY TO THIS MESSAGE.</b> **";

                $mail->send();
                echo json_encode(['success' => 'Billing created successfully. Email sent.', 'redirect' => 'billing.php']);
        echo '<script>window.location.href = "billing.php";</script>'; // Redirect to billing.php after successful billing creation
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error sending email: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Error inserting billing: ' . $conn->error]);
}

        // Close the prepared statement
        $insertQuery->close();

    } else {
        echo json_encode(['error' => 'Error: User not found or invalid user ID.']);
    }
}
?>
