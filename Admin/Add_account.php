
<style>
  #staticBackdrop img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
  }

  .modal-body {
    text-align: left;
  }

  .modal-body label {
    display: block;
    margin-bottom: 5px;
  }

  .modal-body input {
    width: 100%;
    padding: 6px;
    margin-bottom: 15px;
    box-sizing: border-box;
  }
  .modal-body select{
    width: 100%;
    padding: 6px;
    margin-bottom: 15px;
    box-sizing: border-box;
  }
</style>

<!-- Modal -->
<div class="modal fade" id="Add_account" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Create Account Administrator</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="backend_account.php" method="POST" enctype="multipart/form-data">
        <div><img src="" alt=""></div>
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" />

        <label for="mname">Middle Name</label>
        <input type="text" id="mname" name="mname" />

        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" />

        <label for="email">Email</label>
        <input type="text" id="email" name="email" />
        
        <label for="contact">Contact No.</label>
        <input type="text" id="contact" name="contact" />
        
        <label for="birthday">Birthday</label>
        <input type="date" id="bday" name="bday" />

        <label for="Address">Address</label>
        <input type="text" id="address" name="address" />

        <label for="gender">Gender</label>
        <select id="gender" name="gender">
        <option>---Select---</option>
        <option value="Admin">Male</option>
        <option value="Staff">Female</option>
        </select>

        <label for="type">User Type</label>
        <select id="type" name="type">
        <option>---Select---</option>
        <option value="Admin">Admin</option>
        <option value="Staff">Staff</option>
        </select>

        <label for="username">Username</label>
        <input type="text" id="uname" name="uname" />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" />

        <label for="copassword">Confirm Password</label>
        <input type="password" id="copassword" name="copassword" />

        <label for="pfp">Profile</label>
        <input type="file" id="pfp" name="pfp" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-success">Create</button>
      </div>

</form>
    </div>
  </div>
</div>