
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>RRBMS | Ebilling</title>
    <!--<link rel="stylesheet" href="style.css" />-->
    <!-- Boxicons CDN Link -->
  <link rel="stylesheet" href="Bootstrap/boxicons-master/css/boxicons.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Include these links to the head section of your HTML -->
   <link rel="stylesheet" type="text/css" href="DataTables-1.13.8/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.13.8/js/jquery.dataTables.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  
  <link rel="stylesheet" href="bootstrap-4.6.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="boostrap-icon/bootstrap-icon/font/bootstrap-icons.css">
  <script src="bootstrap-4.6.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
/* Google Font Link */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins" , sans-serif;
}
.sidebar{
  position: fixed;
  left: 0;
  top: 0;
  height: 100%;
  width: 78px;
  background: #182061;
  padding: 6px 14px;
  z-index: 99;
  transition: all 0.5s ease;
}
.sidebar.open{
  width: 250px;
}
.sidebar .logo-details{
  height: 60px;
  display: flex;
  align-items: center;
  position: relative;
}
.sidebar .logo-details .icon{
  opacity: 0;
  transition: all 0.5s ease;
}
.sidebar .logo-details .logo_name{
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  opacity: 0;
  transition: all 0.5s ease;
}
.sidebar.open .logo-details .icon,
.sidebar.open .logo-details .logo_name{
  opacity: 1;
}
.sidebar .logo-details #btn{
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  font-size: 22px;
  transition: all 0.4s ease;
  font-size: 23px;
  text-align: center;
  cursor: pointer;
  transition: all 0.5s ease;
}
.sidebar.open .logo-details #btn{
  text-align: right;
}
.sidebar i{
  color: #fff;
  height: 60px;
  min-width: 50px;
  font-size: 28px;
  text-align: center;
  line-height: 60px;
}
.sidebar .nav-list{
  margin-top: 20px;
  height: 100%;
}
.sidebar li{
  position: relative;
  margin: 8px 0;
  list-style: none;
}
.sidebar li .tooltip{
  position: absolute;
  top: -20px;
  left: calc(100% + 15px);
  z-index: 3;
  background: #fff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 15px;
  font-weight: 400;
  opacity: 0;
  white-space: nowrap;
  pointer-events: none;
  transition: 0s;
}
.sidebar li:hover .tooltip{
  opacity: 1;
  pointer-events: auto;
  transition: all 0.4s ease;
  top: 50%;
  transform: translateY(-50%);
}
.sidebar.open li .tooltip{
  display: none;
}
.sidebar input{
  font-size: 15px;
  color: #FFF;
  font-weight: 400;
  outline: none;
  height: 50px;
  width: 100%;
  width: 50px;
  border: none;
  border-radius: 12px;
  transition: all 0.5s ease;
  background: #1d1b31;
}
.sidebar.open input{
  padding: 0 20px 0 50px;
  width: 100%;
}
.sidebar .bx-search{
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  font-size: 22px;
  background: #1d1b31;
  color: #FFF;
}
.sidebar.open .bx-search:hover{
  background: #1d1b31;
  color: #FFF;
}
.sidebar .bx-search:hover{
  background: #FFF;
  color: #11101d;
}
.sidebar li a{
  display: flex;
  height: 100%;
  width: 100%;
  border-radius: 12px;
  align-items: center;
  text-decoration: none;
  transition: all 0.4s ease;
  background: #182061;
}
.sidebar li a:hover{
  background: #FFF;
}
.sidebar li a .links_name{
  color: #fff;
  font-size: 15px;
  font-weight: 400;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: 0.4s;
}
.sidebar.open li a .links_name{
  opacity: 1;
  pointer-events: auto;
}
.sidebar li a:hover .links_name,
.sidebar li a:hover i{
  transition: all 0.5s ease;
  color: #11101D;
}
.sidebar li i{
  height: 50px;
  line-height: 50px;
  font-size: 18px;
  border-radius: 12px;
}
.sidebar li.profile{
  position: fixed;
  height: 60px;
  width: 78px;
  left: 0;
  bottom: -12px;
  padding: 10px 14px;
  background: #1d1b31;
  transition: all 0.5s ease;
  overflow: hidden;
}
.sidebar.open li.profile{
  width: 250px;
}
.sidebar li .profile-details{
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
}
.sidebar li img{
  height: 45px;
  width: 45px;
  object-fit: cover;
  border-radius: 6px;
  margin-right: 10px;
}
.sidebar li.profile .name,
.sidebar li.profile .job{
  font-size: 15px;
  font-weight: 400;
  color: #fff;
  white-space: nowrap;
}
.sidebar li.profile .job{
  font-size: 12px;
}
.sidebar .profile #log_out{
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  background: #1d1b31;
  width: 100%;
  height: 60px;
  line-height: 60px;
  border-radius: 0px;
  transition: all 0.5s ease;
}
.sidebar.open .profile #log_out{
  width: 50px;
  background: none;
}
.home-section{
  position: relative;
  background: #E4E9F7;
  min-height: 100vh;
  top: 0;
  left: 78px;
  width: calc(100% - 78px);
  transition: all 0.5s ease;
  z-index: 2;
}
.sidebar.open ~ .home-section{
  left: 250px;
  width: calc(100% - 250px);
}
.home-section .text{
  display: inline-block;
  color: #11101d;
  font-size: 25px;
  font-weight: 500;
  margin: 18px
}
@media (max-width: 420px) {
  .sidebar li .tooltip{
    display: none;
  }
}

    </style>
  </head>
  <body>
  <?php
include 'config.php';
  if (isset($_SESSION['uname'])) {
    $uname = $_SESSION['uname'];
} else {
    // Handle the case when the session variable is not set, redirect or show an error.
    header("Location: index.php");
    exit();
}

$query  = mysqli_query($conn, "SELECT * FROM tableaccount WHERE uname = '$uname'") or die(mysqli_error());
$row = mysqli_fetch_array($query);
$type  = $row['type'];
?>

    <div class="sidebar">
      <div class="logo-details">
        <i class="bx bx-building-house icon"></i>
        <div class="logo_name">E Billing</div>
        <i class="bx bx-menu" id="btn"></i>
      </div>
      <ul class="nav-list">
        <li>
        <li>
          <a href="dashboard.php">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Dashboard</span>
          </a>
          <span class="tooltip">Dashboard</span>
        </li>
        <?php if ($type == 'Admin'): ?>
        <li>
          <a href="customer.php">
            <i class="bx bx-group"></i>
            <span class="links_name">Homeowners</span>
          </a>
          <span class="tooltip">Homeowners</span>
        </li>
        <?php endif; ?>
        <li>
          <a href="billing.php">
            <i class="bx bx-pie-chart-alt-2"></i>
            <span class="links_name">Billing</span>
          </a>
          <span class="tooltip">Billing</span>
        </li>
        <li>
          <a href="billing_transaction.php">
            <i class="bi bi-table"></i>
            <span class="links_name">Transaction</span>
          </a>
          <span class="tooltip">Transaction</span>
        </li>
        
        <?php if ($type == 'Admin'): ?>
        <li>
          <a href="accounts.php">
            <i class="bx bx-user"></i>
            <span class="links_name">Account</span>
          </a>
          <span class="tooltip">Account</span>
        </li>
        <?php endif; ?>
        <li>
          <a href="monthlyreport.php">
            <i class="bx bx-folder"></i>
            <span class="links_name">Monthly Report</span>
          </a>
          <span class="tooltip">Monthly Report</span>
        </li>
        <li>
          <a href="complaint.php">
            <i class="bx bx-envelope"></i>
            <span class="links_name">Complaint</span>
          </a>
          <span class="tooltip">Complaint</span>
        </li>
        
        <?php if ($type == 'Admin'): ?>
        <li>
          <a href="settings.php">
            <i class="bx bx-cog"></i>
            <span class="links_name">Setting</span>
          </a>
          <span class="tooltip">Setting</span>
        </li>
        <?php endif; ?>

<?php 
include ('config.php');
if (isset($_SESSION['uname'])) {
$uname = $_SESSION['uname'];
} else {
  // Handle the case when the session variable is not set, redirect or show an error.
  header("Location: index.php");
  exit();
}

$conn_String = mysqli_connect("localhost", "root", "", "billing");
$stmt = $conn_String->prepare("SELECT * FROM tableaccount WHERE uname = ?");
$stmt->bind_param("s", $uname);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$query = mysqli_query($conn, "SELECT Id, type, uname,image from tableaccount");
if (mysqli_num_rows($query) > 0){
     $row = mysqli_fetch_assoc($query);
     if(isset($row['image'])&& $row['image'] != ""){
     }
 }
 
?>

<li class="profile">
            <div class="profile-details">
            <a href="View_Account.php?<?php echo 'uname=' .$uname; ?>" style="text-decoration: none; width: 48px;"> 

          <?php if ($result['image'] != ""): ?>
           
            <img src="uploads/<?php echo $result['image']; ?>" alt="Profile Image">
                      <?php else: ?>
                        <img src="images/users.png" alt="Default Image">
          <?php endif; ?>
          <div class="name_job">
              <div class="name"><?php echo $result['uname']; ?></div>
              <div class="job"><?php echo $result['type']; ?></div>                                
            </div>
            </a>
          </div>
          <a href="logout.php" style="color: white; text-decoration: none;">          
          <i class="bx bx-log-out" id="log_out"></i>
        </li>
        </a>
    
      </ul>

    </div>
    
    <!--<section class="home-section">
      <div class="text">Dashboard</div>
    </section>-->

    <script>
      let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)
});

searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});

// following are the code to change sidebar button(optional)
function menuBtnChange() {
 if(sidebar.classList.contains("open")){
   closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
 }else {
   closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
 }
}

    </script>
    
  </body>
</html>
