<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $tableusers_id = intval($_POST['tableusers_id']);
    $readingDueDate = $_POST['readingDueDate'];
    $dueDate = isset($_POST['duedate']) ? $_POST['duedate'] : null;
    $currentAmount = isset($_POST['current']) ? floatval($_POST['current']) : null;
    $previousBalance = isset($_POST['previous']) ? floatval($_POST['previous']) : null;
    $serviceFee = isset($_POST['service']) ? floatval($_POST['service']) : null;
    $penalties = isset($_POST['penalties']) ? floatval($_POST['penalties']) : null;
    $totalAmount = isset($_POST['total']) ? floatval($_POST['total']) : null;
    $status = isset($_POST['status']) ? intval($_POST['status']) : null;

    // Update the billing record in the database
    $stmt = $conn->prepare("UPDATE tablebilling_list SET 
        reading_date = ?,
        due_date = ?,
        reading = ?,
        previous = ?,
        service = ?,
        penalties = ?,
        total = ?,
        status = ?
        WHERE tableusers_id = ?");

    // Check if the prepare() was successful
    if ($stmt !== false) {
        $stmt->bind_param("ssssssssi", $readingDueDate, $dueDate, $currentAmount, $previousBalance, $serviceFee, $penalties, $totalAmount, $status, $tableusers_id);

        if ($stmt->execute()) {
            // Fetch the updated billing details
            $updatedData = fetchBillingDetails($conn, $tableusers_id);

            if ($updatedData !== null) {
                // Success, send the updated data as JSON response
                echo json_encode(array('status' => 'success', 'data' => $updatedData));
            } else {
                // Error fetching updated data
                echo json_encode(array('status' => 'error', 'message' => 'Error fetching updated billing details'));
            }
        } else {
            // Error in execute()
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

function fetchBillingDetails($conn, $tableusers_id) {
    $user = $conn->prepare("SELECT * FROM `tablebilling_list` WHERE `tableusers_id` = ? ORDER BY `reading_date` DESC LIMIT 1");
    $user->bind_param("s", $tableusers_id);
    $user->execute();
    $result = $user->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}
?>
