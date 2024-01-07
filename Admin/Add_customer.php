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
</style>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Create Account Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div><img src="users.jpg" alt=""></div>
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" />

        <label for="mname">Middle Name</label>
        <input type="text" id="mname" name="mname" />

        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" />

        <label for="email">Email</label>
        <input type="text" id="email" name="email" />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" />

        <label for="copassword">Confirm Password</label>
        <input type="password" id="copassword" name="copassword" />

        <label for="pfp">Profile</label>
        <input type="file" id="pfp" name="pfp" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success">Create</button>
      </div>
    </div>
  </div>
</div>
