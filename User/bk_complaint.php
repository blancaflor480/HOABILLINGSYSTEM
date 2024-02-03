<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    die();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $typecomplaint = mysqli_real_escape_string($conn, $_POST['typecomplaint']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $bill_id = mysqli_real_escape_string($conn, $_POST['bill_id']);
    $status = 0; // Set default status to '0' (Unprocessed)

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO tablecomplaint (tableusers_id, typecomplaint, description, bill_id, status) 
                            VALUES ((SELECT id FROM tableusers WHERE email = ?), ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $email, $typecomplaint, $description, $bill_id, $status);

    $result = $stmt->execute();

    if ($result) {
        // Redirect or perform other actions upon successful submission
        echo '<script>alert("Complaint submitted successfully!"); window.location.href = "complaint.php";</script>';
        exit();
    } else {
        // Handle the case where the insertion fails
        echo '<script>alert("Failed to submit complaint. Please try again."); window.location.href = "complaint.php";</script>';
        exit();
    }
    $stmt->close();
}
?>
