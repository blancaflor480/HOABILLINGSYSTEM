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

?>

<?php include('Sidebar.php'); ?>
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
             <button type="button" class="btn btn-primary float-right mx-2" data-toggle="modal" data-target="#Add_account">
                <span class="bx bx-plus"></span> New Complaint              
            </button>
             <!-- <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#delete_account">
                <span class="bx bx-archive"></span> Archive
              </button>-->
            </h5>
          <div class="card-body">
            <table class="table table-hover table-striped table-bordered" id="list">
              <thead>
                <tr>
                  <th>Complaint #</th>
                  <th>Date Time</th>
                  <th>Complaint</th>
                  <th>Status</th>
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
                    <td><?php echo $row['message']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                  </tr>
                <?php endwhile ?>
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

