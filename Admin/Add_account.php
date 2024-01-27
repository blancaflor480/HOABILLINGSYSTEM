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
  .modal-body select {
    width: calc(100% - 12px);
    padding: 6px;
    border: 1px solid #aaa;
    border-radius: 3px;
    margin-bottom: 15px;
    box-sizing: border-box;
    font-size: 0.9rem;
  }

  .modal-footer {
    text-align: center; /* Centered buttons */
  }
</style>

<!-- Modal -->
<div class="modal fade" id="Addaccount" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Create Account Administrator</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="modal-body">
      <form method="POST" action="backendd_Addaccount.php" enctype="multipart/form-data">
      <h5 class="modal-title" id="staticBackdropLabel" style="font-size: 15px; color: darkred; margin-bottom: 10px;">Please fill up!</h5>
         <label for="fname" style="width: 190px;">First Name</label>
         <label for="mname" style="width: 150px; margin-left: 200px; background-color: yellow">Middle Name</label>
         <label for="lname" style="width: 200px; margin-left: 430px; background-color: yellow; ">Last Name</label>
        <input type="text" id="fname" name="fname" style="width: 210px;"/>
        <input type="text" id="mname" name="mname" style="width: 210px;"/>
        <input type="text" id="lname" name="lname" style="width: 210px;"/>

        <label for="email">Email</label>
        <input type="text" id="email" name="email" />

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
</div>
