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

  .notification {
    position: fixed;
    top: 1%;
    left: 50%;
    transform: translateX(-50%);
    padding: 10px;
    background-color: #28a745;
    color: #fff;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.notification .icon {
    margin-right: 10px;
}

.notification.success {
    background-color: #28a745;
}

.notification.error {
    background-color: #dc3545;
}
</style>

<section class="home-section">
<div class="text"><i class="bx bx-envelope"></i> Complaint</div>
    <div class="col-lg-12">
        <div class="card">
          <h5 class="card-header">List of Customer Complaint
            <?php if ($type == 'Admin'): ?>
              <button type="button" class="btn btn-primary float-right mx-2" data-toggle="modal" data-target="#Add_account">
                <span class="bx bx-printer"></span> Print              
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
                    <td>
                       <?php
switch ($row['stats']) {
    case 0:
        $badge = '<span class="badge badge-danger bg-gradient-danger text-lg px-3">UNPROCESS</span>';
        break;
    case 1:
        $badge = '<span class="badge badge-success bg-gradient-success text-lg px-3">PROCESS</span>';
        break;
    case 2:
        $badge = '<span class="badge badge-warning bg-gradient-warning text-lg px-3">PENDING</span>';
        break;
    
}

echo $badge;
?>

                    </td>
                    <td>
    
        <!-- Add the View button with a data-toggle attribute for the modal -->
        <button class="btn btn-warning view-btn" data-toggle="modal" data-target="#viewComplaintModal" data-complaint-id="<?php echo $row['Id']; ?>">View</button>

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
<!-- Modal for Viewing Complaint Details -->
<div class="modal fade" id="viewComplaintModal" tabindex="-1" role="dialog" aria-labelledby="viewComplaintModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewComplaintModalLabel">View Complaint Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display complaint details here -->
                <div id="complaintDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" value="1" class="btn btn-success">Process</button>
                <button type="submit" value="2" class="btn btn-warning">Pending</button>
            </div>
        </div>
    </div>
</div>
<script>
    var complaintId; // Declare the variable globally

    // Function to load complaint details
    function loadComplaintDetails(id) {
        $.ajax({
            url: 'get_complaint_details.php',
            type: 'GET',
            data: { complaintId: id },
            success: function (response) {
                $('#complaintDetails').html(response);
                $('#viewComplaintModal').modal('show');
            },
            error: function () {
                alert('Error fetching complaint details.');
            }
        });
    }

 // Function to show a temporary notification
function showNotification(message, type) {
    var notification = $('<div class="notification ' + type + '">').text(message);
    $('body').append(notification);

    notification.fadeIn('fast', function () {
        setTimeout(function () {
            notification.fadeOut('fast', function () {
                notification.remove();
            });
        }, 2000);
    });
}



    // Function to handle Processed and Pending button clicks
    function handleButtonClicked(status) {
        // Use AJAX to update the complaint status
        $.ajax({
            url: 'update_complaint_details.php',
            type: 'POST',
            data: { complaintId: complaintId, stats: status },
            success: function (response) {
                showNotification(response);
                $('#viewComplaintModal').modal('hide');
            },
             error: function () {
            // Display error notification
            showNotification('Error updating complaint status.', 'error');
          }
        });
    }

    // Handle View button click
    $('.view-btn').click(function () {
        complaintId = $(this).data('complaint-id');
        loadComplaintDetails(complaintId);
    });

    // Handle Processed button click
    $('#viewComplaintModal .btn-success').click(function () {
        handleButtonClicked(1);
    });

    // Handle Pending button click
    $('#viewComplaintModal .btn-warning').click(function () {
        handleButtonClicked(2);
    });

    // Periodically refresh the data every 5 seconds
    setInterval(function () {
        loadComplaintDetails(complaintId);
    }, 1000); // Adjust the interval as needed
</script>

<?php include('Add_account.php'); ?>
<?php include('Delete_Account.php'); ?>
