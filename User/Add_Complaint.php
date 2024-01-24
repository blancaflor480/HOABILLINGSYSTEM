<style>
  #staticBackdrop img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
  }

  .modal-dialog {
    max-width: 45%; /* Adjusted maximum width */
    margin: 5% auto; /* Centered on the screen */
  }

  .modal-body {
    text-align: left;
  }

  .modal-body label {
    display: block;
    margin-bottom: 5px;
    font-size: 0.9rem; /* Adjusted font size */
  }

  .modal-body input,
  .modal-body textarea,
  .modal-body select {
    width: calc(100% - 12px); /* Adjusted width */
    padding: 6px;
    margin-bottom: 15px;
    box-sizing: border-box;
    font-size: 0.9rem; /* Adjusted font size */
  }

  .modal-footer {
    text-align: center; /* Centered buttons */
  }
</style>

<!-- Modal -->
<div class="modal fade" id="AddComplaint" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Create New Complaint</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="modal-body">
      <form method="POST" action="bk_complaint.php" enctype="multipart/form-data">
      <h5 class="modal-title" id="staticBackdropLabel" style="font-size: 15px; color: darkred; margin-bottom: 10px;"></h5>
         
        <label for="mname">Type of Complaint</label>
    <select name="typecomplaint" id="typemessage">
            <option>---Please Select---</option>
            <option value="Bill not correct">Bill not correct</option>
            <option value="Bill generated late">Bill generated late</option>
            <option value="Transaction not processed">Transaction not processed</option>
            <option value="Previous complaint not process">Previous complaint not process</option>
    </select>
        <label for="text">Please type your concern</label>
        <textarea type="text" id="text" name="description"></textarea>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-success">Submit</button>
      </div>
      </form>
    </div>    
      
    </div>
  </div>
</div>
