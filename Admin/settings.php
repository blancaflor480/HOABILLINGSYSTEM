<?php
session_start();
include('Sidebar.php');

if (isset($_SESSION['uname'])) {
    $uname = $_SESSION['uname'];
} else {
    // Handle the case when the session variable is not set, redirect or show an error.
    header("Location: index.php");
    exit();
}

$query  = mysqli_query($conn, "SELECT * FROM tableaccount WHERE uname = '$uname'") or die(mysqli_error());
$row = mysqli_fetch_array($query);
$type  = $row['type'];
?>


<section class="home-section">
      <div class="text">Settings</div>

  <div class="card" style="margin: 10px;">
  <h5 class="card-header">Billing Management System</h5>
  <div class="card-body">
    <h5 class="card-title">Back up & Restore</h5>
    <p class="card-text" style="width: 900px">Our backup and restore feature provides a robust solution to safeguard your valuable data, allowing you to create secure copies of your information at regular intervals.</p>
    <button class="btn btn-success">Export file</button>
    <button class="btn btn-warning">Import file</button>
    </div>
</div>
</section>