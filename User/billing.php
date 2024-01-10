<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: index.php?error=Login%20First");
        die();
    }

    include 'config.php';

	$email = $_SESSION['email'];
	$conn_String = mysqli_connect("localhost", "root", "", "billing");
	$stmt = $conn_String->prepare("SELECT * FROM tableusers WHERE email = '{$_SESSION['email']}'");
	$stmt->execute();
	$result = $stmt->get_result()->fetch_assoc();
	
	if (!$result) {
		header("Location: index.php?error=Login%20First");
		exit();
	}


//    $query = mysqli_query($conn, "SELECT * FROM tableusers WHERE email='{$_SESSION['SESSION_EMAIL']}'");

  //  if (mysqli_num_rows($query) > 0) {
    //    $row = mysqli_fetch_assoc($query);

       // echo "Welcome " . $row['fname'] . " <a href='logout.php'>Logout</a>";
    //}
?>
<?php include('Sidebar.php');?>

<!-- Include these links to the head section of your HTML -->
<link rel="stylesheet" type="text/css" href="DataTables-1.13.8/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/js/jquery.dataTables.js"></script>

<style>
  .card {
    margin: 0px;
  }

  .table th,
  .table td {
    text-align: center;
    vertical-align: middle;
    font-size: 14px; /* Adjusted font size */
  }

  .table img {
    max-width: 80px;
    max-height: 80px;
    border: 4px groove #CCCCCC;
    border-radius: 5px;
  }

  .dropdown-menu a {
    cursor: pointer;
    font-size: 12px; /* Adjusted font size */
  }

  .dropdown-menu a:hover {
    background-color: #f8f9fa !important;
  }

  .btn {
    font-size: 12px; /* Adjusted font size */
  }

  /* Adjusted font size for DataTable controls */
  .dataTables_length,
  .dataTables_filter,
  .dataTables_info,
  .paginate_button {
    font-size: 12px;
  }

  /* Adjusted font size for pagination buttons */
  .paginate_button.previous, .paginate_button.next {
    font-size: 12px;
  }
</style>

<section class="home-section">
<div class="text">Billing</div>
    <div class="col-lg-12">
        <div class="card">
          <h5 class="card-header">Dues Bills
              <button type="button" class="btn btn-primary float-right mx-2" data-toggle="modal" data-target="#Add_account">
                <span class="bi bi-receipt"></span> History Transaction
              </button>
              <a class="btn btn-warning float-right" href="complaint.php">
                <span class="bx bx-envelope"></span> Compalint
              </a>
           </h5>
          <div class="card-body">
            <table class="table table-hover table-striped table-bordered" id="list">
              <thead>
                <tr>
                  <th>Bill no.</th>
                  <th>Reading Date</th>
                  <th>Due Date</th>
                  <th>Unit Comsumption</th>
                  <th>Status</th>
                  <th>Amount</th>
				          <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <!--< ?php
                  $result = mysqli_query($conn, "SELECT * FROM tableaccount ORDER BY Id ASC") or die(mysqli_error());
                  while ($row = mysqli_fetch_array($result)) {
                    $Id = $row['Id'];
                ?>-->
                  <!--<tr>
                    <td>< ?php echo $row['Id']; ?></td>
                    <td>< ?php echo date("Y-m-d H:i", strtotime($row['date_created'])); ?></td>
                    <td>
                      < ?php if ($row['image'] != ""): ?>
                        <img src="uploads/< ?php echo $row['image']; ?>" alt="Profile Image">
                      < ?php else: ?>
                        <img src="images/users.png" alt="Default Image">
                      < ?php endif; ?>
                    </td>
                    <td>< ?php echo $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']; ?></td>
                    <td>< ?php echo $row['email']; ?></td>
                    <td>< ?php echo $row['type']; ?></td>
                    <td>
                    <div class="dropdown">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Select
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="Edit_Account.php?< ?php echo 'Id=' . $Id; ?>"><i class="bx bx-edit"></i> Edit</a>
            <form method="post">
                <button class="dropdown-item"  name="delete" value="' . $result['Id'] . '" type="submit"><span class="fa fa-trash text-danger"></span> Delete</button>
            </form>
        </div>
    </div>
                    </td>
                  </tr>
                <--< ?php } ?>-->
              </tbody>
            </table>
          </div>
        </div>
      </div>
   
</section>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $buttonValue = $_POST['delete'];
        // Move the record to the archive table
        $archiveQuery = "INSERT INTO tableaccount_archive SELECT * FROM tableaccount WHERE Id = '$buttonValue'";
        $archiveResult = mysqli_query($conn, $archiveQuery);
        
        // Update the status to 'Offline'
        $updateQuery = "UPDATE tableaccount SET status='Offline' WHERE Id = '$buttonValue'";
        $updateResult = mysqli_query($conn, $updateQuery);
        
        if ($archiveResult && $updateResult) {
            echo '<script>setTimeout(function() { window.location.href = "account.php"; }, 10);</script>';
        }
    }
}
?>

<script>
  $(document).ready(function () {
    $('#list').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [5, 10, 25, 50, 75, 100],
      "pageLength": 10,
      "order": [[1, 'desc']],
    });
  });
</script>

<?php include('Add_account.php'); ?>
<?php include('Delete_Account.php'); ?>
