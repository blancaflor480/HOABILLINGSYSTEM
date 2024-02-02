
<style>
  #addbills img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
  }

  .modal-dialog {
    max-width: 30%;
    margin: 5% auto;
  }

  .modal-body {
    text-align: left;
  }

  .modal-body label {
    display: block;
    margin-bottom: 5px;
    font-size: 0.9rem;
  }

  .modal-body input,
  .modal-body select {
    width: calc(100% - 12px);
    padding: 6px;
    border: 1px solid #aaa;
    border-radius: 3px;
    margin-bottom: 15px;
    box-sizing: border-box;
    font-size: 0.9rem;
  }

  .error-message {
    color: red;
    font-size: 0.7rem;
  }

  .modal-footer {
    text-align: center;
  }
</style>

<!-- Modal Add bills -->
<div class="modal fade" id="addbills" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Generate New Bills</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="bk_billing.php" enctype="multipart/form-data">
          <input type="hidden" name="tableusers_id" value="<?= isset($id) ? $id : '' ?>"> 
          <h5 class="modal-title" id="staticBackdropLabel" style="font-size: 15px; color: darkred; margin-bottom: 10px;"></h5>

       <label for="tableusers_id">Homeowner Name</label>
        <select id="tableusers_id" name="tableusers_id" required="required">
    <option value="" <?= !isset($tablusers_id) ? 'selected' : '' ?> disabled>Please Select Here</option>
    <?php 
        $client_qry = $conn->query("SELECT *, concat(lname, ', ', fname, ' ', coalesce(mname)) as `name` FROM `tableusers` 
        where delete_flag = 0 and `status` = 1 ".(isset($tablusers_id) && is_numeric($tablusers_id) ? " or id != '{$tablusers_id}' " : '')." ");
        while($row = $client_qry->fetch_assoc()):
    ?>
    <option value="<?= $row['Id'] . ' - ' . $row['name'] ?>" <?= isset($tablusers_id) && $tablusers_id == $row['Id'] ? "selected" : '' ?>>
    <?= $row['Id'] . " - " . $row['name'] ?></option>
    <?php endwhile ?>
</select>
      
          <label for="readingDueDate" style="width: 190px; margin-bottom: -22px">Reading Date</label>
          <label for="billDueDate" style="width: 250px; margin-left: 205px; ">Due Date</label>
          
          <input type="date" id="readingDueDate" name="readingDueDate" style="width: 200px;" required="required" max="<?= date("Y-m-d") ?>"/>
          <input type="date" id="billDueDate" name="billDueDate"  style="width: 217px;"/>
        
          <label for="currentAmount" style="width: 190px; margin-bottom: -22px">Current Amount</label>
          <label for="previousBalance" style="width: 250px; margin-left: 205px; ">Previous Balance</label>
          <input type="text" id="current" name="current" style="width: 200px;" required="required"/>
          <input type="text" id="previous" name="previous" style="width: 217px;" required="required" readonly 
          value="<?= isset($previous) ? $previous : '' ?>" disabled/>

           <label for="serviceFee">Service Fee</label>
          <input type="number" id="service" name="service" readonly/>

          <label type="hidden" for="penalties"></label>
          <input type="hidden" id="penalties" name="penalties" readonly/>

          <label for="totalAmount">Total Amount</label>
          <input type="number" id="total" name="totalamount" readonly/>

          <label for="Status">Status</label>
          <select name="status" id="status"required>
            <option>Please Select Here</option> 
                                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
                                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Paid</option>
                                </select>
        </select>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" form="billing-form">Close</button>
        <button type="submit" name="submit" class="btn btn-success">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Add this modal code after your existing modals -->


<!-- Edit Record Modal -->
<!--<div class="modal fade" id="billingEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Billing Record</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
            </div>
            <form id="updateBillingForm">
                <div class="modal-body">
                    <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                    <input type="hidden" name="billing_id" id="billing_id">

                    <div class="mb-3">
                         <label for="tableusers_id">Homeowners name</label>
                        <select id="tableusers_id" disabled>
        <?php
            $client_qry = $conn->query("SELECT *, concat(lname, ', ', fname, ' ', coalesce(mname)) as `name` FROM `tableusers` 
          where delete_flag = 0 and `status` = 1");
            while ($row = $client_qry->fetch_assoc()) :
            ?>
              <option value="<?=  $row['Id'] ?>" <?= isset($meta['tableusers_id']) && $meta['tableusers_id'] == $row['Id'] ? "selected" : '' ?>>
                <?= $row['Id'] . " - " . $row['name'] ?></option>
            <?php endwhile ?>
          </select>

                    </div>

                    <div class="mb-3">
                        <label for="reading_date">Reading Date</label>
                        <input type="date" name="reading_date" id="reading_date" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="due_date">Due Date</label>
                        <input type="date" name="due_date" id="due_date" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="current">Current Amount</label>
                        <input type="text" name="reading" id="reading" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="previous">Previous</label>
                        <input type="text" name="previous" id="previous" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="penalties">Penalties</label>
                        <input type="text" name="penalties" id="penalties" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="service">Service</label>
                        <input type="text" name="service" id="service" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="total">Total</label>
                        <input type="text" name="total" id="total" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="0">Pending</option>
                            <option value="1">Paid</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>-->




<!-- View Record Modal ORIG -->
<div class="modal fade" id="billingViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Bills Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="mb-3">
    <label for="tableusers_id">Name</label>
    <p id="view_tableusers_id" class="form-control"></p>
</div> 
<div class="mb-3">
                <label for="reading_date" style="width: 190px; margin-bottom: -22px">Reading Date</label>
                    <label for="due_date" style="width: 250px; margin-left: 205px; ">Due Date</label>
                    <p id="view_reading_date" style="width: 200px; margin-bottom: -38px" class="form-control">
                    <p id="view_due_date" style="width: 215px; margin-left: 205px;" class="form-control"></p></p>
                </div>

                <div class="mb-3">
                    <label for="reading">Current</label>
                    <p id="view_reading" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="previous">Previous</label>
                    <p id="view_previous" class="form-control"></p>
                </div>

                <div class="mb-3">
                    <label for="penalties">Penalties</label>
                    <p id="view_penalties" class="form-control"></p>
                </div>
                
                <div class="mb-3">
                    <label for="service">Service</label>
                    <p id="view_service" class="form-control"></p>
                </div>
                

                <div class="mb-3">
                    <label for="total">Total</label>
                    <p id="view_total" style="font-weight: 500; background-color: #C8C8C8;" class="form-control"></p>
                </div>
                    
                <div class="mb-3">
                    <label for="status">Status</label>
                    <p id="view_status" class="form-control"></p>
                </div>
      
      </div>
      <div class="modal-footer">


<button type="button" class="btn btn-primary" onclick="printBillingDetails()">Print</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
    </div>
  </div>
</div>
<script>
  function printBillingDetails() {
    // Gather data from the modal
    var homeownerName = document.getElementById('view_tableusers_id').innerText;
    var readingDate = document.getElementById('view_reading_date').innerText;
    var dueDate = document.getElementById('view_due_date').innerText;
    var reading = document.getElementById('view_reading').innerText;
    var previous = document.getElementById('view_previous').innerText;
    var penalties = document.getElementById('view_penalties').innerText;
    var service = document.getElementById('view_service').innerText;
    var total = document.getElementById('view_total').innerText;
    var status = document.getElementById('view_status').innerText;

    // Create a new window for printing
    var printWindow = window.open('', '_blank');

    // Design the print content
    printWindow.document.write(`
      <html>
        <head>
          <title>Billing Details - ${homeownerName}</title>
          <style>
            /* Add your print styles here */
          </style>
        </head>
        <body>
          <h2>Billing Details</h2>
          <p><strong>Homeowner Name:</strong> ${homeownerName}</p>
          <p><strong>Reading Date:</strong> ${readingDate}</p>
          <p><strong>Due Date:</strong> ${dueDate}</p>
          <p><strong>Reading:</strong> ${reading}</p>
          <p><strong>Previous:</strong> ${previous}</p>
          <p><strong>Penalties:</strong> ${penalties}</p>
          <p><strong>Service:</strong> ${service}</p>
          <p><strong>Total:</strong> ${total}</p>
          <p><strong>Status:</strong> ${status}</p>
        </body>
      </html>
    `);

    // Close the document after printing
    printWindow.document.close();

    // Print the window
    printWindow.print();
}

</script>

<script>
function updateTotalAmount() {
    var currentAmount = parseFloat(document.getElementById('current').value) || 0;
    var serviceFee = parseFloat(document.getElementById('service').value) || 0;
    var penalties = parseFloat(document.getElementById('penalties').value) || 0;

    var totalAmount = currentAmount + serviceFee + penalties;

    // Check if totalAmount is a valid number before calling toFixed
    if (!isNaN(totalAmount)) {
        document.getElementById('total').value = totalAmount.toFixed(2);
    }
}

// Attach the updateTotalAmount function to the 'input' event of the current amount field
document.getElementById('current').addEventListener('input', updateTotalAmount);



function updateBillingDetails() {
    var selectedUserId = document.getElementById('tableusers_id').value;
    var currentAmount = parseFloat(document.getElementById('current').value) || 0;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);

                if (response.error) {
                    console.error('Error: ' + response.error);
                } else {
                    document.getElementById('previous').value = parseFloat(response.previousBalance) || 0;
                    
                    // Set the service fee to 10 pesos
                    document.getElementById('service').value = 10;
                    
                    document.getElementById('penalties').value = parseFloat(response.penalties) || 0;

                    var totalAmount = currentAmount + 10 + (parseFloat(response.penalties) || 0);

                    // Check if totalAmount is a valid number before calling toFixed
                    if (!isNaN(totalAmount)) {
                        document.getElementById('total').value = totalAmount.toFixed(2);
                    } 
                }
            } else {
                console.error('Error: ' + xhr.status);
            }
        }
    };

    xhr.open('POST', 'get_billing_details.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    // Adjust the data being sent to match what your PHP script expects
    xhr.send('userId=' + selectedUserId);
}

document.getElementById('tableusers_id').addEventListener('change', updateBillingDetails);

</script>

<div class="modal fade" id="collectPaymentModal" tabindex="-1" role="dialog" aria-labelledby="collectPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="collectPaymentModalLabel">Collect Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="collectPaymentForm">
                    <div class="form-group">
                        <label for="tableusers_id">Homeowner ID</label>
                        <input type="text" class="form-control" id="tableusers_id" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentAmount">Current Amount:</label>
                        <input type="text" class="form-control" id="currentAmount" readonly>
                    </div>
                    <div class="form-group">
                        <label for="penalties">Penalties:</label>
                        <input type="text" class="form-control" id="penalties" readonly>
                    </div>
                    <div class="form-group">
                        <label for="serviceFee">Service Fee:</label>
                        <input type="text" class="form-control" id="serviceFee" readonly>
                    </div>
                    <div class="form-group">
                        <label for="totalAmount">Total Amount:</label>
                        <input type="text" class="form-control" id="totalAmount" readonly>
                    </div>
                    <div class="form-group">
                        <label for="totalAmount">Charge Amount:</label>
                        <input type="text" class="form-control" id="amountpay" required>
                    </di+v>
                    <div class="form-group">
                     <label for="paymentType">Payment Type:</label>
                     <select class="form-control" id="paymode" name="paymode" required>
                     <option value="online">Online</option>
                     <option value="walkin">Walk-in</option>
                </select>
                </div>
                     <button type="submit" class="btn btn-primary">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    //Dito ilalagay para sa editmodal 
</script>

