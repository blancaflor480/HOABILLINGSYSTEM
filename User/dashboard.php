<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: index.php");
        die();
    }

    include 'config.php';

	$email = $_SESSION['email'];
	$conn_String = mysqli_connect("localhost", "root", "", "billing");
	$stmt = $conn_String->prepare("SELECT * FROM tableaccount WHERE email = '{$_SESSION['email']}'");
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

<?php include('sidebar.php');?>	

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

</style>

	
	<body>
  <section class="home-section">
      <div class="text">Dashboard</div>
    
	  <div id="main">

		
		<!--<div class="col-div-6">
		<div class="profile">

			<img src="images/users.png" class="pro-img" />
			<i class="fa fa-user-circle-o" aria-hidden="true"></i>
			<p><?php echo $row['fname']  ?> <span><?php echo $row['type']  ?> </span></p>
		</div>
	</div>
		<div class="clearfix"></div>
	-->
<div>  
<h4 style="font-weight: 500;">Welcome to Billing Management System</h4> 
</div>   
<?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT count(id) AS numberofuser, id from tableusers");
if (mysqli_num_rows($query) > 0){
     $row = mysqli_fetch_assoc($query);
   
 }
?>

		<div class="clearfix"></div>
		<br/>
		
		
		<div class="col-div-3" >
			<div class="box" style="border-radius: 10px; background-color: #20A11E; width: 90%">
				<p><?php echo $row['numberofuser'] ?><br/><span style="font-size: 15px">Customers</span></p>
				<i class="bx bx-group box-icons"></i>
			</div>
		</div>
		<div class="col-div-3">
			<div class="box" style="border-radius: 10px; background-color: #A32525; width: 90%">
				<p>...<br/><span style="font-size: 15px">Billing</span></p>
				<i class="bx bx-objects-vertical-bottom box-icons"></i>
			</div>
		</div>
<!--< ?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT count(id) AS numberofcomplaint, id from complaint");
if (mysqli_num_rows($query) > 0){
     $row = mysqli_fetch_assoc($query);
 }
?>-->
		
		<div class="col-div-3">
			<div class="box" style="border-radius: 10px; background-color: #E5A603; width: 90%">
				<p><!--< ?php echo $row['numberofcomplaint']; ?>-->...<br/><span style="font-size: 15px">Unprocessed Complaint</span></p>
				<i class="bx bx-envelope box-icons"></i>
			</div>
		</div>
<!--< ?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT count(id) AS numberofcomplaint, id from complaint");
if (mysqli_num_rows($query) > 0){
     $row = mysqli_fetch_assoc($query);
 }
?>-->

		<div class="col-div-3">
			<div class="box" style="border-radius: 10px; background-color: #3251F6; width: 90%">
				<p><!--< ?php echo $row['numberofcomplaint']; ?>-->...<br/><span style="font-size: 15px">Rental House</span></p>
				<i class="bx bx-home box-icons"></i>
			</div>
		</div>
		<div class="clearfix"></div>
		<br/>
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