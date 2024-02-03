<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    die();
}

include 'config.php';

$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT * FROM tableusers WHERE email = ?");
$stmt->bind_param("s", $email);
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
        <button type="button" class="btn btn-primary float-right mx-2" data-toggle="modal" data-target="#AddComplaint">
          <span class="bx bx-plus"></span> New Complaint              
        </button>
      </h5>
      <div class="card-body">
        <table class="table table-hover table-striped table-bordered" id="list">
          <thead>
            <tr>
              <th>Complaint #</th>
              <th>Date Time</th>
              <th>Type of Complaint</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $qry = $conn->prepare("SELECT Id, tableusers_id, email, typecomplaint, description, status, date_time FROM `tablecomplaint` WHERE `tableusers_id` = ?");
$qry->bind_param("i", $result['Id']);
$qry->execute();
$qry->bind_result($complaintId, $tableusers_id, $email, $typecomplaint, $description, $status, $date_time);

while ($qry->fetch()) {
?>
    <tr>
        <td><?= $complaintId; ?></td>
        <td><?= $date_time; ?></td>
        <td><?= $typecomplaint; ?></td>
        <td>
        <?php
switch ($status) {
    case 0:
        $badge = '<span class="badge badge-danger bg-gradient-danger text-lg px-3">UNPROCESS</span>';
        break;
    case 1:
        $badge = '<span class="badge badge-success bg-gradient-success text-lg px-3">PROCESS</span>';
        break;
    case 2:
        $badge = '<span class="badge badge-warning bg-gradient-warning text-lg px-3">PENDING</span>';
        break;
    default:
        $badge = ''; // Add a default case if needed
}

echo $badge;
?>
</td>

            </tr>
<?php
}
?>

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
      "order": [
        [1, 'desc']
      ],
    });
  });
</script>

<?php include('Add_Complaint.php'); ?>
