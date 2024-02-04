<?php

require 'config.php';

if (isset($_POST['update_billing'])) {
    $billing_id = mysqli_real_escape_string($conn, $_POST['billing_id']);
    $tableusers_id = mysqli_real_escape_string($conn, $_POST['tableusers_id']);
    $reading_date = mysqli_real_escape_string($conn, $_POST['reading_date']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $reading = mysqli_real_escape_string($conn, $_POST['reading']);
    $previous = mysqli_real_escape_string($conn, $_POST['previous']);
    $penalties = mysqli_real_escape_string($conn, $_POST['penalties']);
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $total = mysqli_real_escape_string($conn, $_POST['total']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Check for empty values
    if (empty($tableusers_id) || empty($reading_date) || empty($due_date) || empty($reading) || empty($previous) || empty($penalties) || empty($service) || empty($total)) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE tablebilling_list SET tableusers_id='$tableusers_id', reading_date='$reading_date', due_date='$due_date', reading='$reading', previous='$previous', penalties='$penalties', service='$service', total='$total', status='$status' WHERE id='$billing_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Record Updated Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Record Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}



if(isset($_GET['billing_id'])) {
    $billing_id = mysqli_real_escape_string($conn, $_GET['billing_id']);

    $query = "SELECT b.*, CONCAT(u.lname, ', ', u.fname, ' ', COALESCE(u.mname, '')) as `name` FROM tablebilling_list b INNER JOIN tableusers u ON b.tableusers_id = u.Id WHERE b.id='$billing_id'";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) == 1) {
        $billingRecord = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Record Fetch Successfully by id',
            'data' => $billingRecord,
            'homeowner' => ['name' => $billingRecord['name']] // Add homeowner's name to the response
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Record Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}


if (isset($_POST['delete_billing'])) {
    $billing_id = mysqli_real_escape_string($conn, $_POST['billing_id']);

    $query = "DELETE FROM tablebilling_list WHERE id='$billing_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $res = [
            'status' => 'success',
            'message' => 'Record Deleted Successfully'
        ];
    } else {
        $res = [
            'status' => 'error',
            'message' => 'Record Not Deleted'
        ];
    }

    // Check for DataTables request
    if (isset($_POST['draw'])) {
        header('Content-Type: application/json');
        echo json_encode(['data' => [$res]]);
    } else {
        echo json_encode($res);
    }
}

?>
