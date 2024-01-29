<?php
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['tableusers_id'])) {
    $tableusers_id = $_GET['tableusers_id'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM `tablebilling_list` WHERE `tableusers_id` = ? ORDER BY `reading_date` DESC LIMIT 1");
    $stmt->bind_param("i", $tableusers_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Return data as JSON
        echo json_encode($data);
    } else {
        echo json_encode(array('error' => 'Billing record not found for the user.'));
    }

    $stmt->close();
} else {
    echo json_encode(array('error' => 'Invalid request method or missing tableusers_id.'));
}
?>