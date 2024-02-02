

<?php
session_start();
include('config.php');
include('Sidebar.php');
?>

<section class="home-section">
    <div class="text col-lg-11" style="background-color: #182061; color: white; height: 100px"><p style="margin: 18px;"><i class="bi bi-pencil-square"></i> COLLECT PAYMENT</p></div>
    <br><br>
    <div class="container justify-content-center" style="margin-top: -5em;">
        <div class="col-lg-11 col-md-6 col-sm-11 col-xs-11">
            <div class="card rounded-0 shadow">
                <div class="card-body">
                    <div class="container-fluid">
                        
                        <?php
                       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $reading_date = $_POST['reading_date'];
    $previous = isset($_POST['previous']) ? $_POST['previous'] : null;
    $reading = $_POST['reading'];
    $service = $_POST['service'];
    $total = $_POST['total'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $amountpay = $_POST['amountpay'];
    $paymode = $_POST['paymode'];

    $update_query = $conn->prepare("UPDATE tablebilling_list 
                                    SET reading_date = ?, previous = ?, reading = ?, service = ?, total = ?, due_date = ?, status = ?, amountpay = ?, paymode = ? 
                                    WHERE tableusers_id = ?");
    $update_query->bind_param("ssssssssss", $reading_date, $previous, $reading, $service, $total, $due_date, $status, $amountpay, $paymode, $id);

    if ($update_query->execute()) {
        if (isset($_POST['paymode'])) {
            $paymode = $_POST['paymode'];
            $payment_status = ($amountpay > 0) ? 1 : 0;

            $status_query = $conn->prepare("UPDATE tablebilling_list SET status = ? WHERE tableusers_id = ?");
            $status_query->bind_param("ss", $payment_status, $id);
            $status_query->execute();

            // Removed the JSON response here
            // Add JavaScript alert and redirection
        echo "<script>
                alert('Payment Successfully.');
                window.location.href = 'billing_transaction.php';
              </script>";
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update billing information.'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to update billing information.'));
    }

    exit();
}

if (isset($_GET['tableusers_id'])) {
    $user = $conn->prepare("SELECT b.*, CONCAT(c.lname, ', ', c.fname, ' ', COALESCE(c.mname,'')) AS `name` 
                        FROM `tablebilling_list` b 
                        INNER JOIN `tableusers` c ON b.tableusers_id = c.Id 
                        WHERE c.Id = ? 
                        ORDER BY UNIX_TIMESTAMP(b.reading_date) DESC, `name` ASC ");

    $user->bind_param("s", $_GET['tableusers_id']);
    $user->execute();
    $meta = $user->get_result();

    if ($meta && $meta->num_rows > 0) {
        $meta = $meta->fetch_assoc();
    } else {
        echo '<script> alert("User not found."); location.replace("billing_transaction.php");</script>';
    }
}
                        ?>
                        <form method="POST" id="billing-form">
                            <input type="hidden" name="id" value="<?= isset($meta['tableusers_id']) ? $meta['tableusers_id'] : '' ?>">
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Client</label>
                                <select name="tableusers_id" id="tableusers_id" class="form-control form-control-sm rounded-0"
                                        readonly>
                                    <option value="" <?= !isset($meta['tableusers_id']) ? 'selected' : '' ?> disabled></option>
                                    <?php
                                    $client_qry = $conn->query("SELECT * FROM `tableusers` WHERE delete_flag = 0 AND `status` = 1 " . (isset($meta['tableusers_id']) && is_numeric($meta['tableusers_id']) ? " OR Id != '{$meta['tableusers_id']}' " : '') . " ");
                                    while ($row = $client_qry->fetch_assoc()) :
                                        ?>
                                        <option value="<?= $row['Id'] ?>" <?= isset($meta['tableusers_id']) && $meta['tableusers_id'] == $row['Id'] ? "selected" : '' ?>><?= $row['fname'] . ' ' . $row['lname'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="reading_date" class="control-label">Reading Date</label>
                                <input type="date" class="form-control form-control-sm rounded-0" id="reading_date"
                                       name="reading_date" readonly
                                       max="<?= date("Y-m-d") ?>"
                                       value="<?= isset($meta['reading_date']) ? date("Y-m-d", strtotime($meta['reading_date'])) : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="due_date" class="control-label">Due Date</label>
                                <input type="date" class="form-control form-control-sm rounded-0" id="due_date"
                                       name="due_date" readonly
                                       value="<?= isset($meta['due_date']) ? date("Y-m-d", strtotime($meta['due_date'])) : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="reading" class="control-label">Current Amount</label>
                                <input type="text" class="form-control form-control-sm rounded-0" id="reading"
                                       name="reading" readonly
                                       value="<?= isset($meta['reading']) ? $meta['reading'] : '' ?>"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="service" class="control-label">Penatlies</label>
                                <input type="text" class="form-control form-control-sm rounded-0" id="service"
                                       name="service" readonly
                                       value="<?= isset($meta['penalties']) ? $meta['penalties'] : $_settings->info('service_fee') ?>"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="service" class="control-label">Service Fee</label>
                                <input type="text" class="form-control form-control-sm rounded-0" id="service"
                                       name="service"  readonly
                                       value="<?= isset($meta['service']) ? $meta['service'] : $_settings->info('service_fee') ?>"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="total" class="control-label">Total Bill</label>
                                <input type="text" 
                                       class="form-control form-control-sm rounded-0 text-right" id="total" readonly
                                       name="total"
                                       required
                                       value="<?= isset($meta['total']) ? $meta['total'] : '' ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="status" class="control-label">Status</label>
                                <select name="status" id="status"
                                        class="form-control form-control-sm rounded-0">
                                    <option value="0" <?php echo isset($meta['status']) && $meta['status'] == 0 ? 'selected' : '' ?>>
                                        Pending
                                    </option>
                                    <option value="1" <?php echo isset($meta['status']) && $meta['status'] == 1 ? 'selected' : '' ?>>
                                        Paid
                                    </option>
                                </select>
                            </div>
                             <div class="form-group mb-3">
                                <label for="amountpay" class="control-label">Charge Amount</label>
                                <input type="text" class="form-control form-control-sm rounded-0" id="amountpay"
                                       name="amountpay" required
                                       value="<?= isset($meta['amountpay']) ? $meta['amountpay'] : '' ?>"/>
                            </div>
                             <div class="form-group">
                                <label for="status" class="control-label">Payment Type</label>
                                <select name="paymode" id="paymode"
                                        class="form-control form-control-sm rounded-0" required>
                                    <option placeholder="Please Select Here" disabled>Please Select Here</option>
                                    <option value="0" <?php echo isset($meta['paymode']) && $meta['paymode'] == 0 ? 'selected' : '' ?>>
                                        Walk in 
                                    </option>
                                    <option value="1" <?php echo isset($meta['paymode']) && $meta['paymode'] == 1 ? 'selected' : '' ?>>
                                        Online payment
                                    </option>
                                </select>
                            </div>
                           
                        </form>
                    </div><br>
                    <div class="text-center" style="margin: 10px;">
                        <button class="btn btn-success btn-sm bg-gradient-success rounded-0" data-toggle="modal" data-target="#confirmationModal">
                            <i class="fa fa-save"></i> Proceed
                        </button>

                        <a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="billing.php"><i class="fa fa-angle-left"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</section>
<!-- Confirmation Modal -->
<div class="modal" tabindex="-1" role="dialog" id="confirmationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to update the account information?
            </div>
            <div class="modal-footer d-flex justify-content-center">
           <button type="button" class="btn btn-success" onclick="confirmAndPrint()">Confirm</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
        </div>
    </div>
</div>

<script>
function confirmAndPrint() {
    // Trigger the form submission
    document.getElementById('billing-form').submit();

    // Construct the HTML content for printing
    var printContent = `
        <html>
        <head>
            <title>Billing Information</title>
        </head>
        <body>
            <h1>Billing Information</h1>
            <p>Client: ${document.getElementById('tableusers_id').options[document.getElementById('tableusers_id').selectedIndex].text}</p>
            <p>Reading Date: ${document.getElementById('reading_date').value}</p>
            <!-- Add more content as needed -->
        </body>
        </html>
    `;

    // Create a new window and write the HTML content
    var printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);

    // Automatically trigger the print dialog after the window has loaded
    printWindow.onload = function () {
        printWindow.print();
        printWindow.onafterprint = function () {
            // Close the print window after printing
            printWindow.close();
            
            // Redirect after printing
            window.location.href = 'billing_transaction.php';
        };
    };
}

</script>

<script>
    function updateTotalAmount() {
        var currentAmount = parseFloat(document.getElementById('reading').value) || 0;
        var previousAmount = parseFloat(document.getElementById('previous').value) || 0;
        var serviceFee = parseFloat(document.getElementById('service').value) || 0;

        var totalAmount = currentAmount + previousAmount + serviceFee;

        // Check if totalAmount is a valid number before calling toFixed
        if (!isNaN(totalAmount)) {
            document.getElementById('total').value = totalAmount.toFixed(2);
        }
    }

    function updateBillingDetails() {
        var selectedUserId = document.getElementById('tableusers_id').value;

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        document.getElementById('previous').value = parseFloat(response.previousBalance) || 0;

                        // Set the service fee to 10 pesos
                        document.getElementById('service').value = 10;

                        document.getElementById('penalties').value = parseFloat(response.penalties) || 0;

                        var totalAmount = parseFloat(response.previousBalance) + 10 +
                                          (parseFloat(response.penalties) || 0);

                        // Check if totalAmount is a valid number before calling toFixed
                        if (!isNaN(totalAmount)) {
                            document.getElementById('total').value = totalAmount.toFixed(2);
                        }
                    } else {
                        console.error('Error: ' + response.error);
                    }
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };

        xhr.open('POST', 'get_billing_details.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Adjust the data being sent to match what your PHP script expects
        xhr.send('tableusers_id=' + selectedUserId);
    }

    document.getElementById('tableusers_id').addEventListener('change', updateBillingDetails);

    // Attach the updateTotalAmount function to the 'input' event of the reading field
    document.getElementById('reading').addEventListener('input', updateTotalAmount);
</script>
