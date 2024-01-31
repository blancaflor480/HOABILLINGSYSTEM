<?php
session_start();
include('config.php');
include('sidebar.php');

if (isset($_GET['uname'])) {
    $user = $conn->query("SELECT * FROM tableaccount WHERE uname = '{$_GET['uname']}'");

    // Check if the query was successful and returned any result
    if ($user && $user->num_rows > 0) {
        // Fetch the data
        $meta = $user->fetch_array();
    } else {
        // Handle the case where no user is found
        echo '<script> alert("User not found."); location.replace("accounts.php");</script>';
    }
}

if (isset($_POST['update'])) {
    $Id = $_GET['Id'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $type = $_POST['type'];
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $copassword = $_POST['copassword'];

    // Check if a new password is provided
    if (!empty($password) && $password === $copassword) {
        // Hash the password using MD5
        $hashed_password = md5($password);
        // Update the user with the new password
        mysqli_query($conn, "UPDATE tableaccount SET password='$hashed_password' WHERE Id = '$Id'") or die(mysqli_error());
    }

    // Check if an image file was uploaded
    if ($_FILES["image"]["error"] == 0) {
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = $_FILES["image"]["size"];

        // Check the image file size
        if ($image_size > 10000000) {
            die("File size is too big!");
        }

        // Move the uploaded image to the server
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image_name);

        // Update the user with the new image
        mysqli_query($conn, "UPDATE tableaccount SET fname='$fname', mname='$mname', lname='$lname', email='$email', gender='$gender', type='$type', uname='$uname', image='$image_name' WHERE Id = '$Id'") or die(mysqli_error());
    } else {
        // Update the user without changing the image
        mysqli_query($conn, "UPDATE tableaccount SET fname='$fname', mname='$mname', lname='$lname', email='$email', gender='$gender', type='$type', uname='$uname' WHERE Id = '$Id'") or die(mysqli_error());
    }

   // Output JavaScript code for confirmation modal
 echo '
 <script>
     $(document).ready(function() {
         $("#confirmationModal").modal("show");
     });
 </script>
';
    echo "<script>alert('Successfully Update customer Info!'); window.location='customer.php'</script>";
}

?>


<!-- Include these links to the head section of your HTML -->
<link rel="stylesheet" type="text/css" href="DataTables-1.13.8/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/js/jquery.dataTables.js"></script>


<section class="home-section">
    <div class="text col-lg-11" style="background-color: #182061; color: white; height: 100px"><p style="margin: 18px;"><i class="bi bi-pencil-square"></i> EDIT ACCOUNT</p></div>
    <br><br>
    <div class="container justify-content-center" style="margin-top: -5em;">
        <div class="col-lg-11 col-md-6 col-sm-11 col-xs-11">
            <div class="card rounded-0 shadow">
                <div class="card-body">
                    <div class="container-fluid">
                       <form method="POST" id="billing-form" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= isset($meta['Id']) ? $meta['Id'] : '' ?>">
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">First name</label>
                                <input type="text" class="form-control form-control-sm rounded-0" 
                                       name="fname" required="required"
                                    
                                       value="<?= isset($meta['fname']) ? $meta['fname'] : '' ?>"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Middle name</label>
                                <input type="text" class="form-control form-control-sm rounded-0"                                       name="mname" required="required"
                                       
                                       value="<?= isset($meta['mname']) ? $meta['mname'] : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Last name</label>
                                <input type="text" class="form-control form-control-sm rounded-0" 
                                       name="lname" required="required"
                                       
                                       value="<?= isset($meta['lname']) ? $meta['lname'] : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Email</label>
                                <input type="text" class="form-control form-control-sm rounded-0" 
                                       name="email" required="required"
                                       
                                       value="<?= isset($meta['email']) ? $meta['email'] : '' ?>"/>
                            </div>
                             <div class="form-group mb-3">
                                <label for="status" class="control-label">Gender</label>
                                <select name="gender"
                                        class="form-control form-control-sm rounded-0" required>
                                    <option disabled>Select gender</option>
                             <option <?php if ($meta['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                             <option <?php if ($meta['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                             <option <?php if ($meta['gender'] == 'Others') echo 'selected'; ?>>Others</option>
                                    <option value="1" <?php echo isset($meta['status']) && $meta['status'] == 1 ? 'selected' : '' ?>>
                                        Paid
                                    </option>
                                </select>
                            </div>
                            
                             <div class="form-group mb-3">
                                <label for="status" class="control-label">User Type</label>
                                <select name="type" 
                                        class="form-control form-control-sm rounded-0" required>
                                     <option disabled>Select type</option>
                          <option <?php if ($meta['type'] == 'Admin') echo 'selected'; ?>>Admin</option>
                          <option <?php if ($meta['type'] == 'Staff') echo 'selected'; ?>>Staff</option>
                         </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Username</label>
                                <input type="text" class="form-control form-control-sm rounded-0" id="previous"
                                       name="uname" 
                                       readonly
                                       value="<?= isset($meta['uname']) ? $meta['uname'] : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Password</label>
                                <input type="password" class="form-control form-control-sm rounded-0"
                                       name="password" 
                                       
                                       value="<?= isset($meta['password']) ? $meta['password'] : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Confirm Password</label>
                                <input type="password" class="form-control form-control-sm rounded-0" 
                                       name="copassword" 
                                       
                                       value="<?= isset($meta['copassword']) ? $meta['copassword'] : '' ?>"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Profile</label>
                                <input type="file" class="form-control form-control-sm rounded-0" style="height: 35px;" id="previous"
                                       name="image" required="required"
                                       readonly
                                       value="<?= isset($meta['image']) ? $meta['image'] : '' ?>"/>
                            </div>
                            
                        </form>
                    </div><br>
                    <div class="text-center" style="margin: 10px;">
                        <button class="btn btn-primary btn-sm bg-gradient-primary rounded-0" data-toggle="modal" data-target="#confirmationModal">
                            <i class="fa fa-save"></i> Update
                        </button>
                        <a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="accounts.php">
                            <i class="fa fa-angle-left"></i> Cancel
                        </a>
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
            <button type="submit" class="btn btn-success" form="billing-form" name="update">Save</button>

            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
        </div>
    </div>
</div>

