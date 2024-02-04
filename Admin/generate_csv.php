<?php
// Include necessary files and initialize database connection
include('config.php');
include('Sidebar.php');

// Fetch data from the database
$month = isset($_POST['month']) ? $_POST['month'] : date("Y-m");
$result = $conn->query("SELECT b.*, c.code, CONCAT(c.lname, ', ', c.fname, ' ', COALESCE(c.mname, '')) as `name` FROM `tablebilling_list` b INNER JOIN tableusers c ON b.tableusers_id = c.Id WHERE DATE_FORMAT(b.reading_date, '%Y-%m') = '{$month}' ORDER BY UNIX_TIMESTAMP(`reading_date`) DESC, `name` ASC");

// Create a CSV file
$filename = 'monthly_report.csv';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

// Output CSV header
fputcsv($output, array('#', 'Reading Date', 'Due Date', 'Homeowners Name', 'Reading', 'Penalty', 'Service', 'Status', 'Amount'));

// Output data rows
$i = 1;
while ($row = $result->fetch_assoc()) {
    $csvRow = array(
        $i++,
        date("Y-m-d", strtotime($row['reading_date'])),
        date("Y-m-d", strtotime($row['due_date'])),
        $row['name'],
        'Previous: ' . format_num($row['previous']) . ', Current: ' . format_num($row['reading']),
        $row['penalties'],
        format_num($row['service']),
        getStatusLabel($row['status']),
        format_num($row['total'])
    );
    fputcsv($output, $csvRow);
}

fclose($output);
exit();
?>
