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
    <div class="text"><i class="bi bi-receipt"></i>&nbsp;History Transaction</div>
    <div class="col-lg-12">
        <div class="card">
            <h5 class="card-header">List of Homeowners Bills
               
            
                    <a href="history_transaction.php">
                        <button type="button" style="margin-left: 5px;" class="btn btn-danger float-right">
                            <span class="bi bi-card-checklist"></span> History
                        </button>
                    </a>
                    <a href="billing_transaction.php">
                        <button type="button"  class="btn btn-primary float-right">
                            <span class="bi bi-card-checklist"></span> Transaction
                        </button>
                    </a>

                     <div class="dropdown"  aria-label="Filter by Status" >
                        <button class="btn btn-secondary dropdown-toggle float-right" style="margin-top: -24px; margin-right: 8px;"data-toggle="dropdown" aria-expanded="false">
                            Select payment 
                        </button>
                       <div class="dropdown" aria-label="Filter by Payment Mode">
    <div class="dropdown-menu">
        <a type="button" class="filter-btn dropdown-item" data-mode="all" style="font-size: 0.7rem;">
            <i class="bi bi-check-all"></i> All
        </a>
        <a type="button" class="filter-btn dropdown-item" data-mode="walk in" style="font-size: 0.7rem;">
            <i class="bi bi-wallet"></i> Walk-in
        </a>
        <a type="button" class="filter-btn dropdown-item" data-mode="online" style="font-size: 0.7rem;">
            <i class="bi bi-wallet"></i> Online Payment
        </a>
    </div>
</div>
          
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
                            <th>Payment Mode</th>
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
          WHERE b.status = 0 OR b.status = 1 OR b.status = 2
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
                    switch ($billingRecord['paymode']) {
                        case 0:
                            echo '<div class="text-lg" Style="font-size: 0.9rem;  font-weight: 500;">Walk in</div>';
                            break;
                        case 1:
                            echo '<div class="text-lg" Style="font-size: 0.9rem;  font-weight: 500;">Online payment</div>';
                            break;
                    }
                    ?>
                </td>
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
                                            default:
                                            echo '<span class="badge badge-info bg-gradient-info text-lg px-3">UNKNOWN STATUS</span>';
                                            break;
                    }
                    ?>
                </td>
                <td><b><?= $billingRecord['total']; ?><b></td>
                <td>
        

        <button type="button" value="<?= $billingRecord['id']; ?>" class="viewBillingBtn btn btn-primary btn-sm" data-toggle="modal" data-target="#billingViewModal"><i class="bi bi-eye"></i> View</button>
    

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
function applyModeFilter(mode) {
        var table = $('#list').DataTable();

        if (mode === 'all') {
            // Show all rows
            table.columns(5).search('').draw();
        } else {
            // Filter by payment mode column (assuming payment mode column is at index 5)
            table.columns(5).search(mode).draw();
        }
    }

    $('.filter-btn').on('click', function () {
        var modeFilter = $(this).data('mode');
        applyModeFilter(modeFilter);
    });



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
                $('#view_amountpay').text(res.data.amountpay);
                

                // Display "Pending" or "Paid" based on the value
                var statusText;
if (res.data.status == 0) {
    statusText = "Unpaid";
} else if (res.data.status == 1) {
    statusText = "Paid";
} else {
    statusText = "Pending";
}

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

