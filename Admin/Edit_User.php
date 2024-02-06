<?php
session_start();
include('config.php');
include('sidebar.php');

if (isset($_GET['Id'])) {
    $user = $conn->query("SELECT * FROM tableusers WHERE Id ='{$_GET['Id']}' ");

    if ($user && $user->num_rows > 0) {
        $meta = $user->fetch_array();
    } else {
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
    $bday = $_POST['bday'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $category = $_POST['category'];
    $password = $_POST['password'];
    $copassword = $_POST['copassword'];

   // Check if a new password is provided
   if (!empty($password) && $password === $copassword) {
    // Hash the password using MD5
    $hashed_password = md5($password);
    // Update the user with the new password using parameterized query
    $stmt = $conn->prepare("UPDATE tableusers SET password=? WHERE Id=?");
    $stmt->bind_param("si", $hashed_password, $Id);
    $stmt->execute();
    $stmt->close();
}
    // Check if an image file was uploaded
    if ($_FILES["image"]["error"] == 0) {
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = $_FILES["image"]["size"];

        if ($image_size > 10000000) {
            die("File size is too big!");
        }

        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image_name);

        // Update the user with the new image using parameterized query
        $stmt = $conn->prepare("UPDATE tableusers SET fname=?, mname=?, lname=?, email=?,  bday=?,, gender=?, contact=?, address=?, category=?, image=? WHERE Id=?");
        $stmt->bind_param("ssssssssssi", $fname, $mname, $lname, $email, $bday, $gender, $contact, $address, $category, $image_name, $Id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Update the user without changing the image using parameterized query
        $stmt = $conn->prepare("UPDATE tableusers SET fname=?, mname=?, lname=?, email=?, bday=?, gender=?, contact=?, address=?, category=? WHERE Id=?");
        $stmt->bind_param("sssssssssi", $fname, $mname, $lname, $email, $bday, $gender, $contact, $address, $category, $Id);
        $stmt->execute();
        $stmt->close();
    }
 // Output JavaScript code for confirmation modal
 echo '
 <script>
     $(document).ready(function() {
         $("#confirmationModal").modal("show");
     });
 </script>
';
    echo "<script>alert('Successfully Update Homeowners Info!'); window.location='customer.php'</script>";
}
?>


    <!-- Include these links to the head section of your HTML -->
    <link rel="stylesheet" type="text/css" href="DataTables-1.13.8/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="DataTables-1.13.8/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="DataTables-1.13.8/js/jquery.dataTables.js"></script>

    <section class="home-section">
    <div class="text col-lg-11" style="background-color: #182061; color: white; height: 100px"><p style="margin: 18px;"><small>Homeowners</small> > <i class="bi bi-pencil-square"></i> EDIT HOMEOWNER DETAILS</p></div>
    <br><br>
    <div class="container justify-content-center" style="margin-top: -5em;">
        <div class="col-lg-11 col-md-6 col-sm-11 col-xs-11">
            <div class="card rounded-0 shadow">
                <div class="card-body">
                    <div class="container-fluid">
                       <form method="POST" id="billing-form" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= isset($meta['Id']) ? $meta['Id'] : '' ?>">
                            <div class="form-group mb-3 text-center">
                                <label for="tableusers_id" class="control-label">Profile</label>
                                <!-- Display the image with centering -->
                                <div class="d-flex justify-content-center">
                                    <img src="uploads/<?= isset($meta['image']) ? $meta['image'] : 'users.png' ?>" alt="Profile Image" class="img-thumbnail" style="max-width: 100px; height: auto;">
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">First name</label>
                                <input type="text" class="form-control form-control-sm rounded-0" 
                                       name="fname" style="background-color: #DEDEDE;" required="required"
                                    
                                       value="<?= isset($meta['fname']) ? $meta['fname'] : '' ?>"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Middle name</label>
                                <input type="text" class="form-control form-control-sm rounded-0"                                       name="mname" style="background-color: #DEDEDE;" required="required"
                                       
                                       value="<?= isset($meta['mname']) ? $meta['mname'] : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Last name</label>
                                <input type="text" class="form-control form-control-sm rounded-0" 
                                       name="lname" style="background-color: #DEDEDE;" required="required"
                                       
                                       value="<?= isset($meta['lname']) ? $meta['lname'] : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Email</label>
                                <input type="text" class="form-control form-control-sm rounded-0" 
                                       name="email" required="required"
                                       
                                       value="<?= isset($meta['email']) ? $meta['email'] : '' ?>"/>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Birthday</label>
                                <input type="date" class="form-control form-control-sm rounded-0" 
                                       name="bday" required="required"
                                       
                                       value="<?= isset($meta['bday']) ? $meta['bday'] : '' ?>"/>
                            </div>
                           
                             <div class="form-group mb-3">
                                <label for="status" class="control-label">Gender</label>
                                <select name="gender"
                                        class="form-control form-control-sm rounded-0" required>
                                    <option disabled>Select gender</option>
                             <option <?php if ($meta['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                             <option <?php if ($meta['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                   
                                </select>
                            </div>
                           
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Address</label>
                                <input type="text" class="form-control form-control-sm rounded-0" 
                                       name="address" required="required"
                                       
                                       value="<?= isset($meta['address']) ? $meta['address'] : '' ?>"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status" class="control-label">Category</label>
                                <select name="category"
                                        class="form-control form-control-sm rounded-0" required>
                                    <option disabled>Select category</option>
                             <option <?php if ($meta['category'] == 'Residence') echo 'selected'; ?>>Residences</option>
                             <option <?php if ($meta['category'] == 'Non Residence') echo 'selected'; ?>>Non Residences</option>
                                   
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Contact No.</label>
                                <input type="number" class="form-control form-control-sm rounded-0" 
                                       name="contact" required="required"
                                       
                                       value="<?= isset($meta['contact']) ? $meta['contact'] : '' ?>"/>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Password</label>
                                <input type="password" class="form-control form-control-sm rounded-0"
                                       name="password" 
                                       
                                       value="<?= isset($meta['password']) ? $meta['password'] : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Confirm  Password</label>
                                <input type="password" class="form-control form-control-sm rounded-0" 
                                       name="copassword" 
                                       
                                       value="<?= isset($meta['copassword']) ? $meta['copassword'] : '' ?>"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Profile Image</label>
                                <input type="file" class="form-control form-control-sm rounded-0" style="height: 35px;" id="previous"
                                       name="image" required="required"
                                       readonly
                                       value="<?= isset($meta['image']) ? $meta['image'] : '' ?>"/>
                            </div>
                            
                        </form>
                    </div><br>
                    <div class="text-center" style="margin: 10px;">
                        <button class="btn btn-success btn-sm bg-gradient-success rounded-0" data-toggle="modal" data-target="#confirmationModal">
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
                <center>Are you sure you want to update the homeowner's information?</center>
            </div>
            <div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-success" form="billing-form" name="update">Save</button>

            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
        </div>
    </div>
</div>