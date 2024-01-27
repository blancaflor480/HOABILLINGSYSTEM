<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php?error=Login%20First");
    die();
}

include 'config.php';

$email = $_SESSION['email'];
$conn_String = mysqli_connect("localhost", "root", "", "billing");

// Fetch user data
$stmt = $conn_String->prepare("SELECT * FROM tableusers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result) {
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

        // Check the image file size
        if ($image_size > 10000000) {
            die("File size is too big!");
        }

        // Move the uploaded image to the server
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image_name);

        // Update the user with the new image using WHERE clause
        $stmt = $conn_String->prepare("UPDATE tableusers SET fname=?, mname=?, lname=?, bday=?, contact=?, 
        gender=?, address=?, category=?, image=? WHERE email = ?");
        $stmt->bind_param("ssssssssss", $fname, $mname, $lname, $bday, $contact, $gender, $address, $category, $image_name, $email);
        $stmt->execute();
    } else {
        // Update the user without changing the image using WHERE clause
        $stmt = $conn_String->prepare("UPDATE tableusers SET fname=?, mname=?, lname=?, bday=?, contact=?,
        gender=?, address=?, category=? WHERE email = ?");
        $stmt->bind_param("sssssssss", $fname, $mname, $lname, $bday, $contact, $gender, $address, $category, $email);
        $stmt->execute();
    }
}

?>

<?php include('Sidebar.php');?>

<!-- Include these links to the head section of your HTML -->
<link rel="stylesheet" type="text/css" href="DataTables-1.13.8/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/js/jquery.dataTables.js"></script>

<style>  
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
*{
  font-family: 'Poppins', sans-serif;
}
.container{
    position: flex;
    padding: 0px;
    margin: 0px;
    margin-left: 5px;  
  }
.container header{
    position: relative;
    font-size: 20px;
    font-weight: 600;
    color: #333;
}
.container header::before{
    content: "";
    position: absolute;
    left: 0;
    bottom: -2px;
    height: 3px;
    width: 27px;
    border-radius: 8px;
    background-color: #4070f4;
}
.container form{
    position: relative;
    margin-top: 16px;
    min-height: 550px;
    background-color: #fff;
    overflow: hidden;
}
.container form .form{
    position: absolute;
    background-color: #fff;
    transition: 0.3s ease;
}
.container form .form.second{
    opacity: 0;
    pointer-events: none;
    transform: translateX(100%);
}
form.secActive .form.second{
    opacity: 1;
    pointer-events: auto;
    transform: translateX(0);
}
form.secActive .form.first{
    opacity: 0;
    pointer-events: none;
    transform: translateX(-100%);
}
.container form .title{
    display: block;
    margin-bottom: 8px;
    font-size: 16px;
    font-weight: 500;
    margin: 6px 0;
    color: #333;
}
.container form .fields{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
form .fields .input-field{
    display: flex;
    width: calc(100% / 3 - 15px);
    flex-direction: column;
    margin: 4px 0;
}
.input-field label{
    font-size: 12px;
    font-weight: 500;
    color: #2e2e2e;
}
.input-field input, select{
    outline: none;
    font-size: 14px;
    font-weight: 400;
    color: #333;
    border-radius: 5px;
    border: 1px solid #aaa;
    padding: 0 15px;
    height: 42px;
    margin: 8px 0;
}
.input-field input :focus,
.input-field select:focus{
    box-shadow: 0 3px 6px rgba(0,0,0,0.13);
}
.input-field select,
.input-field input[type="date"]{
    color: #707070;
}
.input-field input[type="date"]:valid{
    color: #333;
}
.container form button, .backBtn{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 45px;
    max-width: 150px;
    width: 100%;
    border: none;
    outline: none;
    color: #fff;
    border-radius: 5px;
    margin: 25px 0;
    background-color: #4070f4;
    transition: all 0.3s linear;
    cursor: pointer;
}
.container form .btnText{
    font-size: 14px;
    font-weight: 400;
}
form button:hover{
    background-color: #265df2;
}
form button i,
form .backBtn i{
    margin: 0 6px;
}
form .backBtn i{
    transform: rotate(180deg);
}
form .buttons{
    display: flex;
    align-items: center;
}
form .buttons button , .backBtn{
    margin-right: 15px;
}

@media (max-width: 750px) {
    .container form{
        overflow-y: scroll;
    }
    .container form::-webkit-scrollbar{
       display: none;
    }
    form .fields .input-field{
        width: calc(100% / 2 - 15px);
    }
}

@media (max-width: 550px) {
    form .fields .input-field{
        width: 100%;
    }
}
#confirmationModal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    z-index: 1000;
    text-align: center;
    background-color: #182061;
}

#confirmationModal .modal-content {
    margin: 0;
    padding: 0;
    }

#confirmationModal button {
    margin: 10px;
    border: 1px #ccc;
    border-radius: 0.3rem;
    width: 120px;
    cursor: pointer;
    height: 35px;
}

</style>

<section class="home-section">
<div class="text"><i class="bi bi-person-lines-fill"></i>&nbsp;Personal Information</div>
    <div class="col-md-12">
        <div class="card">
          <h5 class="card-header" style="background-color: #182061; color: white;">Personal Details
           </h5>
          <div class="card-body">
    <div class="container" style="margin-left: 70px">        
<form method="POST" enctype="multipart/form-data" id="updateForm">

    <input type="hidden" name="id" value="<?= isset($meta['id']) ? $meta['id'] : '' ?>">
            
            <div class="form first">
        <spant style="display: flex; justify-content:center" class="title; ">
        <?php if($result['image'] != ""): ?>
        <img style="border:4px groove #CCCCCC; border-radius:5px; width:100px; height: 100px;"  
        src="uploads/<?php echo $result['image']; ?>"  style="max-width: 100px; max-height: 100px;">
    <?php else: ?>
        <img src="images/users.png" width="100px" height="100px" style="border:4px groove #CCCCCC; border-radius:5px;">
    <?php endif; ?>
        </spant>        
            <div class="details personal">
                
                 
                   <div class="fields">
                        <div class="input-field">
                            <label>First Name</label>
                            <input type="text" name="fname" value="<?php echo $result['fname']; ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Middle Name</label>
                            <input type="text" name="mname" value="<?php echo $result['mname']; ?>"  required>
                        </div>

                        <div class="input-field">
                            <label>Last Name</label>
                            <input type="text" name="lname" value="<?php echo $result['lname']; ?>"  required/>
                        </div>


                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" name="bday" value="<?php echo $result['bday']; ?>"  required>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $result['email']; ?>" required disabled>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" name="contact" value="<?php echo $result['contact']; ?>"  required>
                        </div>

                        <div class="input-field">
                          <label>Gender</label>
                             <select name="gender" required>
                             <option disabled>Select gender</option>
                             <option <?php if ($result['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                             <option <?php if ($result['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                             <option <?php if ($result['gender'] == 'Others') echo 'selected'; ?>>Others</option>
                          </select>
                        </div>

                        <div class="input-field">
                            <label>Address</label>
                            <input type="text" name="address" value="<?php echo $result['address']; ?>"  required>
                        </div>
                    
                    <div class="input-field">
                         <label>Category</label>
                          <select name="category" required>
                          <option disabled>Select category</option>
                          <option <?php if ($result['category'] == 'Residences') echo 'selected'; ?>>Residences</option>
                          <option <?php if ($result['category'] == 'Business') echo 'selected'; ?>>Business</option>
                          <option <?php if ($result['category'] == 'Others') echo 'selected'; ?>>Others</option>
                        </select>
                    </div>
                    
                    <div class="input-field">
                            <label>Image</label>
                            <input style="width: 1100px; background-color: #D5D8DC; padding: 6px;" name="image" type="file" value="<?php echo isset($result['image']) ? $result['image']: '' ?>">
                    </div>
                    
                    
<br>
                    <div class="input-field">
                            <input style="width: 365px;padding: 6px;" type="hidden">
                    </div>

                   
                     
                    <div style="display: flex; justify-content: center; width: 1100px;">
                    <button type="button" style="background-color: darkgreen;" onclick="confirmUpdate()">
                        <span class="btnText">Update</span>&nbsp;
                        <i class="bi bi-cloud-download"></i>
                    </button>

                             &nbsp;&nbsp;
                        
                        <button type="button" data-toggle="modal" data-target="#Changepass" style=" background-color: #182061;">
                            <span class="btnText">Change Password</span>
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        
                        
                        </div>
                        
                      </div>
                    
                </div>
               </div> 
            </div>
           

        </form>
    
    </div>
            </div>
        </div>
      </div>
   
</section>
<!-- Confirmation Modal -->
<div id="confirmationModal">
    <div class="modal-content">
        <br>
        <p style="font-size: 1rem; font-family: Poppins; font-weight: 500">Are you sure you want to update?</p>
        <div class="modal-footer">
            <button class="btn btn-success" name="update" onclick="confirmedUpdate()">Yes</button>
            <button class="btn btn-secondary" onclick="closeConfirmation()">No</button>
        </div>
    </div>
</div>

<!---->
 <script>
function confirmUpdate() {
    document.getElementById('confirmationModal').style.display = 'block';
}

function confirmedUpdate() {
    // If user confirms, submit the form
    document.getElementById('updateForm').submit();
}

function closeConfirmation() {
    document.getElementById('confirmationModal').style.display = 'none';
}
</script>

<?php include('Changepassword.php'); ?>