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
<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
.viewBillingBtn,
.editBillingBtn,
.deleteBillingBtn {
    font-size: 11px; /* Adjust the font size as needed */
    padding: 2px 5px; /* Adjust the padding as needed */
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
    <div class="text"><i class="bi bi-receipt"></i>&nbsp;Billing</div>
    <div class="col-lg-12">
        <div class="card">
            <h5 class="card-header">List of Homeowners Bills
                <?php if ($type == 'Admin'): ?>
            <button type="button" class="btn btn-success float-right mx-2" data-toggle="modal" data-target="#addbills">
                        <span class="bi bi-receipt"></span> Generate Bills
                    </button>

                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle float-right" style="margin-top: -24px; margin-right: 8px;" data-toggle="dropdown" aria-expanded="false">
                            Select All
                        </button>
                        <div class="dropdown-menu">
                            <a href="billing.php" class="dropdown-item" style="font-size: 0.7rem;"><i class="bi bi-check-all"></i> All</a>
                            <a href="billing_pending.php" class="dropdown-item" style="font-size: 0.7rem;"><i class="bi bi-hourglass-split"></i> Pending</a>
                             <a href="billing_unpaid.php" class="dropdown-item" style="font-size: 0.7rem;"><i class="bi bi-wallet"></i> Unpaid</a>
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
    <?php
    require 'config.php';

    $query = "SELECT b.*, CONCAT(c.lname, ', ', c.fname, ' ', COALESCE(c.mname, '')) AS name
          FROM `tablebilling_list` b 
          INNER JOIN tableusers c ON b.tableusers_id = c.id
          ORDER BY UNIX_TIMESTAMP(b.reading_date) DESC, name ASC";

    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $billingRecord) {
            ?>
            <tr>
                <td><?= $billingRecord['id']; ?></td>
                <td><?= $billingRecord['tableusers_id']; ?></td> <!-- Change this to $billingRecord['name']; -->
                <td><?= date("Y-m-d", strtotime($billingRecord['reading_date'])); ?></td>
                <td><?= date("Y-m-d", strtotime($billingRecord['due_date'])); ?></td>
                <td><?= $billingRecord['name']; ?></td> <!-- Display homeowner's name -->
                <td>
                    <?php
                    switch ($billingRecord['status']) {
                        case 0:
                                            echo '<span class="badge badge-danger  bg-gradient-danger text-lg px-3">
                                                UNPAID</span>';
                                            break;
                                        case 1:
                                            echo '<span class="badge badge-success  bg-gradient-success text-lg px-3">
                                                PAID</span>';
                                            break;
                                        case 2:
                                            echo '<span class="badge badge-warning  bg-gradient-warning text-lg px-3">
                                                PENDING</span>';
                                            break;
                    }
                    ?>
                </td>
                <td><b><?= $billingRecord['total']; ?><b></td>
                <td>
        

        <button type="button" value="<?= $billingRecord['id']; ?>" class="viewBillingBtn btn btn-primary btn-sm" data-toggle="modal" data-target="#billingViewModal"><i class="bi bi-eye"></i> View</button>
    
<a href="edit_bills.php?tableusers_id=<?= $billingRecord['tableusers_id']; ?>" class="editBillingBtn btn btn-success"><i class="bi bi-pencil-square"></i> Edit</a>

                    <button type="button" value="<?= $billingRecord['id']; ?>" class="deleteBillingBtn btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                </td>
            </tr>
        <?php
    }
}
?>
</tbody>

                </table>
            </div>
        </div>
    </div>
</section>
<?php include('modal.php'); ?>

<script>
  $(document).ready(function () {
  // Initialize DataTable
  $('#list').DataTable({
    "pagingType": "full_numbers",
    "lengthMenu": [5, 10, 25, 50, 75, 100],
    "pageLength": 10,
    "order": [[1, 'desc']],
  });

//$(document).on('click', '.editBillingBtn', function () {
  //  var billing_id = $(this).val();
    //$.ajax({
      //  type: "GET",
        //url: "action.php?billing_id=" + billing_id,
        ///success: function (response) {
           // var res = jQuery.parseJSON(response);
            //if (res.status == 404) {
              //  alertify.error(res.message);
            //} else if (res.status == 200) {
               // $('#billing_id').val(res.data.id);

                // Fetch homeowner's name using the tableusers_id
//                var homeowner = res.homeowner;
                // Check if the homeowner object exists and has the required properties
  //              if (homeowner && homeowner.name) {
      //              var homeownerId = res.data.tableusers_id; // Use the actual Id value instead of the name
    //                var homeownerName = homeowner.name;

                    // Set the selected option in the dropdown
        //            $('#tableusers_id').val(homeownerId);

                    // Display homeowner's name in the modal
          //          $('#tableusers_id').attr('data-selected', homeownerName);
            //    } else {
                    // If the homeowner name is not available, you may want to display a default value or handle it accordingly
              //      $('#tableusers_id').val('N/A');
                //}

                // Populate other fields
               /// $('#reading_date').val(res.data.reading_date);
               // $('#due_date').val(res.data.due_date);
                //$('#reading').val(res.data.reading);
                //$('#previous').val(res.data.previous);
               // $('#penalties').val(res.data.penalties);
               /// $('#service').val(res.data.service);
               // $('#total').val(res.data.total);
                //$('#status').val(res.data.status);

                //$('#billingEditModal').modal('show');
            //}
        //},
        //error: function (xhr, status, error) {
          ///  console.error(xhr.responseText);
       // }
    //});
//});

///$(document).on('submit', '#updateBilling', function (e) {
   // e.preventDefault();
    //var formData = new FormData(this);
   // formData.append("update_billing", true);
    //$.ajax({
    //    type: "POST",
     //   url: "action.php",
       // data: formData,
      //  processData: false,
      //  contentType: false,
      //  success: function (response) {
        //    var res = jQuery.parseJSON(response);
        //    if (res.status == 422) {
          //      $('#errorMessageUpdate').removeClass('d-none');
          //      $('#errorMessageUpdate').text(res.message);
         //   } else if (res.status == 200) {
 //               $('#errorMessageUpdate').addClass('d-none');

                // Redirect to billing.php after updating successfully
   //             window.location.href = 'billing.php';

                // Hide modal and reset form
     //           $('#billingEditModal').modal('hide');
       //         $('#updateBilling')[0].reset();

                // Reload the DataTable (optional, remove if not needed)
         //       $('#myTable').DataTable().ajax.reload();
        //    } else if (res.status == 500) {
  //              alert(res.message);
          //  }
      //  }
 //   });
//});


$(document).on('click', '.viewBillingBtn', function () {
    var billing_id = $(this).val();
    $.ajax({
        type: "GET",
        url: "action.php?billing_id=" + billing_id,
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {
                alertify.error(res.message);
            } else if (res.status == 200) {
                // Fetch homeowner's name using the tableusers_id
                var homeowner = res.homeowner;

                // Check if the homeowner object exists and has the required properties
                if (homeowner && homeowner.name) {
                    var homeownerName = homeowner.name;

                    // Display homeowner's name in the modal
                    $('#view_tableusers_id').text(homeownerName);
                } else {
                    $('#view_tableusers_id').text('N/A'); // Set a default value if data is not as expected
                }

                // Other fields remain the same
                $('#view_reading_date').text(res.data.reading_date);
                $('#view_due_date').text(res.data.due_date);
                $('#view_reading').text(res.data.reading);
                $('#view_previous').text(res.data.previous);
                $('#view_penalties').text(res.data.penalties);
                $('#view_service').text(res.data.service);
                $('#view_total').text(res.data.total);

                // Display "Pending" or "Paid" based on the value
                var statusText = (res.data.status == 0) ? "Pending" : "Paid";
                $('#view_status').text(statusText);

                $('#billingViewModal').modal('show');
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

    $(document).on('click', '.deleteBillingBtn', function (e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this record?')) {
            var billing_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "action.php",
                data: {
                    'delete_billing': true,
                    'billing_id': billing_id
                },
                success: function (response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 500) {
                        alert(res.message);
                    } else {
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.success(res.message);
                        $('#list').load(location.href + " #list");
                    }
                }
            });
        }
    });
});

</script>

