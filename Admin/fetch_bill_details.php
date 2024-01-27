<?php
// Include your database connection
include('config.php');

// Check if the user ID is provided in the AJAX request
if (isset($_GET['tableusers_id'])) {
    $tableusers_id = $_GET['tableusers_id'];

    // Query the database to get bill details for the specific user
    $query = $conn->prepare("SELECT * FROM tablebilling_list WHERE tableusers_id = ?");
    $query->bind_param("i", $tableusers_id);
    $query->execute();
    $result = $query->get_result();

    // Check if the query was successful and returned any result
    if ($result && $result->num_rows > 0) {
        // Fetch the data as an associative array
        $data = $result->fetch_assoc();
        
        // Output the data as JSON (you can customize this based on your needs)
        echo json_encode($data);
    } else {
        // Handle the case where no user is found
        echo json_encode(['error' => 'User not found']);
    }
} else {
    // Handle the case where no user ID is provided
    echo json_encode(['error' => 'User ID not provided']);
}
?>
