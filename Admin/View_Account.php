<?php
session_start();
include ('config.php');
include ('sidebar.php');

if (isset($_GET['uname'])) {
    $user = $conn->query("SELECT * FROM tableaccount WHERE uname ='{$_GET['uname']}' ");

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
</style>

<section class="home-section">
<div class="text"><small style="font-size: 1rem">Account ></small>  View Account</div>
    <div class="col-md-12">
        <div class="card">
          <h5 class="card-header">Account Details
           </h5>
          <div class="card-body">
    <div class="container" style="margin-left: 70px">        
        <form method="POST" enctype="multipart/form-data" >
        <input type="hidden" name="uname" value="<?= isset($meta['uname']) ? $meta['uname'] : '' ?>">
            
            <div class="form first">
        <spant style="display: flex; justify-content:center" class="title; ">
        <?php if($meta['image'] != ""): ?>
        <img style="border:4px groove #CCCCCC; border-radius:5px; width:100px; height: 100px;"  
        src="uploads/<?php echo $meta['image']; ?>" alt="" style="max-width: 100px; max-height: 100px;">
    <?php else: ?>
        <img src="images/users.png" width="100px" height="100px" style="border:4px groove #CCCCCC; border-radius:5px;">
    <?php endif; ?>
        </spant>        
            <div class="details personal">
                
                 
                   <div class="fields">
                        <div class="input-field">
                            <label>First Name</label>
                            <input type="text" name="fname" value="<?php echo isset($meta['fname']) ? $meta['fname']: '' ?>" disabled>
                        </div>

                        <div class="input-field">
                            <label>Middle Name</label>
                            <input type="text" name="mname" value="<?php echo isset($meta['mname']) ? $meta['mname']: '' ?>" disabled>
                        </div>

                        <div class="input-field">
                            <label>Last Name</label>
                            <input type="text" name="lname" value="<?php echo isset($meta['lname']) ? $meta['lname']: '' ?>"  disabled/>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="text" name="email" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>"  disabled>
                        </div>

                        <div class="input-field">
                          <label>Gender</label>
                             <select name="gender" disabled>
                             <option disabled>Select gender</option>
                             <option <?php if ($meta['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                             <option <?php if ($meta['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                             <option <?php if ($meta['gender'] == 'Others') echo 'selected'; ?>>Others</option>
                          </select>
                        </div>
                    
                    <div class="input-field">
                         <label>User Type</label>
                          <select name="type" disabled>
                          <option disabled>Select type</option>
                          <option <?php if ($meta['type'] == 'Admin') echo 'selected'; ?>>Admin</option>
                          <option <?php if ($meta['type'] == 'Staff') echo 'selected'; ?>>Staff</option>
                          </select>
                    </div>
                    
                    <div class="input-field">
                            <label>Username</label>
                            <input type="text" name="uname" value="<?php echo isset($meta['uname']) ? $meta['uname']: '' ?>" disabled>
                        </div>

                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" name="password" value="<?php echo isset($meta['password']) ? $meta['password']: '' ?>" disabled>
                        </div>

                        <div class="input-field">
                            <label>Confirm Password</label>
                            <input type="password" name="copassword" value="<?php echo isset($meta['copassword']) ? $meta['copassword']: '' ?>" disabled>
                        </div>

                    <div class="input-field">
                            <label>Image</label>
                            <input style="width: 1100px; background-color: #D5D8DC; padding: 6px;" type="file" name="image" value="<?php echo isset($meta['image']) ? $meta['image']: '' ?>" disabled>
                    </div>
                     
                    <div class="input-field">
                            <label></label>
                            <input type="hidden"required>
                    </div>
                     
                    <div class="input-field">
                            <label></label>
                            <input type="hidden" required>
                    </div>
                    <div style="display: flex; justify-content: center; width: 1100px;">
                    <a href="Edit_Account.php" style="text-decoration: none; color: white; width: 150px">    
                    <button>
                            <span class="btnText">Edit</span>&nbsp;
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </a>
                        &nbsp;&nbsp;
                        <a href="accounts.php" style="text-decoration: none; color: white;">
                        <button class="sumbit" style="background-color: gray;">
                            <span class="btnText">Close</span>&nbsp;
                            <i class="bi bi-x-circle"></i>
                            </a>
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
