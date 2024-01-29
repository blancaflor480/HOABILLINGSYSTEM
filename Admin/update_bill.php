<?php
include 'config.php';
if (isset($_POST['update'])) {
  $tableusers_id = $_POST['tableusers_id'];
  $reading_date = $_POST['reading_date'];
  $due_date = $_POST['due_date'];
  $reading = $_POST['reading'];
  $previous = $_POST['previous'];
  $penalties = $_POST['penalties'];
  $service = $_POST['service'];
  $total = $_POST['total'];
  $status = $_POST['status'];

  $query = "UPDATE tablebilling_list SET 
      reading_date=?, 
      due_date=?, 
      reading=?, 
      previous=?, 
      penalties=?, 
      service=?, 
      total=?, 
      status=? 
      WHERE tableusers_id=?";
  
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ssssssssi", $reading_date, $due_date, $reading, $previous, $penalties, $service, $total, $status, $tableusers_id);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
      echo '<script> alert("Data Updated"); </script>';
  } else {
      echo '<script> alert("Data Not Updated: ' . $stmt->error . '"); </script>';
  }

  $stmt->close();
}
?>
