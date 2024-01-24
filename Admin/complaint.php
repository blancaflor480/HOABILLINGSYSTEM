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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["response"])) {
    // Handle the response button click, update the complaint status, etc.
    $complaintId = $_POST["complaintId"]; // Assuming you have a hidden input in your form with the complaintId
    // Perform the update query based on the complaintId
    $updateQuery = "UPDATE tablecomplaint SET status = 'Processed' WHERE Id = $complaintId";
    mysqli_query($conn, $updateQuery);
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
<div class="text">Complaint</div>
    <div class="col-lg-12">
        <div class="card">
          <h5 class="card-header">List of Customer Complaint
            <?php if ($type == 'Admin'): ?>
              <button type="button" class="btn btn-primary float-right mx-2" data-toggle="modal" data-target="#Add_account">
                <span class="bx bx-printer"></span> Print              
            </button>
              <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#delete_account">
                <span class="bx bx-archive"></span> Archive
              </button>
            <?php endif; ?>
          </h5>
          <div class="card-body">
            <table class="table table-hover table-striped table-bordered" id="list">
              <thead>
                <tr>
                  <th>Complaint #</th>
                  <th>Date Time</th>
                  <th>Full name</th>
                  <th>Complaint</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php 
					$i = 1;
						$qry = $conn->query("SELECT b.*, concat(c.lname, ', ', c.fname, ' ', coalesce(c.mname,'')) as
             `name` from `tablecomplaint` b inner join 
             tableusers c on b.tableusers_id = c.id 
             order by unix_timestamp(`date_time`) desc, `name` asc ");
						while($row = $qry->fetch_assoc()):
					?>
                  <tr>
                    <td><?php echo $row['Id']; ?></td>
                    <td><?php echo date("Y-m-d H:i", strtotime($row['date_time'])); ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                    <form method="post">
                                    
                     <button class="btn btn-success"  name="complaintId" value="<?php echo $row['Id']; ?>" type="submit">Response</button>  
                                      </form>
                  </td>
                  </tr>
                <?php endwhile ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
   
</section>

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
