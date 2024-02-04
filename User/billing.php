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

<?php include('Sidebar.php');?>

<!-- Include these links in the head section of your HTML -->
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
        font-size: 14px;
    }

    .table img {
        max-width: 80px;
        max-height: 80px;
        border: 4px groove #CCCCCC;
        border-radius: 5px;
    }

    .dropdown-menu a {
        cursor: pointer;
        font-size: 15px;
    }

    .dropdown-menu a:hover {
        background-color: #f8f9fa !important;
    }

    .btn {
        font-size: 12px;
    }

    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .paginate_button {
        font-size: 12px;
    }

    .paginate_button.previous, .paginate_button.next {
        font-size: 12px;
    }
</style>

<section class="home-section">
    <div class="text"><i class="bx bx-pie-chart-alt-2"></i> Billing</div>
    <div class="col-lg-12">
        <div class="card">
            <h5 class="card-header">Dues Bills
                <a class="btn btn-primary float-right mx-2" href="billing_history.php">
                    <span class="bi bi-receipt"></span  > History Transaction
                </a>
                <a class="btn btn-warning float-right" href="complaint.php">
                    <span class="bx bx-envelope"></span> Complaint
                </a>
            </h5>
            <div class="card-body">
                <table class="table table-hover table-striped table-bordered" id="list">
                    <thead>
                        <tr>
                            <th>Bill no.</th>
                            <th>Reading Date</th>
                            <th>Due Date</th>
                            <th>Homeowner</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                        $qry = $conn->prepare("SELECT b.id, b.reading_date, b.due_date, concat(c.lname, ', ', c.fname, ' ', coalesce(c.mname,'')) as `name`, b.status, b.total
                      FROM `tablebilling_list` b 
                      INNER JOIN tableusers c ON b.tableusers_id = c.id 
                      WHERE c.email = ? AND b.status = 0 OR b.status = 2 
                      ORDER BY unix_timestamp(`reading_date`) DESC, `name` ASC ");
                     $qry->bind_param("s", $email);
                     $qry->execute();
                     $qry->bind_result($id, $reading_date, $due_date, $name, $status, $total);


                        while ($qry->fetch()) {
                            ?>
                            <tr>
                                <td><?= $id; ?></td>
                                <td><?= date("Y-m-d", strtotime($reading_date)); ?></td>
                                <td><?= date("Y-m-d", strtotime($due_date)); ?></td>
                                <td><?= $name; ?></td>
                                <td>
                                    <?php
                                    switch ($status) {
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
                                <td><b><?= $total; ?><b></td>
                                <td>
                                <?php if ($status != 2): ?>
    <button type="button" value="<?= $id; ?>" class="payBtn btn btn-success btn-sm" 
                data-toggle="modal" data-target="#paymentModal" 
                data-total="<?= $total; ?>"
                data-paymode="<?= $paymode; ?>" 
                onclick="selectPaymentOption('online', <?= $id; ?>, <?= $total; ?>)">
                <i class="bi bi-credit-card"></i> Pay
            </button>
            <?php endif; ?>
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
            "order": [[1, 'desc']],
        });
    });
</script>

<!-- Bootstrap Modal for Payment Options -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Choose Payment Method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="margin: auto;">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary" onclick="selectPaymentOption('walkIn')">Walk-In</button>
                        <button class="btn btn-success" onclick="selectPaymentOption('online')">Online Payment</button>
                    </div>
                </div>

                <div id="walkInDetails" style="margin-top: 20px; display: none;">
                    <p>Walk-In Payment Information:</p>
                    <p>Office Hours: Monday to Friday, 9:00 AM - 5:00 PM</p>
                    <p>Location: [Your Office Address]</p>
                    <p>Please visit our office during the specified hours to make your payment in person.</p>
                </div>

               <div id="onlinePaymentForm" style="margin-top: 20px; display: none;">
    <form method="POST" action="bk_payment.php" id="onlinePaymentForm" enctype="multipart/form-data">
        <input type="hidden" name="billing_id" id="billing_id" value="">
        <div class="text" style="font-weight: 500;">HOA GCASH NUMBER: 09657347859</div><br>
        <div class="form-group">
            <label for="total" style="font-size: 0.9rem">Total Amount</label>
            <input type="text" class="form-control form-control-sm" id="total" name="total" readonly>
        </div>
        <div class="form-group">
            <label for="status" class="control-label" style="font-size: 0.9rem">Payment Type</label>
                                <select name="paymode" id="paymode"
                                        class="form-control form-control-sm rounded-0" required>
                                    <option placeholder="Please Select Here" disabled>Please Select Here</option>
                                    <option value="1" <?php echo isset($meta['paymode']) && $meta['paymode'] == 1 ? 'selected' : '' ?>>
                                        Online payment - GCASH
                                    </option>
                                </select>
        </div>
        <div class="form-group">
            <label for="reference_id" style="font-size: 0.9rem">Reference ID</label>
            <input type="text" class="form-control form-control-sm" name="referenceId" id="referenceId" required>
        </div>
        <div class="form-group">
            <label for="receipt" style="font-size: 0.9rem">Upload GCash Receipt</label>
            <input type="file" class="form-control form-control-sm" name="receipt_file" id="receipt_file" accept=".pdf, .jpg, .jpeg, .png" required>
        </div>


        <div class="form-group">
            <label for="amountpay" style="font-size: 0.9rem">Pay amount</label>
            <input type="text" class="form-control form-control-sm" id="amountpay" name="amountpay">
        </div><br>
        <div class="text-center">
        <button type="submit" class="btn btn-success">Pay</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
    </div>
    </form>
</div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectPaymentOption(option, billingId, totalAmount) {
        document.getElementById('walkInDetails').style.display = 'none';
        document.getElementById('onlinePaymentForm').style.display = 'none';

        if (option === 'walkIn') {
            document.getElementById('walkInDetails').style.display = 'block';
            document.getElementById('onlinePaymentForm').style.display = 'none';
        } else if (option === 'online') {
            document.getElementById('walkInDetails').style.display = 'none';
            document.getElementById('onlinePaymentForm').style.display = 'block';

            // Check if totalAmount is undefined (e.g., when called programmatically)
            if (typeof totalAmount !== 'undefined') {
                // Set the total amount in the online payment form
                document.getElementById('total').value = totalAmount;
            }

            // Set the billing ID in a hidden field for form submission
            document.getElementById('billing_id').value = billingId;
        }
    }

    $(document).ready(function () {
        // Your existing DataTable initialization code

        $('button[data-target="#onlinePaymentModal"]').on('click', function () {
            var billingId = $(this).data('billingid');
            $('#billing_id').val(billingId);
        });

        $('#paymentForm').submit(function (e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(), // Serialize the form data
                success: function (data) {
                    // Handle the response from the server
                    console.log(data);

                    // You can implement further actions based on the response, e.g., show a success message, redirect, etc.
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        });
    });
</script>

