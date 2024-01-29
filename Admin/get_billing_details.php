<?php
include 'config.php';

$defaultServiceFee = 10; // Set the default service fee
$defaultPenalties = 0; // Set the default penalties

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tableusers_id = $_POST['tableusers_id'];

    // Use a prepared statement to prevent SQL injection
    $query = "SELECT previous, service, penalties, total FROM tablebilling_list WHERE tableusers_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tableusers_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row !== null) {
            $response = array(
                'previousBalance' => $row['previous'],
                'serviceFee' => $row['service'],
                'penalties' => $row['penalties'],
                'totalAmount' => $row['total']
            );
        } else {
            // Provide default values when no data is found
            $response = array(
                'previousBalance' => 0,
                'serviceFee' => $defaultServiceFee,
                'penalties' => $defaultPenalties,
                'totalAmount' => 0
            );

            $response['error'] = 'No data found for the user with ID ' . $tableusers_id;
        }
    } else {
        $response['error'] = 'Database query error: ' . $stmt->error;
        // Log the SQL query and error for debugging
        error_log("SQL Query: $query | Error: " . $stmt->error);
    }

    // Log additional information for debugging
    $response['tableusers_id'] = $tableusers_id;
} else {
    $response['error'] = 'Invalid request method';
}

// Return a consistent JSON structure
if (isset($response['error'])) {
    $response['success'] = false;
} else {
    $response['success'] = true;
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
