
<?php
include ('config.php');
include ('sidebar.php');

if (isset($_GET['Id'])) {
    $user = $conn->query("SELECT * FROM tableaccount WHERE Id ='{$_GET['Id']}' ");

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
    if (!empty($password)) {
        // Hash the password
        $hashed_password = mysqli_real_escape_string($conn, md5($password));
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

    echo "<script>alert('Successfully Update Admin Info!'); window.location='accounts.php'</script>";
}

?>






<style>
.page-title{
 margin: 15px;
 background-color: yellow;
}
.page-title small{
 font-size: 0.8rem;
 }

.col-div-8{
    background-color: green;
}
.card{
    margin: 15px;
}
.card-header{
    font-weight: 500;
}
form{
     padding-left: 5%;
}

</style>

<section class="home-section">
      <div class="text">Accounts</div>
<div class="page-title">
      <small>Admin Profile /</small> Edit Admin
</div>        
<div class="card">
  <div class="card-header">
    <i class="bx bx-edit"></i> Edit Profile
  </div>
  <div class="card-body">
  <div class="form-body">


<form method="POST" enctype="multipart/form-data" >
<input type="hidden" name="Id" value="<?= isset($meta['Id']) ? $meta['Id'] : '' ?>">
				
<div class="form-group" style="margin-left: 530px; background-color: yellow; width:  100px">
    <?php if($meta['image'] != ""): ?>
        <img style="border:4px groove #CCCCCC; border-radius:5px; width:100px; height: 100px;"  
        src="uploads/<?php echo $meta['image']; ?>" alt="" style="max-width: 100px; max-height: 100px;">
    <?php else: ?>
        <img src="images/users.png" width="100px" height="100px" style="border:4px groove #CCCCCC; border-radius:5px;">
    <?php endif; ?>
    
</div>


<div class="form-group">
    <label class="text control-label col-lg-3 text-left" style="font-size: 1rem; color: black;">Full Name</label>
    <input style="padding-left:6px;width:147px; height: 30px; background-color:#E5E7E9; font-size: 0.9rem;" type="text" name="fname" id="fname" value="<?php echo isset($meta['fname']) ? $meta['fname']: '' ?>">
    <input style="padding-left:6px;width:147px; height: 30px; background-color:#E5E7E9;  font-size: 0.9rem;" type="text" name="mname" id="mname" value="<?php echo isset($meta['mname']) ? $meta['mname']: '' ?>">
    <input style="padding-left:6px;width:147px; height: 30px; background-color:#E5E7E9;  font-size: 0.9rem;" type="text" name="lname" id="lname" value="<?php echo isset($meta['lname']) ? $meta['lname']: '' ?>">
</div>
<div class="form-group" style="margin-top: -30px;">
    <label class="text control-label col-lg-3 text-left" style="font-size: 1rem; color: black; ">Email</label>
    <input style="padding-left:6px;width:450px; height: 30px; background-color:#E5E7E9; font-size: 0.9rem;" type="text" name="email" id="email" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>"> 
</div>

<div class="form-group" style="margin-top: -30px; display: flex;">
    <label class="text control-label col-lg-3 text-left" style="font-size: 1rem; color: black; ">Gender</label>
    <select class="select2_single form-control" style="padding-left:6px;width:450px; height: 30px; margin-left:4px;margin-top: 8px; background-color:#E5E7E9; font-size: 0.9rem;" name="gender" tabindex="-1" required>
    <option <?php echo ($meta['gender'] == 'Male') ? 'selected' : ''; ?> value="Male">Male</option>
    <option <?php echo ($meta['gender'] == 'Female') ? 'selected' : ''; ?> value="Female">Female</option>
</select>

</div>


<div class="form-group" style="margin-top: -30px; display: flex;">
    <label class="text control-label col-lg-3 text-left" style="font-size: 1rem; color: black; ">User Type</label>
    <select class="select2_single form-control" style="padding-left:6px;width:450px; height: 30px; margin-left:4px;margin-top: 8px; background-color:#E5E7E9; font-size: 0.9rem;" name="type" tabindex="-1" required>
    <option <?php echo ($meta['type'] == 'Admin') ? 'selected' : ''; ?> value="Admin">Admin</option>
    <option <?php echo ($meta['type'] == 'Staff') ? 'selected' : ''; ?> value="Staff">Staff</option>
</select>
</div>

<div class="form-group" style="margin-top: -30px;">
    <label class="text control-label col-lg-3 text-left" style="font-size: 1rem; color: black; ">Username</label>
    <input style="padding-left:6px;width:450px; height: 30px; background-color:#E5E7E9; font-size: 0.9rem;" type="text" name="uname" id="uname" value="<?php echo isset($meta['uname']) ? $meta['uname']: '' ?>"> 
</div>
<div class="form-group" style="margin-top: -30px;">
    <label class="text control-label col-lg-3 text-left" style="font-size: 1rem; color: black; ">Password</label>
    <input style="padding-left:6px;width:450px; height: 30px; background-color:#E5E7E9; font-size: 0.9rem;" type="password" name="password" id="password" value="<?php echo isset($meta['password']) ? $meta['password']: '' ?>"> 
</div>
<div class="form-group" style="margin-top: -30px;">
    <label class="text control-label col-lg-3 text-left" style="font-size: 1rem; color: black; ">Confirm Password</label>
    <input style="padding-left:6px;width:450px; height: 30px; background-color:#E5E7E9; font-size: 0.9rem;" type="password" name="copassword" id="copassword" value="<?php echo isset($meta['copassword']) ? $meta['copassword']: '' ?>"> 
</div>


<div class="form-group" style="margin-top: -30px;">
    <label class="text control-label col-lg-3 text-left" style="font-size: 1rem; color: black; ">Profile image</label>
    <input style="padding-left:6px;width:450px; height: 30px; background-color:#E5E7E9; font-size: 0.9rem;" type="file" name="image" accept="image/*">
</div>


<div class="form-group mt-3 d-flex justify-content-center" style="background-color: yellow; padding: 5px; margin-right: 110px;" >
                        <a href="accounts.php" class="btn btn-primary" style=" font-size: 0.9rem; margin-right: 10px;">
                            <i class="fa fa-times-circle-o"></i> Cancel
                        </a>
                        <button type="submit" name="update" class="btn btn-success" style="font-size: 0.9rem;">
                            <i class="bx bx-save"></i> Update
                        </button>
                    </div>
</form>
    </div>
    </div>
</div>

</section>


















