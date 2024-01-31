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

?>


<!-- Include these links to the head section of your HTML -->
<link rel="stylesheet" type="text/css" href="DataTables-1.13.8/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/js/jquery.dataTables.js"></script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
    *{
        font-family: "Poppins" , sans-serif;
    }
</style>

<section class="home-section">
    <div class="text col-lg-11" style="background-color: #182061; color: white; height: 100px"><p style="margin: 18px;">
    <i class="bi bi-person-circle"></i> View Account</p></div>
    <br><br>
    <div class="container justify-content-center" style="margin-top: -5em;">
        <div class="col-lg-11 col-md-6 col-sm-11 col-xs-11">
            <div class="card rounded-0 shadow">
                <div class="card-body">
                    <div class="container-fluid">
                       <form method="POST" id="billing-form" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= isset($meta['uname']) ? $meta['uname'] : '' ?>">
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
                                       name="fname" disabled
                                    
                                       value="<?= isset($meta['fname']) ? $meta['fname'] : '' ?>"/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Middle name</label>
                                <input type="text" class="form-control form-control-sm rounded-0"                                       
                                name="mname" disabled
                                       
                                       value="<?= isset($meta['mname']) ? $meta['mname'] : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Last name</label>
                                <input type="text" class="form-control form-control-sm rounded-0" 
                                       name="lname" disabled
                                       
                                       value="<?= isset($meta['lname']) ? $meta['lname'] : '' ?>"/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Email</label>
                                <input type="text" class="form-control form-control-sm rounded-0" 
                                       name="email" disabled
                                       
                                       value="<?= isset($meta['email']) ? $meta['email'] : '' ?>"/>
                            </div>
                             <div class="form-group mb-3">
                                <label for="status" class="control-label">Gender</label>
                                <select name="gender"
                                        class="form-control form-control-sm rounded-0" disabled>
                                    <option disabled>Select gender</option>
                             <option <?php if ($meta['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                             <option <?php if ($meta['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                             <option <?php if ($meta['gender'] == 'Others') echo 'selected'; ?>>Others</option>
                                </select>
                            </div>
                            
                             <div class="form-group mb-3">
                                <label for="status" class="control-label">User Type</label>
                                <select name="type" 
                                        class="form-control form-control-sm rounded-0" disabled>
                                     <option disabled>Select type</option>
                          <option <?php if ($meta['type'] == 'Admin') echo 'selected'; ?>>Admin</option>
                          <option <?php if ($meta['type'] == 'Staff') echo 'selected'; ?>>Staff</option>
                         </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tableusers_id" class="control-label">Username</label>
                                <input type="text" class="form-control form-control-sm rounded-0" id="previous"
                                       name="uname" 
                                       disabled
                                       value="<?= isset($meta['uname']) ? $meta['uname'] : '' ?>"/>
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
                        <a href="Edit_Account_session.php?<?php echo 'uname=' . $uname; ?>" class="btn btn-primary btn-sm bg-gradient-primary rounded-0">
                            <i class="fa fa-save"></i> Edit Account
                        </a>
                        <a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="dashboard.php">
                            <i class="fa fa-angle-left"></i> Close
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</section>

