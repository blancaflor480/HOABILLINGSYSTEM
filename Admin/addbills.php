
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

<!-- Modal -->
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
          <input type="hidden" name="Id" value="<?= isset($d) ? $Id : '' ?>"> 
          <h5 class="modal-title" id="staticBackdropLabel" style="font-size: 15px; color: darkred; margin-bottom: 10px;"></h5>

       <label for="tableusers_id">Homeowner Name</label>
        <select id="tableusers_id" required="required">
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
          <input type="number" id="current" name="current" style="width: 200px;" required="required"/>
          <input type="number" id="previous" name="previous" style="width: 217px;" required="required" readonly 
          value="<?= isset($previous) ? $previous : '' ?>" disabled/>

           <label for="serviceFee">Service Fee</label>
          <select name="service" id="service" required>
          <option>Please Select Here</option> 
                <option value="5.00" <?php echo isset($service) && $service == 5.00 ? 'selected' : '' ?>>5.00</option>
                <option value="10.00" <?php echo isset($service) && $service == 10.00 ? 'selected' : '' ?>>10.00</option>
                <option value="15.00" <?php echo isset($service) && $service == 15.00 ? 'selected' : '' ?>>15.00</option>
            </select>

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
<script>
  function updateBillingDetails() {
    var selectedUserId = document.getElementById('tableusers_id').value;
    var currentAmount = parseFloat(document.getElementById('current').value) || 0;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            console.log('Response:', xhr.responseText); // Log the entire response for debugging

            try {
                var response = JSON.parse(xhr.responseText);

                if (response.error) {
                    console.error('Error: ' + response.error);
                } else {
                    document.getElementById('previous').value = parseFloat(response.previousBalance) || 0;

                    // Use the selected service fee from the dropdown
                    var selectedServiceFee = parseFloat(document.getElementById('service').value) || 0;
                    document.getElementById('service').value = selectedServiceFee;

                    document.getElementById('penalties').value = parseFloat(response.penalties) || 0;

                    // Update the totalAmount calculation to include the selected serviceFee
                    var totalAmount = currentAmount + selectedServiceFee + (parseFloat(response.penalties) || 0);

                    // Check if totalAmount is a valid number before calling toFixed
                    if (!isNaN(totalAmount)) {
                        document.getElementById('total').value = totalAmount.toFixed(2);
                    }
                }
            } catch (e) {
                console.error('Error parsing JSON: ' + e);
            }
        }
    };

    xhr.open('POST', 'get_billing_details.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Adjust the data being sent to match what your PHP script expects
    xhr.send('tableusers_id=' + selectedUserId);
  }

  // Attach the updateBillingDetails function to the 'change' event of the tableusers_id select element
  document.getElementById('tableusers_id').addEventListener('change', updateBillingDetails);

  // Attach the updateBillingDetails function to the 'change' event of the service dropdown
  document.getElementById('service').addEventListener('change', updateBillingDetails);
</script>
