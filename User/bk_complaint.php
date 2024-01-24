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

    // Set the default status to "Unprocessed"
    $status = "Unprocessed";

    // Insert the complaint data into the table
    $sql = "INSERT INTO tablecomplaint (tableusers_id, typecomplaint, description, status) 
            VALUES ((SELECT id FROM tableusers WHERE email = '$email'), '$typecomplaint', '$description', '$status')";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect or perform other actions upon successful submission
        echo '<script>alert("Complaint submitted successfully!"); window.location.href = "complaint.php";</script>';
        exit();
    } else {
        // Handle the case where the insertion fails
        echo '<script>alert("Failed to submit complaint. Please try again."); window.location.href = "complaint.php";</script>';
        exit();
    }
}
?>
