<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["complaintId"])) {
    $complaintId = $_GET["complaintId"];
$query = $conn->prepare("SELECT c.*, u.*, CONCAT(u.lname, ', ', u.fname, ' ', COALESCE(u.mname, '')) AS full_name
                         FROM tablecomplaint c
                         INNER JOIN tableusers u ON c.tableusers_id = u.id
                         WHERE c.Id = ?");
$query->bind_param("i", $complaintId);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $complaint = $result->fetch_assoc();
    ?>

    <!-- Display complaint details in the modal -->
    <h5>Complaint #<?php echo $complaint['Id']; ?></h5>
    <p>Date Time:<span style="font-weight: 500;"> <?php echo date("Y-m-d H:i", strtotime($complaint['date_time'])); ?></span></p>
    <p>Full Name:<span style="font-weight: 500;"> <?php echo $complaint['full_name']; ?></span></p>
    <p>Type of Complaint:<span style="font-weight: 500;"> <?php echo $complaint['typecomplaint']; ?></span></p>
    <p>Bill ID: <span style="font-weight: 500;"> <?php echo $complaint['bill_id']; ?></span></p>
    
    <p>Complaint:<span style="font-weight: 500;"> <?php echo $complaint['description']; ?></span></p>
    <p><?php
    switch ($complaint['stats']) {
        case 0:
            $statusBadge = '<span class="badge badge-danger bg-gradient-danger text-lg px-3">UNPROCESS</span>';
            break;
        case 1:
            $statusBadge = '<span class="badge badge-success bg-gradient-success text-lg px-3">PROCESS</span>';
            break;
        case 2:
            $statusBadge = '<span class="badge badge-warning bg-gradient-warning text-lg px-3">PENDING</span>';
            break;
        default:
            $statusBadge = ''; // Add a default case if needed
    }

    echo $statusBadge;
?></p>

    <?php
} else {
    echo "Complaint not found.";
}
}
?>
