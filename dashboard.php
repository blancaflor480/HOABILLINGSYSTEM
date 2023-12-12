<?php
    session_start();
    if (!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: index.php");
        die();
    }

    include 'config.php';

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

       // echo "Welcome " . $row['fname'] . " <a href='logout.php'>Logout</a>";
    }
?>

<!Doctype HTML>
	<html>
	<head>
		<title>Dashboard | Users</title>
		<!--<link rel="stylesheet" href="css/style1.css" type="text/css"/>-->
		</head>

<?php include('slide.php');?>
	
	<body>
		
	  <div id="main">

		<div class="head">
			<div class="col-div-6">
	<span style="font-size:30px;cursor:pointer; color: #272c4a; font-weight: 600;" class="nav"  >☰ Dashboard</span>
	<span style="font-size:30px;cursor:pointer; color: #272c4a; font-weight: 600;" class="nav2"  >☰ Dashboard</span>
	</div>
		
		<div class="col-div-6">
		<div class="profile">

			<img src="images/users.png" class="pro-img" />
			<!--<i class="fa fa-user-circle-o" aria-hidden="true"></i>-->
			<p><?php echo $row['fname']  ?> <span></span></p>
		</div>
	</div>
		<div class="clearfix"></div>
	</div>

<!--<?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT count(id) AS numberofuser, id from users");
if (mysqli_num_rows($query) > 0){
     $row = mysqli_fetch_assoc($query);
   
 }
?>-->

		<div class="clearfix"></div>
		<br/>
		
		
		<div class="col-div-3"  >
			<div class="box" style="border-radius: 10px; background-color: green;">
				<p><!--<?php echo $row['numberofuser'] ?>-->...<br/><span>Payed Bills</span></p>
				<i class="fa fa-money box-icon"></i>
			</div>
		</div>
		<div class="col-div-3">
			<div class="box" style="border-radius: 10px; background-color: darkred;">
				<p>...<br/><span>Pending Bills</span></p>
				<i class="fa fa-tasks box-icon"></i>
			</div>
		</div>
<?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT count(Id) AS numberofadmin, id from admin");
if (mysqli_num_rows($query) > 0){
     $row = mysqli_fetch_assoc($query);
 }
?>
		
		<div class="col-div-3">
			<div class="box" style="border-radius: 10px; background-color: #DB793D;">
				<p><?php echo $row['numberofadmin']; ?><br/><span>Accounts</span></p>
				<i class="fa fa-user box-icon"></i>
			</div>
		</div>
<?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT count(id) AS numberofcomplaint, id from complaint");
if (mysqli_num_rows($query) > 0){
     $row = mysqli_fetch_assoc($query);
 }
?>

		<div class="col-div-3">
			<div class="box" style="border-radius: 10px; background-color: #1659B2;">
				<p><?php echo $row['numberofcomplaint']; ?><br/><span>Complaints</span></p>
				<i class="fa fa-list-alt box-icon"></i>
			</div>	
		</div>
		<div class="clearfix"></div>
		<br/><br/>
<?php 
include 'config.php';
$query = mysqli_query($conn, "SELECT * FROM users");
?>

		<div class="col-div-8">
			<div class="box-8" style="border-radius: 10px;">
			<div class="content-box">
				<!--<p>All Customers <span>See</span></p>-->
				<br/>
				<table>
	  <tr>
	    <!--<th>Name</th>
	    <th>Contact</th>
	    <th>Address</th>-->
	  </tr>
	   <!--<?php
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</td>";
                    echo "<td>" . $row['contact'] . "</td>"; // Adjust 'contact' based on your actual column name
                    echo "<td>" . $row['address'] . "</td>"; // Adjust 'address' based on your actual column name
                    echo "</tr>";
                }
                ?>-->
         <h2 style="color: white; text-align: center; padding: 50px;">Calendar Undermaintainance..</h2>
	  
	</table>
			</div>
		</div>
		</div>

		<div class="col-div-4">
			<div class="box-4" style="border-radius: 10px;">
			<div class="content-box">
<!--				<p>Total population <span>See All</span></p>

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
	  </div> -->
	  <h1 style="color: white; font-size: 20px; text-align: center; padding: 60px;">Under Maintainance..</h1>
			</div>
		</div>
		</div>
			
		<div class="clearfix"></div>
	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>

	  $(".nav").click(function(){
	    $("#mySidenav").css('width','70px');
	    $("#main").css('margin-left','70px');
	    $(".logo").css('visibility', 'hidden');
	    $(".logo span").css('visibility', 'visible');
	     $(".logo span").css('margin-left', '-10px');
	     $(".icon-a").css('visibility', 'hidden');
	     $(".icons").css('visibility', 'visible');
	     $(".icons").css('margin-left', '-8px');
	      $(".nav").css('display','none');
	      $(".nav2").css('display','block');
	  });

	$(".nav2").click(function(){
	    $("#mySidenav").css('width','300px');
	    $("#main").css('margin-left','300px');
	    $(".logo").css('visibility', 'visible');
	     $(".icon-a").css('visibility', 'visible');
	     $(".icons").css('visibility', 'visible');
	     $(".nav").css('display','block');
	      $(".nav2").css('display','none');
	 });

	</script>

	</body>


	</html>