<?php
include('config.php');

// Check if the user ID is provided in the URL
if (isset($_GET['tableusers_id'])) {
    // Query the billing details for the specific user
    $user = $conn->prepare("SELECT b.*, concat(c.lname, ', ', c.fname, ' ', coalesce(c.mname,'')) as `name` 
                          FROM `tablebilling_list` b 
                          INNER JOIN tableusers c ON b.tableusers_id = c.id 
                          WHERE c.id = ? 
                          ORDER BY unix_timestamp(`reading_date`) DESC, `name` ASC ");

    $user->bind_param("s", $_GET['tableusers_id']);
    $user->execute();
    $meta = $user->get_result();

    // Check if the query was successful and returned any result
    if ($meta && $meta->num_rows > 0) {
        // Fetch the data
        $meta = $meta->fetch_assoc();
    } else {
        // Handle the case where no user is found
        echo '<script> alert("User not found."); location.replace("billing_transaction.php");</script>';
    }
}
?>
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
<div class="modal fade" id="viewbills" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Bills Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="GET" enctype="multipart/form-data">
          <input type="hidden" name="tableusers_id" value="<?= isset($meta['tableusers_id']) ? $meta['tableusers_id'] : '' ?>">
          <h5 class="modal-title" id="staticBackdropLabel" style="font-size: 15px; color: darkred; margin-bottom: 10px;"></h5>

          <label for="name">Homeowner Name</label>
          <select id="name" disabled>
        <?php
            $client_qry = $conn->query("SELECT *, concat(lname, ', ', fname, ' ', coalesce(mname)) as `name` FROM `tableusers` 
          where delete_flag = 0 and `status` = 1");
            while ($row = $client_qry->fetch_assoc()) :
            ?>
              <option value="<?=  $row['Id'] ?>" <?= isset($meta['tableusers_id']) && $meta['tableusers_id'] == $row['Id'] ? "selected" : '' ?>>
                <?= $row['Id'] . " - " . $row['name'] ?></option>
            <?php endwhile ?>
          </select>

          <label for="readingDueDate" style="width: 190px; margin-bottom: -22px">Reading Date</label>
          <label for="billDueDate" style="width: 250px; margin-left: 205px; ">Due Date</label>
          
          <input type="date" id="readingDueDate" name="readingDueDate" style="width: 200px;" value="<?php echo isset($meta['reading_date']) ? $meta['reading_date']: '' ?>"  disabled/>
          <input type="date" id="duedate" name="previous" style="width: 217px;" value="<?= isset($meta['due_date']) ? $meta['due_date'] : '' ?>" disabled/>

          <label for="currentAmount" style="width: 190px; margin-bottom: -22px">Current Amount</label>
          <label for="previousBalance" style="width: 250px; margin-left: 205px; ">Previous Balance</label>
         <input type="text" id="current" name="current" style="width: 200px;" value="<?php echo isset($meta['reading']) ? $meta['reading'] : '' ?>" disabled/>
         <input type="text" id="previousBalance" name="previousBalance" style="width: 217px;" value="<?php echo isset($meta['previous']) ? $meta['previous'] : '' ?>" disabled/>

          
           <label for="serviceFee">Service Fee</label>
          <input type="number" id="service"  value="<?php echo isset($meta['service']) ? $meta['service']: '' ?>" disabled/>

          <label type="text" for="penalties">Penalties</label>
          <input type="text" id="penalties" value="<?php echo isset($meta['penalties']) ? $meta['penalties']: '' ?>" disabled/>

          <label for="totalAmount">Total Amount</label>
          <input type="number" id="total" name="totalamount" value="<?php echo isset($meta['total']) ? $meta['total']: '' ?>" disabled/>

          <label for="Status">Status</label>
           <select id="status" disabled>
             <option value= 0 <?php if ($result['status'] == 0) echo 'selected'; ?>>Pending</option>
              <option value= 1 <?php if ($result['status'] == 1) echo 'selected'; ?>>Paid</option>
            </select>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal" form="billing-form"><i class="bi bi-printer-fill"></i> Print</button>  
      <button type="button" class="btn btn-secondary" data-dismiss="modal" form="billing-form">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

