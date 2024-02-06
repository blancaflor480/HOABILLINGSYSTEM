

<?php
session_start();
include('config.php');
include('Sidebar.php');
?><!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<section class="home-section">
    <div class="text col-lg-11" style="background-color: #182061; color: white; height: 100px"><p style="margin: 18px;">
        <small>Transaction</small> > <i class="bi bi-pencil-square"></i> COLLECT PAYMENT</p></div>
    <br><br>
    <div class="container justify-content-center" style="margin-top: -5em;">
        <div class="col-lg-11 col-md-6 col-sm-11 col-xs-11">
            <div class="card rounded-0 shadow">
                <div class="card-body">
                    <div class="container-fluid">
                        
            <!--< ?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $id = $_POST['id'];
                            $reading_date = $_POST['reading_date'];
                            $previous = isset($_POST['previous']) ? $_POST['previous'] : null;
                            $reading = $_POST['reading'];
                            $service = $_POST['service'];
                            $total = $_POST['total'];
                            $due_date = $_POST['due_date'];
                            $status = $_POST['status'];
                            $paymode = $_POST['paymode'];
                            $amountpay = $_POST['amountpay']; // Assuming $_POST['amount'] is the payment amount

                            $update_query = $conn->prepare("UPDATE tablebilling_list 
                                                        SET reading_date = ?, previous = ?, reading = ?, service = ?, total = ?, due_date = ?, status = ?, amountpay = ?, paymode = ? 
                                                        WHERE tableusers_id = ?");
                            $update_query->bind_param("ssssssssss", $reading_date, $previous, $reading, $service, $total, $due_date, $status, $amountpay, $paymode, $id);

                            if ($update_query->execute()) {
                                if (isset($_POST['paymode'])) {
                                    $paymode = $_POST['paymode'];
                                    $payment_status = ($amountpay > 0) ? 1 : 0;

                                    // Check if the billing_id exists before updating status and inserting payment details
                                    $billing_id_exists_query = $conn->prepare("SELECT id FROM tablebilling_list WHERE tableusers_id = ?");
                                    $billing_id_exists_query->bind_param("s", $id);
                                    $billing_id_exists_query->execute();
                                    $billing_id_exists_result = $billing_id_exists_query->get_result();

                                    if ($billing_id_exists_result && $billing_id_exists_result->num_rows > 0) {
                                        $billing_row = $billing_id_exists_result->fetch_assoc();
                                        $billing_id = $billing_row['id'];

                                        // Billing ID exists, proceed with updating status and inserting payment details
                                        $status_query = $conn->prepare("UPDATE tablebilling_list SET status = ? WHERE id = ?");
                                        $status_query->bind_param("ss", $payment_status, $billing_id);

                                        if ($status_query->execute()) {
                                            $insert_payment_query = $conn->prepare("INSERT INTO tablepayments (billing_id, amount) VALUES (?, ?)");
                                            $insert_payment_query->bind_param("ii", $billing_id, $amountpay);

                                            if ($insert_payment_query->execute()) {
                                                // Success notification
                                                echo "<script>
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Payment Successfully',
                                                            text: 'Payment has been successfully updated.',
                                                            confirmButtonColor: '#4CAF50', // Green color
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                window.location.href = 'billing_transaction.php';
                                                            }
                                                        });
                                                    </script>";
                                            } else {
                                                // Error notification
                                                echo "<script>
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error',
                                                            text: 'Failed to insert payment details. Error: " . $conn->error . "',
                                                        });
                                                    </script>";
                                            }
                                        } else {
                                            // Error notification
                                            echo "<script>
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: 'Failed to update billing status. Error: " . $conn->error . "',
                                                    });
                                                </script>";
                                        }
                                    } else {
                                        // Error notification
                                        echo "<script>
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: 'Failed to update billing information.',
                                                });
                                            </script>";
                                    }
                                } else {
                                    // Error notification
                                    echo "<script>
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'Failed to update billing information. Error: " . $conn->error . "',
                                            });
                                        </script>";
                                }

                                exit();
                            }
                        }

                        if (isset($_GET['tableusers_id'])) {

                            $user = $conn->prepare("SELECT b.*, 
                      CONCAT(c.lname, ', ', c.fname, ' ', COALESCE(c.mname,'')) AS `name`,
                      p.receipt_path, p.reference_id, p.amount
                FROM `tablebilling_list` b 
                INNER JOIN `tableusers` c ON b.tableusers_id = c.Id 
                LEFT JOIN `tablepayments` p ON b.id = p.billing_id
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
                        ?>--><?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function sendPaymentNotification($userId, $userEmail) {
    global $conn;

    $subject = 'Payment Successfully Updated';
    $message = 'Dear Homeowner, your payment has been successfully paid.';

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'billinghoa@gmail.com';
        $mail->Password   = 'sqtrxkdxrkbalgfu';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('billinghoa@gmail.com');
        $mail->addAddress($userEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $reading_date = $_POST['reading_date'];
    $previous = isset($_POST['previous']) ? $_POST['previous'] : null;
    $reading = $_POST['reading'];
    $service = $_POST['service'];
    $total = $_POST['total'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $paymode = $_POST['paymode'];
    $amountpay = $_POST['amountpay'];

    $update_query = $conn->prepare("UPDATE tablebilling_list 
                                    SET reading_date = ?, previous = ?, reading = ?, service = ?, total = ?, due_date = ?, status = ?, amountpay = ?, paymode = ? 
                                    WHERE tableusers_id = ?");
    $update_query->bind_param("ssssssssss", $reading_date, $previous, $reading, $service, $total, $due_date, $status, $amountpay, $paymode, $id);

    if ($update_query->execute()) {
        if (isset($_POST['paymode'])) {
            $paymode = $_POST['paymode'];
            $payment_status = ($amountpay > 0) ? 1 : 0;

            $billing_id_exists_query = $conn->prepare("SELECT id FROM tablebilling_list WHERE tableusers_id = ?");
            $billing_id_exists_query->bind_param("s", $id);
            $billing_id_exists_query->execute();
            $billing_id_exists_result = $billing_id_exists_query->get_result();

            if ($billing_id_exists_result && $billing_id_exists_result->num_rows > 0) {
                $billing_row = $billing_id_exists_result->fetch_assoc();
                $billing_id = $billing_row['id'];

                $status_query = $conn->prepare("UPDATE tablebilling_list SET status = ? WHERE id = ?");
                $status_query->bind_param("ss", $payment_status, $billing_id);

                if ($status_query->execute()) {
                    $insert_payment_query = $conn->prepare("INSERT INTO tablepayments (billing_id, amount) VALUES (?, ?)");
                    $insert_payment_query->bind_param("ii", $billing_id, $amountpay);

                    if ($insert_payment_query->execute()) {
                        // Fetch user email for sending notification
                        $userEmailQuery = $conn->prepare("SELECT email FROM `tableusers` WHERE Id = ?");
                        $userEmailQuery->bind_param("s", $id);
                        $userEmailQuery->execute();
                        $userEmailResult = $userEmailQuery->get_result();

                        if ($userEmailResult && $userEmailResult->num_rows > 0) {
                            $userEmailData = $userEmailResult->fetch_assoc();
                            $userEmail = $userEmailData['email'];

                            // Send payment notification
                            sendPaymentNotification($id, $userEmail);
                        }

                        echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Successfully',
                                    text: 'Payment has been successfully updated.',
                                    confirmButtonColor: '#4CAF50'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'billing_transaction.php';
                                    }
                                });
                            </script>";
                    } else {
                        echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to insert payment details. Error: " . $conn->error . "'
                                });
                            </script>";
                    }
                } else {
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update billing status. Error: " . $conn->error . "'
                            });
                        </script>";
                }
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update billing information.'
                        });
                    </script>";
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update billing information. Error: " . $conn->error . "'
                    });
                </script>";
        }

        exit();
    }
}
                        
                        
                        if (isset($_GET['tableusers_id'])) {

                            $user = $conn->prepare("SELECT b.*, 
                      CONCAT(c.lname, ', ', c.fname, ' ', COALESCE(c.mname,'')) AS `name`,
                      p.receipt_path, p.reference_id, p.amount
                FROM `tablebilling_list` b 
                INNER JOIN `tableusers` c ON b.tableusers_id = c.Id 
                LEFT JOIN `tablepayments` p ON b.id = p.billing_id
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
                            <div class="form-group mb-3">
                                <label for="service" class="control-label">Referrence ID</label>
                                <input type="text" class="form-control form-control-sm rounded-0" id="reference_id"
                                       readonly
                                       value="<?= isset($meta['reference_id']) ? $meta['reference_id'] : '' ?>"/>
                            </div>
                             <div class="form-group mb-3">
                                <label for="service" class="control-label">Gcash Receipt</label>
                                <?php if (isset($meta['receipt_path']) && !empty($meta['receipt_path'])) : ?>
                                <a href="<?= $meta['receipt_path']; ?>" target="_blank" class="btn btn-dark btn-sm">View Receipt</a>
                                <?php else : ?>
                                    <p>No Gcash Receipt uploaded</p>
                                <?php endif; ?>
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
                                       name="amountpay" id="amountpay" required
                                       value="<?= isset($meta['amount']) ? $meta['amount'] : '' ?>"/>
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
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #fff;
            padding: 0;
        }

        .receipt-container {
            width: 80mm; /* Set the width based on the roll width */
            margin: 0 auto;
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #333;
            margin: 0;
            font-size: 1.5em; /* Larger font size for the title */
        }

        p {
            margin: 4px 0;
            color: #555;
            font-size: 0.7em; /* Smaller font size for paragraphs */
        }

        strong {
            font-weight: bold;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            color: #888;
        }
    </style>
    <title>Billing Receipt</title>
</head>
<body>
    <div class="receipt-container">
        <h1>Billing Receipt</h1>
        <span>-----------------------------------------</span>
        <p><strong>Fullname:</strong> ${document.getElementById('tableusers_id').options[document.getElementById('tableusers_id').selectedIndex].text}</p>
        <p><strong>Reading Date:</strong> ${document.getElementById('reading_date').value}</p>
        <p><strong>Due Date:</strong> ${document.getElementById('due_date').value}</p>
        <p><strong>Current Amount:</strong> ${document.getElementById('reading').value}</p>
        <p><strong>Service Fee:</strong> ${document.getElementById('service').value}</p>
        <p><strong>Total Bills:</strong> ${document.getElementById('total').value}</p>
        <p><strong>Status:</strong> ${document.getElementById('status').options[document.getElementById('status').selectedIndex].text}</p>
        <p><strong>Charges Amount:</strong> ${document.getElementById('amountpay').value}</p>
        <p><strong>Type of payment:</strong> ${document.getElementById('paymode').options[document.getElementById('paymode').selectedIndex].text}</p>
        <span>-----------------------------------------</span>
        </div>

    <div class="footer">
        <p>Thank you for your payment!</p>
    </div>
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
