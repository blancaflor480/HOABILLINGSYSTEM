<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: index.php?error=Login%20First");
        die();
    }

    include 'config.php';

	$email = $_SESSION['email'];
	$conn_String = mysqli_connect("localhost", "root", "", "billing");
	$stmt = $conn_String->prepare("SELECT * FROM tableusers WHERE email = '{$_SESSION['email']}'");
	$stmt->execute();
	$result = $stmt->get_result()->fetch_assoc();
	
	if (!$result) {
		header("Location: index.php?error=Login%20First");
		exit();
	}


//    $query = mysqli_query($conn, "SELECT * FROM tableusers WHERE email='{$_SESSION['SESSION_EMAIL']}'");

  //  if (mysqli_num_rows($query) > 0) {
    //    $row = mysqli_fetch_assoc($query);

       // echo "Welcome " . $row['fname'] . " <a href='logout.php'>Logout</a>";
    //}
?>

<?php include('Sidebar.php');?>	

<!Doctype HTML>

<html>
	<head>
		<title>Admin</title>
		<!--<link rel="stylesheet" href="css/style1.css" type="text/css"/>-->
 

    </head>
  

<style>
	/* Box grid */
#main {
  transition: margin-left .5s;
  padding: 16px;
  
  padding-bottom: 100px;

}
.head{
    padding:20px;
}
.col-div-6{
    width: 50%;
    float: left;
}
.col-div-3{
    width: 25%;
    float: left;
}
.box{
    width: 85%;
    height: 110px;
    background-color: #272c4a;
    margin-left: 10px;
    padding:10px;
}
.box p{
  border-radius: 10px;
     font-size: 35px;
    color: white;
    font-weight: bold;
    line-height: 30px;
    padding-left: 10px;
    margin-top: 20px;
    display: inline-block;
}
.box p span{
    font-size: 20px;
    font-weight: 400;
    color: white;
}
.box-icons{
    font-size: 40px!important;
    float: right;
    margin-top: 20px!important;
    color: white;
    padding-right: 10px;
}
.col-div-8{
    width: 800px;
    height: auto;
}
.col-div-4{
    width: 30%;
    float: left;
}
.content-box{
    padding: 20px;
}
.content-box p{
      margin: 0px;
    font-size: 20px;
    color: #f7403b;
}
.content-box p span{
      float: right;
    
    padding: 3px 10px;
    font-size: 15px;
}
.box-8, .box-4{
    width: 95%;
    background-color: #272c4a;
    height: 330px;
    
}
.nav2{
    display: none;
}

.box-8{
    margin-left: 10px;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  
}
td, th {
  text-align: left;
  padding: 15px;
  color: #ddd;
  border-bottom: 1px solid #81818140;
}
#carouselExampleSlidesOnly {
    max-width: 47%; /* Adjust the percentage as needed */
    margin: 10px;   /* Center the carousel */
  }

  .carousel-inner img {
    border-radius: 5px;
    width: 100%;    /* Make images fill the container */
    height: 380px;
  }
  .announcement-box {
            width: 50%; /* Adjust the width as needed */
            background-color: #31304D;
            padding: 10px;
            margin-right: 5px;
            border-radius: 5px;
            color: white;   
            float: right; /* Align to the right */
        }
</style>

	
	<body>
  <section class="home-section">
     <div class="text"><li class="bi bi-person-fill" style="list-style: none;"></i> Hi <?php echo $row['fname']  ?>!</div>
	  <div id="main">
		
<div>  
<h4 style="font-weight: 500;">Welcome to Billing Management System</h4> 
</div>   
<?php 
include 'config.php';
$email = $_SESSION['email'];

$query = mysqli_query($conn, "SELECT * FROM tablebilling_list WHERE status='1' AND tableusers_id='?'");
if (mysqli_num_rows($query) > 0){
    $row = mysqli_fetch_assoc($query);
}
?>

		<div class="clearfix"></div>
		<br/>
		
		
		<div class="col-div-3">
<a href="billing.php">
    <div class="box" style="border-radius: 10px; background-color: #31304D; width: 90%">
        <p><?php echo $row['status'] ?? 0 ?><br/><span style="font-size: 15px">Payed Bills</span></p>
        <i class="bi bi-paypal box-icons"></i>
    </div>
    </a>
</div>


<?php
include 'config.php';
$email = $_SESSION['email'];

$query = mysqli_query($conn_String, "SELECT COUNT(id) AS numberofpending FROM tablebilling_list WHERE status = 2");
$row = mysqli_fetch_assoc($query);

if (mysqli_num_rows($query) > 0) {
    $numberofpending = $row['numberofpending'];
} else {
    $numberofpending = 2;
}
?>

<div class="col-div-3">
<a href="billing.php">
    <div class="box" style="border-radius: 10px; background-color: #31304D; width: 90%">
        <p><?php echo $numberofpending ?><br/><span style="font-size: 15px">Pending Billing</span></p>
        <i class="bi bi-receipt box-icons"></i>
    </div>
</a>
</div>
<?php 
include 'config.php';
$email = $_SESSION['email'];

// Assuming your tablecomplaint has a column for the user's email
$query = mysqli_query($conn, "SELECT COUNT(id) AS numberofcomplaint FROM tablecomplaint WHERE email = '$email' AND stats = 0");

if (mysqli_num_rows($query) > 0){
    $row = mysqli_fetch_assoc($query);
} else {
    $row['numberofcomplaint'] = 0;
}
?>
		
		<div class="col-div-3">
		<a href="complaint.php">
    <div class="box" style="border-radius: 10px; background-color: #31304D; width: 90%">
				<p><?php echo $row['numberofcomplaint']; ?><br/><span style="font-size: 15px">Unprocessed Complaint</span></p>
				<i class="bx bx-envelope box-icons"></i>
			</div>
    </a>
		</div>
<?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT datereg AS datetime from tableusers");
if (mysqli_num_rows($query) > 0){
     $row = mysqli_fetch_assoc($query);
 }
?>

		<div class="col-div-3">
			<div class="box" style="border-radius: 10px; background-color: #31304D; width: 90%; ">
				<p style="font-size: 1.2rem"><?php echo date("Y-m-d", strtotime($row['datetime'])); ?><br/><span style="font-size: 15px">Date Registered</span></p>
				<i class="bx bx-calendar box-icons"></i>
			</div>
		</div>
		<div class="clearfix"></div>
		<br/>
    <div class="announcement-box">
                <h4 style="font-weight: 500; font-size: 1.2rem;"><i class="bx bx-bell" type="solid"></i> Announcement</h4>
                <p style="font-size: 0.9rem;">- System Under Maintenance, sorry for the inconvenience. Unable to access the sidebar. Thank you!</p>
            </div>
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
        <img src="images/1pic.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/2pic.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="images/3pic.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
</div>

    </section>
  <!--
		<div class="col-div-4">
			<div class="box-4" style="border-radius: 10px;">
			<div class="content-box">
				<p>Total population <span>See All</span></p>

				<div class="circle-wrap">
	    <div class="circle">
	      <div class="mask full">
	        <div class="fill"></div>
	      </div>
	      <div class="mask half">
	        <div class="fill"></div>
	      </div>
	      <div class="inside-circle"> 70% </div>
	    </div>
	  </div>
			</div>
		</div>
		</div>
		
		<div class="clearfix"></div>
	</div>
-->

	</body>


	</html>