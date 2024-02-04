<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
<style>
        body, .swal-title, .swal-text, .swal-button {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
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
        // Payment successful, trigger SweetAlert
        echo json_encode(['success' => true, 'message' => 'Payment successful']);
        echo '<script>
                Swal.fire({
                    title: "Payment sent Successfully!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.href = "billing.php";
                });
              </script>';
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to store payment details: (' . $stmt->errno . ') ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

<!--< ?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $billingId = $_POST['billing_id'];
    $amount = $_POST['amountpay'];

    if (empty($billingId) || empty($amount) || !is_numeric($amount) || empty($_POST['referenceId'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit;
    }

    if (isset($_FILES['receipt_file'])) {
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

    if (!empty($uploadPath)) {
        $stmt = $conn->prepare("INSERT INTO tablepayments (billing_id, amount, reference_id, receipt_path) VALUES (?, ?, ?, ?)");

        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: (' . $conn->errno . ') ' . $conn->error]);
            exit;
        }

        $stmt->bind_param("idss", $billingId, $amount, $_POST['referenceId'], $uploadPath);
    } else {
        $stmt = $conn->prepare("INSERT INTO tablepayments (billing_id, amount, reference_id) VALUES (?, ?, ?)");

        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: (' . $conn->errno . ') ' . $conn->error]);
            exit;
        }

        $stmt->bind_param("ids", $billingId, $amount, $_POST['referenceId']);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Payment successful']);
    
        try {
            $getUserEmailStmt = $conn->prepare("SELECT email, lname FROM tableusers WHERE Id = ?");
    
            $getUserEmailStmt->bind_param("i", $userId);
            $getUserEmailStmt->execute();
            $getUserEmailResult = $getUserEmailStmt->get_result();
    
            if ($getUserEmailResult->num_rows > 0) {
                $userData = $getUserEmailResult->fetch_assoc();
                $userEmail = $userData['email'];
                $userName = $userData['lname'];
    
                $mail = new PHPMailer(true);
    
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'billinghoa@gmail.com';
                $mail->Password   = 'sqtrxkdxrkbalgfu';
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;
    
                $mail->setFrom('billinghoa@gmail.com');
                $mail->addAddress($userEmail);
    
                $mail->isHTML(true);
                $mail->Subject = 'Payment Successful';
                $mail->Body    = 'Dear ' . $userName . ',<br><br>Your payment of $' . $amount . ' has been received successfully.<br><br>Thank you!';
    
                $mail->send();
    
                echo '<script>
                        Swal.fire({
                            title: "Payment sent Successfully!",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(function() {
                            window.location.href = "billing.php";
                        });
                      </script>';
            } else {
                echo json_encode(['success' => false, 'message' => 'User email not found']);
            }
    
            $getUserEmailStmt->close();
        } catch (Exception $e) {
            echo 'Email could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to store payment details: (' . $stmt->errno . ') ' . $stmt->error]);
    }
}
?>
