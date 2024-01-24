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
<!--<i class="bi bi-receipt"></i>-->
<section class="home-section">
<div class="text"><i class="bi bi-receipt"></i>&nbsp;Transaction</div>
    <div class="col-lg-12">
        <div class="card">
          <h5 class="card-header">List of Homeowners Bills
            <?php if ($type == 'Admin'): ?>
              <button type="button" class="btn btn-success float-right mx-2" data-toggle="modal" data-target="#addbills">
                <span class="bi bi-receipt"></span> Create New Bills
              </button>
              <a href="billing.php">
              <button type="button" class="btn btn-primary float-right" >
                <span class="bi bi-card-checklist"></span> Bills
              </button>
              </a>
              <?php endif; ?>
          </h5>
          <div class="card-body">
            <table class="table table-hover table-striped table-bordered" id="list">
              <thead>
                <tr>
                <th>Customer no.</th>
                  <th>Reading Date</th>
                  <th>Due Date</th>
                  <th>Full name</th>
                  <th>Status</th>
                  <th>Amount</th>
				          <th>Action</th>
                </tr>
              </thead>
              <tbody>
               <!--< ?php
                  $result = mysqli_query($conn, "SELECT * FROM tablebilling_list ORDER BY tableusers_id ASC") or die(mysqli_error());
                  while ($row = mysqli_fetch_array($result)) {
                    $tableusers_id = $row['tableusers_id'];
                ?>-->
                <?php 
					$i = 1;
						$qry = $conn->query("SELECT b.*, concat(c.lname, ', ', c.fname, ' ', coalesce(c.mname,'')) as
             `name` from `tablebilling_list` b inner join 
             tableusers c on b.tableusers_id = c.id 
             order by unix_timestamp(`reading_date`) desc, `name` asc ");
						while($row = $qry->fetch_assoc()):
					?>
					
                  <tr>
                    <td><?php echo $row['tableusers_id']; ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['reading_date'])); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row['due_date'])); ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                    <?php
								  switch($row['status']){
									case 0:
										echo '<span class="badge badge-secondary  bg-gradient-secondary  text-lg px-2 ">Pending</span>';
										break;
									case 1:
										echo '<span class="badge badge-success bg-gradient-success text-sm px-3 ">Paid</span>';
										break;
								}
								?>
                    </td>
                    <td><?php echo $row['total']; ?></td>
                   
                    <td>
                    <div class="dropdown">
        <a class="btn btn-warning" href="#" role="button">
        <i class="bi bi-eye"></i> View
        </a>
            </form>
        </div>
    </div>
                    </td>
                  </tr>
                  <?php endwhile; ?>
 <!--               < ?php } ?>-->
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

<?php include('Addbills.php'); ?>

