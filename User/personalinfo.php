<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    die();
}

include 'config.php';
include 'Sidebar.php';

$email = $_SESSION['email'];
$conn_String = mysqli_connect("localhost", "root", "", "billing");

$stmt = $conn_String->prepare("SELECT * FROM tableusers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$meta = $stmt->get_result()->fetch_assoc();

if (!$meta) {
    header("Location: index.php?error=Login%20First");
    exit();
}

if (isset($_POST['update'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $bday = $_POST['bday'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $category = $_POST['category'];

    // Check if an image file was uploaded
    if ($_FILES["image"]["error"] == 0) {
        $image_name = addslashes($_FILES['image']['name']);
        $image_size = $_FILES["image"]["size"];

        if ($image_size > 10000000) {
            die("File size is too big!");
        }

        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image_name);

        // Update the user with the new image using parameterized query
        $stmt = $conn_String->prepare("UPDATE tableusers SET fname=?, mname=?, lname=?, bday=?, gender=?, contact=?, address=?, category=?, image=? WHERE email=?");
        $stmt->bind_param("sssssssss", $fname, $mname, $lname, $bday, $gender, $contact, $address, $category, $image_name, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo '<script>alert("Successfully Update customer Info!"); window.location="dashboard.php"</script>';
        } else {
            echo '<script>alert("Update failed!");</script>';
        }
        $stmt->close();
    } else {
        // Update the user without changing the image using parameterized query
        $stmt = $conn_String->prepare("UPDATE tableusers SET fname=?, mname=?, lname=?, bday=?, gender=?, contact=?, address=?, category=? WHERE email=?");
        $stmt->bind_param("sssssssss", $fname, $mname, $lname, $bday, $gender, $contact, $address, $category, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo '<script>alert("Successfully Update customer Info!"); window.location="dashboard.php"</script>';
        } else {
            echo '<script>alert("Update failed!");</script>';
        }
        $stmt->close();
    }
}
?>


<!-- Include these links to the head section of your HTML -->
<link rel="stylesheet" type="text/css" href="DataTables-1.13.8/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/js/jquery.dataTables.js"></script>
<section class="home-section">
    <div class="text col-lg-11" style="background-color: #182061; color: white; height: 100px"><p style="margin: 18px;"><i class="bi bi-pencil-square"></i> EDIT HOMEOWNER DETAILS</p></div>
    <br><br>
    <div class="container justify-content-center" style="margin-top: -5em;">
        <div class="col-lg-11 col-md-6 col-sm-11 col-xs-11">
            <div class="card rounded-0 shadow">
                <div class="card-body">
                    <div class="container-fluid">
                       <form method="POST" id="billing-form" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= isset($meta['email']) ? $meta['email'] : '' ?>">
                            <div class="form-group mb-3 text-center">
                                <label for="tableusers_id" class="control-label">Profile</label>
                                <!-- Display the image with centering -->
                                <div class="d-flex justify-content-center">
                                    <img src="uploads/<?= isset($meta['image']) ? $meta['image'] : 'images/users.png' ?>" alt="Profile Image" class="img-thumbnail" style="max-width: 100px; height: auto;">
                                </div>
                            </div>
                            
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
                                       name="email" disabled
                                       
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
                           <label for="category" class="control-label">category</label>
                              <select name="category" class="form-control form-control-sm rounded-0" required>
                                <option disabled>Select gender</option>
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
                                <label for="tableusers_id" class="control-label">Profile</label>
                                <input type="file" class="form-control form-control-sm rounded-0" style="height: 35px;" id="previous"
                                       name="image"                                      
                                       value="<?= isset($meta['image']) ? $meta['image'] : '' ?>"/>
                            </div>
                            
                        </form>
                    </div><br>
                    <div class="text-center" style="margin: 10px;">
                        <button class="btn btn-success btn-sm bg-gradient-primary rounded-0" data-toggle="modal" data-target="#confirmationModal">
                            <i class="fa fa-save"></i> Update
                        </button>
                        <button class="btn btn-primary btn-sm bg-gradient-primary rounded-0" data-toggle="modal" data-target="#Changepass">
                            <i class="fa fa-save"></i> Change password
                        </button>
                        <a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="dashboard.php">
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
                Are you sure you want to update the homeowner information?
            </div>
            <div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-success" form="billing-form" name="update">Save</button>

            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
        </div>
    </div>
</div>

<?php include('Changepassword.php'); ?>