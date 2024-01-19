
 <?php
session_start();
include('config.php');
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
    font-size: 0.9rem;/* Adjusted font size */
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
<div class="text"><i class="bi bi-people"></i> Customer</div>
    <div class="col-lg-12">
        <div class="card">
          <h5 class="card-header">List of Customer
            <?php if ($type == 'Admin'): ?>
              <button type="button" class="btn btn-success float-right mx-2" data-toggle="modal" data-target="#Addcustomer">
                <span class="bx bx-user-plus"></span> Create New Customer
              </button>
              <button type="button" class="btn btn-warning float-right mx-2" data-toggle="modal" data-target="#delete_account">
                <span class="bx bx-archive"></span> Archive
              </button>
              <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#delete_account">
                <span class="bx bx-printer"></span> Print
              </button>
            <?php endif; ?>
          </h5>
          <div class="card-body">
            <table class="table table-hover table-striped table-bordered" id="list">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date Created</th>
                  <th>Profile</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $result = mysqli_query($conn, "SELECT * FROM tableusers ORDER BY id ASC") or die(mysqli_error());
                  while ($row = mysqli_fetch_array($result)) {
                    $id = $row['id'];
                ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo date("Y-m-d H:i", strtotime($row['datereg'])); ?></td>
                    <td>
                      <?php if ($row['image'] != ""): ?>
                        <img src="<?php echo $row['image']; ?>" alt="Profile Image">
                      <?php else: ?>
                        <img src="images/users.png" alt="Default Image">
                      <?php endif; ?>
                    </td>
                    <td><?php echo $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td>
                    <div class="dropdown">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Select
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="Edit_User.php?<?php echo 'id=' . $id; ?>"><i class="bx bx-edit"></i> Edit</a>
            <!-- Use a form for deletion -->
            <form method="post">
                <button class="dropdown-item"  name="delete" value="' . $result['Id'] . '" type="submit" style="font-size: 0.9rem;"><i class="bx bx-trash"></i> Delete</button>
            </form>
        </div>
    </div>
                    </td>
                  </tr>
                <?php } ?>
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
        $archiveQuery = "INSERT INTO tableaccount_archive SELECT * FROM tableusers WHERE Id = '$buttonValue'";
        $archiveResult = mysqli_query($conn, $archiveQuery);
        
        // Update the status to 'Offline'
        $updateQuery = "UPDATE tableusers SET status='Offline' WHERE Id = '$buttonValue'";
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
<?php include('Add_customer.php'); ?>
