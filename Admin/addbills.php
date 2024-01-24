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
        <form method="POST" action="backendd_Addaccount.php" enctype="multipart/form-data">
          <h5 class="modal-title" id="staticBackdropLabel" style="font-size: 15px; color: darkred; margin-bottom: 10px;"></h5>

          <label for="fname">Homeowner</label>
          <input type="select" id="fname" name="fname" />

          <label for="dueDate">Reading Date</label>
          <input type="date" id="dueDate" name="dueDate" />

          <label for="dueDate">Due Date</label>
          <input type="date" id="dueDate" name="dueDate" />
        
          <label for="fname">Current Reading</label>
          <input type="text" id="fname" name="fname" />

          <label for="previousBalance">Previous Balance</label>
          <input type="text" id="previousBalance" name="previousBalance" />

          <label for="totalAmount">Total Amount</label>
          <input type="text" id="totalAmount" name="totalAmount" />

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-success">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>
