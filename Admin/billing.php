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
    font-size: 15px; /* Adjusted font size */
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
<div class="text"><i class="bi bi-receipt"></i>&nbsp;Billing</div>
    <div class="col-lg-12">
        <div class="card">
          <h5 class="card-header">List of Homeowners Bills
            <?php if ($type == 'Admin'): ?>
              <button type="button" class="btn btn-success float-right mx-2" data-toggle="modal" data-target="#addbills">
                <span class="bi bi-receipt"></span> Generate Bills
              </button>
              <a href="billing_transaction.php">
              <button type="button" class="btn btn-primary float-right" >
                <span class="bi bi-card-checklist"></span> Transaction
              </button>            
              </a>
              <div class="dropdown">
                   <button class="btn btn-secondary dropdown-toggle float-right" style="margin-top: -24px; margin-right: 8px;"  data-toggle="dropdown" aria-expanded="false">
              Select All
                 </button>
        <div class="dropdown-menu">
        <a href="billing.php" class="dropdown-item" style="font-size: 0.7rem;"><i class="bi bi-check-all"></i> All</button>    
        <a href="billing_pending.php" class="dropdown-item" style="font-size: 0.7rem;"><i class="bi bi-hourglass-split"></i> Pending</a>
        <a href="billing_paid.php" class="dropdown-item" style="font-size: 0.7rem;"><i class="bi bi-wallet"></i> Paid</a>          
      </div>
    </div>
              <?php endif; ?>
          </h5>
          <div class="card-body">
            <table class="table table-hover table-striped table-bordered" id="list">
              <thead>
                <tr>
                <th>Bills no.</th>  
                <th>Homeowner no.</th>
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
                  <td><?php echo $row['id']; ?></td>
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
                   <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            Select
        </a>
        <div class="dropdown-menu">
        <button class="dropdown-item view-bill" style="font-size: 0.7rem;" data-toggle="modal" data-target="#viewbills" data-user-id="<?= $row['tableusers_id'] ?>"><i class="bi bi-eye"></i> View</button>    
        <button class="dropdown-item update-bill" style="font-size: 0.7rem;" data-toggle="modal" data-target="#editbills" data-user-id="<?= $row['tableusers_id'] ?>"><i class="bx bx-edit"></i> Edit</button>
            <form method="post">
                <button class="dropdown-item"  name="delete" value="' . $result['Id'] . '" type="submit" style="font-size: 0.7rem;">
                <span class="bi bi-trash "></span> Delete</button>
            </form>
        </div>
    </div>
                    </td>
                  </tr>
                  <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
   
</section>
<!--< ?php
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
?>-->


<!--<script>
$(document).ready(function () {
  // Initialize DataTable
  $('#list').DataTable({
    "pagingType": "full_numbers",
    "lengthMenu": [5, 10, 25, 50, 75, 100],
    "pageLength": 10,
    "order": [[1, 'desc']],
  });

  // Handle click event for "View" button
  $('#list').on('click', '.view-bill', function () {
    var tableusers_id = $(this).data('user-id');

    // Make an AJAX request to fetch bill details for the selected user
    $.ajax({
      url: 'fetch_bill_details.php',
      method: 'GET',
      data: { tableusers_id: tableusers_id },
      success: function (response) {
        try {
          // Log the raw response to the console for debugging
          console.log('Raw JSON response:', response);

          // Parse the JSON response
          var data = JSON.parse(response);

          // Log the parsed data to the console for debugging
          console.log('Parsed JSON data:', data);

          // Check if there is an error
          if (data.error) {
            alert(data.error);
            return;
          }

          // Update the modal content with the fetched bill details
          $('#viewbills .modal-body #name').val(data.tableusers_id);
          $('#viewbills .modal-body #readingDueDate').val(data.reading_date);
          $('#viewbills .modal-body #duedate').val(data.due_date);
          $('#viewbills .modal-body #current').val(data.reading);
          $('#viewbills .modal-body #previousBalance').val(data.previous);
          $('#viewbills .modal-body #service').val(data.service);
          $('#viewbills .modal-body #penalties').val(data.penalties);
          $('#viewbills .modal-body #total').val(data.total);
          $('#viewbills .modal-body #status').val(data.status);
          
          // Update the modal content with the fetched bill details
          $('#editbills .modal-body #name').val(data.tableusers_id);
          $('#editbills .modal-body #readingDueDate').val(data.reading_date);
          $('#editbills .modal-body #duedate').val(data.due_date);
          $('#editbills .modal-body #current').val(data.reading);
          $('#editbills .modal-body #previousBalance').val(data.previous);
          $('#editbills .modal-body #service').val(data.service);
          $('#editbills .modal-body #penalties').val(data.penalties);
          $('#editbills .modal-body #total').val(data.total);
          $('#editbills .modal-body #status').val(data.status);
          
          // ... update other fields similarly
          // Show the modal
          $('#viewbills').modal('show');
        } catch (error) {
          console.error('Error parsing JSON response:', error);
         }
      },
      error: function () {
        // Handle errors if any
        alert('Error fetching bill details.');
      }
      
    });
  });
});

</script>-->

<script>
  $(document).ready(function () {
  // Initialize DataTable
  $('#list').DataTable({
    "pagingType": "full_numbers",
    "lengthMenu": [5, 10, 25, 50, 75, 100],
    "pageLength": 10,
    "order": [[1, 'desc']],
  });

  // Handle click event for "View" button
  $('#list').on('click', '.view-bill', function () {
    var tableusers_id = $(this).data('user-id');

    // Make an AJAX request to fetch bill details for the selected user
    $.ajax({
      url: 'fetch_bill_details.php',
      method: 'GET',
      data: { tableusers_id: tableusers_id },
      success: function (response) {
        try {
          // Parse the JSON response
          var data = JSON.parse(response);

          // Check if there is an error
          if (data.error) {
            alert(data.error);
            return;
          }

          // Update the modal content with the fetched bill details
          $('#viewbills .modal-body #name').val(data.tableusers_id);
          $('#viewbills .modal-body #readingDueDate').val(data.reading_date);
          $('#viewbills .modal-body #duedate').val(data.due_date);
          $('#viewbills .modal-body #current').val(data.reading);
          $('#viewbills .modal-body #previousBalance').val(data.previous);
          $('#viewbills .modal-body #service').val(data.service);
          $('#viewbills .modal-body #penalties').val(data.penalties);
          $('#viewbills .modal-body #total').val(data.total);
          $('#viewbills .modal-body #status').val(data.status);

          // Show the modal
          $('#viewbills').modal('show');
        } catch (error) {
          console.error('Error parsing JSON response:', error);
        }
      },
      error: function () {
        // Handle errors if any
        alert('Error fetching bill details.');
      }
    });
  });

  // Handle click event for "Update" button in the edit modal
  $('#editbills').on('click', '.update-bill', function () {
    var formData = $('#editbills-form').serialize();

    // Make an AJAX request to update the bill details
    $.ajax({
      url: 'update_bill.php',
      method: 'GET',
      data: { tableusers_id: tableusers_id },
      success: function (response) {
    try {
        var data = JSON.parse(response);

        if (data.status === 'success') {
            // Update the modal content with the fetched bill details
            $('#editbills .modal-body #name').val(data.data.tableusers_id);
            $('#editbills .modal-body #readingDueDate').val(data.data.reading_date);
            $('#editbills .modal-body #duedate').val(data.data.due_date);
            $('#editbills .modal-body #current').val(data.data.reading);
            $('#editbills .modal-body #previousBalance').val(data.data.previous);
            $('#editbills .modal-body #service').val(data.data.service);
            $('#editbills .modal-body #penalties').val(data.data.penalties);
            $('#editbills .modal-body #total').val(data.data.total);
            $('#editbills .modal-body #status').val(data.data.status);

            // Show the modal
            $('#editbills').modal('show');
        } else {
            // Handle errors
            alert(data.message);
        }
    } catch (error) {
        console.error('Error parsing JSON response:', error);
    }
},
      error: function () {
        // Handle errors if any
        alert('Error updating bill details.');
      }
    });
  });
});

</script>
<?php include('Addbills.php'); ?>
<?php include('view_bills.php'); ?>
<?php include('edit_bills.php'); ?>
<?php include('Delete_Account.php'); ?>
