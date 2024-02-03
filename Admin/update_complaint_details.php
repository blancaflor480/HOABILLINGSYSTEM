<?php
session_start();
include('config.php');

if (isset($_POST['complaintId']) && isset($_POST['stats'])) {
    $complaintId = $_POST['complaintId'];
    $stats = $_POST['stats'];

    // Update the complaint status in the database
    $updateQuery = "UPDATE tablecomplaint SET stats = '$stats' WHERE Id = $complaintId";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        echo "Complaint status updated successfully";
    } else {
        echo "Error updating complaint status";
    }
} else {
    echo "Invalid parameters";
}
?>