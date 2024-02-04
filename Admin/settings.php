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
      <div class="text"><i class="bx bx-cog"></i> Settings</div>

  <div class="card" style="margin: 10px;">
  <h5 class="card-header">Billing Management System</h5>
  <div class="card-body">
    <h3>Under Maintainance</h3>
    </div>
</div>
</section>