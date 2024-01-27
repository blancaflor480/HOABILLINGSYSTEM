<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $tableusers_id = intval($_POST['tableusers_id']);
    $readingDueDate = $_POST['reading_dueDate']; // Adjusted input name
    $dueDate = isset($_POST['duedate']) ? $_POST['duedate'] : null;
    $currentAmount = isset($_POST['current']) ? floatval($_POST['current']) : null;
    $previousBalance = isset($_POST['previous']) ? floatval($_POST['previous']) : null; // Adjusted input name
    $serviceFee = isset($_POST['service']) ? floatval($_POST['service']) : null;
    $penalties = isset($_POST['penalties']) ? floatval($_POST['penalties']) : null;
    $totalAmount = isset($_POST['total']) ? floatval($_POST['total']) : null; // Adjusted input name
    $status = isset($_POST['status']) ? intval($_POST['status']) : null;

    // Update the billing record in the database
    $stmt = $conn->prepare("UPDATE tablebilling_list SET 
        reading_date = ?,
        due_date = ?,
        reading = ?,
        previous = ?,
        service = ?, -- Adjusted column name
        penalties = ?, -- Adjusted column name
        total = ?, -- Adjusted column name
        status = ?
        WHERE tableusers_id = ?");

    // Check if the prepare() was successful
    if ($stmt !== false) {
        $stmt->bind_param("ssssssssi", $readingDueDate, $dueDate, $currentAmount, $previousBalance, $serviceFee, $penalties, $totalAmount, $status, $tableusers_id);

        if ($stmt->execute()) {
            // Success
            echo json_encode(array('status' => 'success', 'message' => 'Billing record updated successfully'));
        } else {
            // Error
            echo json_encode(array('status' => 'error', 'message' => 'Error updating billing record: ' . $stmt->error));
        }

        $stmt->close();
    } else {
        // Error in prepare()
        echo json_encode(array('status' => 'error', 'message' => 'Prepare statement error: ' . $conn->error));
    }

    $conn->close();
} else {
    // Invalid request method
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>
