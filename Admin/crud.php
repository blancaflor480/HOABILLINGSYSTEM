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
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">

 <link rel="stylesheet" type="text/css" href="DataTables-1.13.8/css/jquery.dataTables.css">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />


<section class="home-section">
      <div class="text">Dashboard</div>
    




<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Billing List
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#billingAddModal">
                            Add Record
                        </button>
                    </h4>
                </div>
                <div class="card-body">

                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Homeowners ID</th>
                            <th>Name</th>
                            <th>Reading Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        require 'config.php';

                        
                        $query = "SELECT b.*, concat(c.lname, ', ', c.fname, ' ', coalesce(c.mname,'')) as
                           `name` from `tablebilling_list` b inner join 
                            tableusers c on b.tableusers_id = c.id
                            order by unix_timestamp(`reading_date`) desc, `name` asc ";
                
                        $query_run = mysqli_query($conn, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            foreach($query_run as $billingRecord)
                            {
                                ?>
                                <tr>
                                    <td><?= $billingRecord['id'] ?></td>
                                    <td><?= $billingRecord['tableusers_id'] ?></td>
                                    <td><?= $billingRecord['name'] ?></td>
                                    <td><?= $billingRecord['reading_date'] ?></td>
                                    <td><?= $billingRecord['due_date'] ?></td>
                                    <td><?= $billingRecord['status'] ?></td>
                                    <td>
                            <button type="button" value="<?= $billingRecord['id']; ?>" class="viewBillingBtn btn btn-info btn-sm" data-toggle="modal" data-target="#billingViewModal">View</button>
                             <button type="button" value="<?= $billingRecord['id']; ?>" class="editBillingBtn btn btn-success btn-sm" data-toggle="modal" data-target="#billingEditModal">Edit</button>
                                        <button type="button" value="<?= $billingRecord['id']; ?>" class="deleteBillingBtn btn btn-danger btn-sm">Delete</button>
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

    </div>

</div>

</section>
<?php include('modal.php')?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function () {
  // Initialize DataTable
  $('#myTable').DataTable({
    "pagingType": "full_numbers",
    "lengthMenu": [5, 10, 25, 50, 75, 100],
    "pageLength": 10,
    "order": [[1, 'desc']],
  });
    $(document).on('click', '.editBillingBtn', function () {
    var billing_id = $(this).val();
    $.ajax({
        type: "GET",
        url: "action.php?billing_id=" + billing_id,
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {
                alertify.error(res.message);
            } else if (res.status == 200) {
                $('#billing_id').val(res.data.id);
                $('#tableusers_id').val(res.data.tableusers_id);
                $('#name').val(res.data.name);
                $('#reading_date').val(res.data.reading_date);
                $('#due_date').val(res.data.due_date);
                $('#reading').val(res.data.reading);
                $('#previous').val(res.data.previous);
                $('#penalties').val(res.data.penalties);
                $('#service').val(res.data.service);
                $('#total').val(res.data.total);
                $('#status').val(res.data.status);
                $('#billingEditModal').modal('show');
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
$(document).on('submit', '#updateBilling', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append("update_billing", true);
    $.ajax({
        type: "POST",
        url: "action.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                $('#errorMessageUpdate').removeClass('d-none');
                $('#errorMessageUpdate').text(res.message);
            } else if (res.status == 200) {
                $('#errorMessageUpdate').addClass('d-none');

                // Redirect to billing.php after updating successfully
                window.location.href = 'billing.php';

                // Hide modal and reset form
                $('#billingEditModal').modal('hide');
                $('#updateBilling')[0].reset();

                // Reload the DataTable (optional, remove if not needed)
                $('#myTable').DataTable().ajax.reload();
            } else if (res.status == 500) {
                alert(res.message);
            }
        }
    });
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
                $('#view_tableusers_id').text(res.data.tableusers_id);
                $('#view_reading_date').text(res.data.reading_date);
                $('#view_due_date').text(res.data.due_date);
                $('#view_reading').text(res.data.reading);
                $('#view_previous').text(res.data.previous);
                $('#view_penalties').text(res.data.penalties);
                $('#view_service').text(res.data.service);
                $('#view_total').text(res.data.total);
                $('#view_status').text(res.data.status);
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
                        $('#myTable').load(location.href + " #myTable");
                    }
                }
            });
        }
    });
});

</script>





