<?php
include 'config.php';

$defaultServiceFee = 10; // Set the default service fee
$defaultPenalties = 0; // Set the default penalties

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];

    $query = "SELECT previous, service, penalties, total FROM tablebilling_list WHERE tableusers_id = $userId";
    $result = $conn->query($query);

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

            $response['error'] = 'No data found for the user with ID ' . $userId;
        }
    } else {
        $response['error'] = 'Database query error: ' . $conn->error;
    }

    // Log additional information for debugging
    $response['query'] = $query;
    $response['row'] = $row;
    $response['userId'] = $userId;
} else {
    $response['error'] = 'Invalid request method';
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
